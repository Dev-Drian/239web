<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Client;
use App\Services\GenerateContentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{

    protected GenerateContentService $contentService;

    public function __construct(GenerateContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function try() {}

    public function index(Request $request)
    {

        $clients = Client::query(); // Cambia "User" por tu modelo de cliente si es diferente
        $search = $request->input('search');

        if ($search) {
            $clients->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhere('highlevel_id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%'); // Nueva línea para buscar por nombre

            });
        }
        $clients = $clients->paginate(10);
        return view('blog.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::where('highlevel_id', $id)->first();

        return view('blog.show', compact('client'));
    }






    public function create(Request $request, $id)
    {
        try {
            // 1. Obtener el cliente
            $client = Client::where('highlevel_id', $id)->firstOrFail();

            // 2. Obtener parámetros de la URL
            $encodedTopic = $request->query('topic');
            $encodedModel = $request->query('model');
            $forceRefresh = $request->query('refresh', false);

            // 3. Crear clave única para el caché
            $cacheKey = 'blog_content:' . $id . ':' . md5($encodedTopic . $encodedModel);

            // 4. Verificar caché si no se fuerza refresco
            if (!$forceRefresh && Cache::has($cacheKey)) {
                $cachedData = Cache::get($cacheKey);

                return view('blog.create', [
                    'client' => $client,
                    'topic' => $cachedData['topic'],
                    'model' => $cachedData['model'],
                    'generatedContent' => $cachedData['content']
                ]);
            }

            // 5. Procesamiento cuando no hay caché o se fuerza refresco
            $topic = json_decode(urldecode($encodedTopic), true);
            $model = urldecode($encodedModel);

            // 5.1 Obtener datos dinámicos del cliente
            $clientData = $this->getClientDynamicData($client);

            $prompt = $this->buildPrompt($topic) . "\n\nWrite a professional, first-person article from the perspective of {$clientData['company_name']} in {$clientData['city']}. The article must:\n• Be based on the selected blog topic.\n• Use clear, formal, and engaging language suitable for a business audience.\n• Be structured in paragraphs with appropriate subtitles (use H2 and H3 as needed).\n• Include at least one section with bullet points or listicle where relevant.\n• Mention the company name no more than twice in the entire article.\n• Be between 800 and 1500 words.\n• Avoid using words like \"moreover\" or \"conclusion.\"\n• Do not include a concluding section titled \"Conclusion.\"\n• Focus on promoting the company's strengths, expertise, and unique value in the first person (\"we,\" \"our,\" \"us\").\n• Ensure the article is original and does not copy content from external sources.\n• Format subtitles for clarity and impact.\n";
            if (!empty($clientData['city'])) {
                $prompt .= "• Include relevant information about {$clientData['city']} and the local market.\n";
            }
            if (!empty($clientData['services'])) {
                $prompt .= "• Mention the company's expertise in {$clientData['services']}.\n";
            }
            $prompt .= "\nExample structure:\n1. Subtitle 1: Key Aspect or Benefit\n   ◦ Detailed paragraph(s)\n2. Subtitle 2: Another Relevant Section\n   ◦ Detailed paragraph(s)\n   ◦ Bullet points or listicle if appropriate\n3. Subtitle 3: Additional Insights or Case Study\n   ◦ Detailed paragraph(s)\n4. Subtitle 4: Call to Action or Future Outlook\n   ◦ Detailed paragraph(s)";



            $systemContent = "You are an expert copywriter. Please follow the instructions in the prompt to generate the content.";

            // 6. Generar contenido (parte más costosa)
            $generatedContent = match ($model) {
                'gpt', 'perplexity' => $this->contentService->generateContentGPT($systemContent, $prompt),
                default => $prompt
            };

            // 7. Limpiar contenido generado
            $generatedContent = str_replace(['```html', '```'], '', $generatedContent);
            $generatedContent = $this->removeTitleFromContent($topic['title'], $generatedContent);

            // Log temporal para verificar el contenido
            Log::info('Generated content for blog', [
                'topic' => $topic['title'],
                'content_length' => strlen($generatedContent),
                'content_preview' => substr($generatedContent, 0, 200) . '...'
            ]);

            // 8. Almacenar en caché (30 minutos)
            Cache::put($cacheKey, [
                'topic' => $topic,
                'model' => $model,
                'content' => $generatedContent
            ], now()->addMinutes(30));

            // 9. Retornar vista con datos
            return view('blog.create', compact('client', 'topic', 'model', 'generatedContent'));
        } catch (\Exception $e) {
            // Manejo de errores
            Log::error("Error generating blog content: " . $e->getMessage());
            return back()->with('error', 'Error generating content. Please try again.');
        }
    }
    private function removeTitleFromContent($title, $content)
    {
        // Expresión regular para eliminar la etiqueta <h1> que contiene el título
        $pattern = '/<h1>\s*' . preg_quote($title, '/') . '\s*<\/h1>/i';
        return preg_replace($pattern, '', $content);
    }


    public function indexer($id)
    {
        $blog = Blog::where('blog_id', $id)->first();

        if (!$blog) {
            return response()->json(['message' => 'Blog no encontrado'], 404);
        }

        if ($blog->indexed) {
            return response()->json(['message' => 'El blog ya está indexado']);
        }

        // Marcar el blog como indexado
        $blog->is_indexed = true;
        $blog->save();

        return response()->json(['message' => 'El blog ha sido indexado']);
    }

    /**
     * Procesa una imagen subida para el blog
     */
    public function uploadImage(Request $request, $id)
    {
        try {
            $client = Client::where('highlevel_id', $id)->firstOrFail();
            
            // Validar request
            $request->validate([
                'uploaded_image' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:5120',
                'image_url' => 'nullable|url',
            ]);

            $imageUrl = null;

            // Procesar archivo subido
            if ($request->hasFile('uploaded_image')) {
                $imageUrl = $this->processUploadedImage($request->file('uploaded_image'), $client->website);
            }
            // Procesar URL de imagen
            elseif (!empty($request->input('image_url'))) {
                $imageUrl = $this->validateAndProcessImageUrl($request->input('image_url'), $client->website);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'No image provided'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image processed successfully',
                'data' => [
                    'image_url' => $imageUrl
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una imagen procesada
     */
    public function deleteImage(Request $request, $id)
    {
        try {
            $client = Client::where('highlevel_id', $id)->firstOrFail();
            
            $request->validate([
                'image_url' => 'required|string',
            ]);

            $imageUrl = $request->input('image_url');
            $deleted = $this->deleteImageFromServer($imageUrl);

            return response()->json([
                'success' => true,
                'message' => $deleted ? 'Image deleted successfully' : 'Image not found on server',
                'deleted' => $deleted
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Construye el prompt a partir del tema.
     */
    private function buildPrompt(array $topic): string
    {
        $prompt = "Using the given title and subtitles, create an 800 to 1000 word comprehensive informative blog post in a conversational and engaging tone, using HTML formatting on the topic. Use proper HTML formatting such as <h1> for the title, <h2> for subheadings (do not put any numbers or symbols in front of the subheadings), and <p> for paragraphs. Write in the first person with fully detailed long in-depth paragraphs. Limit the use of bullet point lists or numbered lists. Do use the words: we, us, our. Do not add a conclusion. Do not use the word section, moreover, or furthermore. Remember you are a company offering your services and the article should appeal to your audience. Mention at the end a small paragraph about your company. Do NOT create an intro at the beginning about the city or the service - start directly with the content\n\n";
        $prompt .= "<h1>" . $topic['title'] . "</h1>\n";
        foreach ($topic['subtitles'] as $subtitle) {
            if (!empty($subtitle)) {
                $prompt .= "<h2>" . $subtitle . "</h2>\n<p></p>\n";
            }
        }
        return $prompt;
    }
    public function store(Request $request, $id)
    {
        try {
            $client = Client::where('highlevel_id', $id)->firstOrFail();
            $validatedData = $this->validateRequest($request);

            // Extract and format the title
            $validatedData['title'] = $this->extractTitle($validatedData['content'], $validatedData['title'] ?? null);

            // Debug logging
            Log::info('Processing blog post creation', [
                'website' => $validatedData['website'],
                'title' => $validatedData['title'],
                'has_image' => !empty($validatedData['generated_image']),
                'generated_image' => $validatedData['generated_image'] ?? 'none'
            ]);

            // Handle image upload if present
            $featuredImageId = null;
            $formattedImageUrl = null;

            // Check for uploaded image first
            if ($request->hasFile('uploaded_image')) {
                $formattedImageUrl = $this->processUploadedImage($request->file('uploaded_image'), $validatedData['website']);
                Log::info('Processed uploaded image', ['url' => $formattedImageUrl]);
            }
            // Check for image URL
            elseif (!empty($validatedData['image_url'])) {
                $formattedImageUrl = $this->validateAndProcessImageUrl($validatedData['image_url'], $validatedData['website']);
                Log::info('Processed image URL', ['url' => $formattedImageUrl]);
            }
            // Check for processed image URL (from uploadImage endpoint)
            elseif (!empty($validatedData['generated_image'])) {
                // If it's already a full URL, use it directly
                if (filter_var($validatedData['generated_image'], FILTER_VALIDATE_URL)) {
                    $formattedImageUrl = $validatedData['generated_image'];
                } else {
                    $formattedImageUrl = $this->formatImageUrl($validatedData['website'], $validatedData['generated_image']);
                }
                Log::info('Using processed image URL', ['url' => $formattedImageUrl]);
            }

            // Upload image to WordPress if we have one
            if ($formattedImageUrl) {
                $featuredImageId = $this->uploadImageToWordPress(
                    $validatedData['website'],
                    $formattedImageUrl
                );

                if (!$featuredImageId) {
                    throw new \Exception('Failed to upload image to WordPress');
                }

                Log::info('Image uploaded to WordPress', ['featured_image_id' => $featuredImageId]);
            }

            // Create WordPress post
            $postData = $this->preparePostData($validatedData, $featuredImageId);
            $postResponse = $this->createWordPressPost($validatedData['website'], $postData);

            if (!$postResponse->successful()) {
                Log::error('WordPress post creation failed', [
                    'status' => $postResponse->status(),
                    'response' => $postResponse->json() ?? $postResponse->body()
                ]);
                throw new \Exception('Failed to create WordPress post: ' . ($postResponse->json('message') ?? 'Unknown error'));
            }

            $permalink = $postResponse->json('permalink');
            $postId = $postResponse->json('post_id');

            $blog = Blog::create([
                'title' => $validatedData['title'],
                'posts' => $postId,
                'fbsent' => null,          // Llenar si es necesario más adelante
                'prsent' => null,
                'indexed' => null,
                'img' => $formattedImageUrl,
                'date_created' => Carbon::now(),
                'client_id' => $client->id,
            ]);


            // Log::info('Blog saved to local database', ['blog_id' => $blog->id]);

            return response()->json([
                'success' => true,
                'message' => 'Blog post created successfully',
                'data' => [
                    'post_id' => $postId,
                    'permalink' => $permalink,
                    'featured_image' => $formattedImageUrl
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Blog post creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating blog post: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'content' => 'required|string',
            'website' => 'required|url',
            'generated_image' => 'nullable|string',
            'uploaded_image' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'image_url' => 'nullable|url',
            'schedule_date' => 'nullable|date',
            'post_status' => 'required|string|in:draft,publish,schedule',
            'categories' => 'nullable|array',
            'categories.*' => 'integer',
            'title' => 'nullable|string'
        ]);
    }

    private function extractTitle($content, $providedTitle = null)
    {
        // If title is provided, use it
        if (!empty($providedTitle)) {
            return $providedTitle;
        }

        // Extract title from H1 tag if present
        if (preg_match('/<h1>(.*?)<\/h1>/i', $content, $matches)) {
            $title = strip_tags($matches[1]);
            // Optionally remove the H1 tag from content like in the old code
            // $content = preg_replace('/<h1>.*?<\/h1>/', '', $content);
            return $title;
        }

        // Fallback to first line if no H1 tag
        $firstLine = strtok($content, "\n");
        return strip_tags($firstLine);
    }

    private function formatImageUrl($website, $imageUrl)
    {
        if (empty($imageUrl)) {
            return null;
        }

        // If the URL is already absolute, return it
        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return $imageUrl;
        }

        // Match the old code's behavior - use the specific prefix for relative paths
        if (!preg_match('/^http/', $imageUrl)) {
            return 'https://clients.limopartner.com/new/blogs/' . ltrim($imageUrl, '/');
        }

        // Fallback to website-based URL (from your original new code)
        return rtrim($website, '/') . '/' . ltrim($imageUrl, '/');
    }

    private function uploadImageToWordPress($website, $imageUrl)
    {
        try {
            $uploadUrl = rtrim($website, '/') . '/wp-json/limo-blogs/v1/upload-image';

            Log::info('Iniciando carga de imagen a WordPress', [
                'upload_url' => $uploadUrl,
                'image_url' => $imageUrl
            ]);

            $startTime = microtime(true);

            // Verifica la URL de la imagen con un timeout menor
            $ch = curl_init($imageUrl);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout de 5 segundos
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$result || $httpCode != 200) {
                Log::error('La URL de la imagen no es accesible', [
                    'url' => $imageUrl,
                    'http_code' => $httpCode
                ]);
                throw new \Exception('La URL de la imagen no es accesible: ' . $imageUrl . ' (Código: ' . $httpCode . ')');
            }

            // Hace la solicitud con timeout reducido
            $response = Http::timeout(15) // Reducido de 30 a 15 segundos
                ->withOptions([
                    'verify' => false,
                    'connect_timeout' => 10,
                ])
                ->post($uploadUrl, [
                    'image_url' => $imageUrl
                ]);

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $statusCode = $response->status();
            $responseJson = $response->json();

            Log::info('Respuesta de carga de imagen', [
                'status' => $statusCode,
                'tiempo_segundos' => $duration,
                'response' => $responseJson
            ]);

            if (!$response->successful()) {
                Log::error('Falló la carga de imagen a WordPress', [
                    'status' => $statusCode,
                    'response' => $responseJson,
                    'tiempo_segundos' => $duration
                ]);

                throw new \Exception('Falló la carga de imagen a WordPress: ' .
                    ($responseJson['message'] ?? 'Código de estado: ' . $statusCode));
            }

            if (empty($responseJson['id'])) {
                Log::error('WordPress no devolvió ID de imagen', ['response' => $responseJson]);
                throw new \Exception('WordPress no devolvió ID de imagen');
            }

            Log::info('Imagen cargada correctamente', [
                'id' => $responseJson['id'],
                'tiempo_total' => $duration . ' segundos'
            ]);

            return $responseJson['id'];
        } catch (\Exception $e) {
            Log::error('Error en carga de imagen', [
                'error' => $e->getMessage(),
                'image_url' => $imageUrl,
                'website' => $website
            ]);

            throw new \Exception('Falló la carga de imagen: ' . $e->getMessage());
        }
    }


    private function preparePostData($data, $featuredImageId = null)
    {
        // Get the content and find the first H1 tag
        $content = $data['content'];
        $firstH1Position = stripos($content, '</h1>');

        $postData = [
            'title' => $data['title'],
            'status' => $data['post_status'] ?? 'draft',
            'categories' => $data['categories'] ?? [],
        ];

        // If we have a featured image, insert it after the first H1 tag
        if ($featuredImageId) {
            $postData['featured_image'] = $featuredImageId;

            // Only insert the image in content if we found an H1 tag
            if ($firstH1Position !== false) {
                // Insert image shortcode after the H1
                $imageHtml = '<!-- wp:image {"id":' . $featuredImageId . ',"sizeSlug":"large","align":"center"} -->';
                $imageHtml .= '<figure class="wp-block-image aligncenter size-large">';
                $imageHtml .= '[caption]<img src="" class="wp-image-' . $featuredImageId . '"/>[/caption]';
                $imageHtml .= '</figure>';
                $imageHtml .= '<!-- /wp:image -->';

                // Split content and insert image
                $beforeImage = substr($content, 0, $firstH1Position + 5); // +5 for </h1>
                $afterImage = substr($content, $firstH1Position + 5);
                $content = $beforeImage . "\n" . $imageHtml . "\n" . $afterImage;
            }
        }

        $postData['content'] = $content;

        // Handle scheduling
        if (($data['post_status'] ?? '') === 'schedule' && !empty($data['schedule_date'])) {
            $postData['date'] = date('Y-m-d\TH:i:s', strtotime($data['schedule_date']));
        }

        return $postData;
    }
    private function getImageUrlFromWordPress($website, $imageId)
    {
        try {
            $imageEndpoint = rtrim($website, '/') . '/wp-json/wp/v2/media/' . $imageId;

            Log::info('Obteniendo URL de imagen desde WordPress', [
                'endpoint' => $imageEndpoint,
                'image_id' => $imageId
            ]);

            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->get($imageEndpoint);

            if (!$response->successful()) {
                Log::warning('No se pudo obtener la URL de la imagen', [
                    'status' => $response->status(),
                    'response' => $response->json() ?? $response->body()
                ]);
                return null;
            }

            // WordPress devuelve la URL en diferentes tamaños, usar source_url o guid para tamaño completo
            $imageUrl = $response->json('source_url') ?? $response->json('guid.rendered');

            Log::info('URL de imagen obtenida', ['url' => $imageUrl]);

            return $imageUrl;
        } catch (\Exception $e) {
            Log::error('Error al obtener URL de imagen', [
                'error' => $e->getMessage(),
                'image_id' => $imageId,
                'website' => $website
            ]);

            return null;
        }
    }



    private function createWordPressPost($website, $postData)
    {
        $postUrl = rtrim($website, '/') . '/wp-json/limo-blogs/v1/post';

        Log::info('Creating WordPress post', [
            'post_url' => $postUrl,
            'post_data' => array_merge($postData, ['content' => '[Content omitted from log]'])
        ]);

        return Http::timeout(30)
            ->withOptions(['verify' => false]) // Skip SSL verification if needed
            ->post($postUrl, $postData);
    }

    private function storeInLocalDatabase($website, $title, $permalink, $imageUrl, $id)
    {
        $blogData = [
            'website' => $website,
            'title' => $title,
            'posts' => $permalink,
            'img' => $imageUrl,
            'client_id' => $id,
            'date_created' => now()
        ];

        Log::info('Storing blog in local database', $blogData);

        return Blog::create($blogData);
    }

    /**
     * Obtiene datos dinámicos del cliente para el prompt.
     */
    private function getClientDynamicData($client)
    {
        // Nombre de la empresa
        $companyName = $client->name ?? 'Our Company';
        // Ciudad principal para artículos (prioridad: primary_city > city > formatted_address)
        $city = $client->primary_city ?? $client->city ?? ($client->clientLocations->formatted_address ?? '');
        // Servicios (puedes ajustar esto según tu modelo, aquí ejemplo genérico)
        $services = '';
        if ($client->clientDetails && !empty($client->clientDetails->full_name)) {
            $services = $client->clientDetails->full_name;
        } elseif ($client->rol) {
            $services = $client->rol;
        } else {
            $services = 'our main services';
        }
        return [
            'company_name' => $companyName,
            'city' => $city,
            'services' => $services,
        ];
    }

    /**
     * Procesa una imagen subida por el usuario
     */
    private function processUploadedImage($file, $website)
    {
        try {
            // Validar el archivo
            if (!$file->isValid()) {
                throw new \Exception('Invalid file upload');
            }

            // Generar nombre único para el archivo
            $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Crear directorio si no existe
            $uploadPath = public_path('uploads/blog-images');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Mover el archivo
            $filePath = $uploadPath . '/' . $fileName;
            $file->move($uploadPath, $fileName);

            // Retornar URL pública
            return url('uploads/blog-images/' . $fileName);
        } catch (\Exception $e) {
            Log::error('Error processing uploaded image: ' . $e->getMessage());
            throw new \Exception('Failed to process uploaded image: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una imagen del servidor
     */
    private function deleteImageFromServer($imageUrl)
    {
        try {
            // Extract file path from URL
            $parsedUrl = parse_url($imageUrl);
            if (isset($parsedUrl['path'])) {
                $filePath = public_path($parsedUrl['path']);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                    Log::info('Image deleted from server', ['path' => $filePath]);
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Valida y procesa una URL de imagen
     */
    private function validateAndProcessImageUrl($imageUrl, $website)
    {
        try {
            // Validar que la URL sea accesible
            $ch = curl_init($imageUrl);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$result || $httpCode != 200) {
                throw new \Exception('Image URL is not accessible: ' . $imageUrl . ' (HTTP Code: ' . $httpCode . ')');
            }

            // Descargar la imagen
            $imageContent = file_get_contents($imageUrl);
            if (!$imageContent) {
                throw new \Exception('Failed to download image from URL');
            }

            // Determinar extensión del archivo
            $extension = 'jpg'; // default
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            if (strpos($contentType, 'png') !== false) {
                $extension = 'png';
            } elseif (strpos($contentType, 'webp') !== false) {
                $extension = 'webp';
            }

            // Generar nombre único
            $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Crear directorio si no existe
            $uploadPath = public_path('uploads/blog-images');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Guardar el archivo
            $filePath = $uploadPath . '/' . $fileName;
            file_put_contents($filePath, $imageContent);

            // Retornar URL pública
            return url('uploads/blog-images/' . $fileName);
        } catch (\Exception $e) {
            Log::error('Error processing image URL: ' . $e->getMessage());
            throw new \Exception('Failed to process image URL: ' . $e->getMessage());
        }
    }
}
