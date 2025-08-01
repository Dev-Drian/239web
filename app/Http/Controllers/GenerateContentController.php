<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\GenerateContentService;
use Illuminate\Http\Request;

class GenerateContentController extends Controller
{
    protected GenerateContentService $contentService;

    public function __construct(GenerateContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Genera contenido utilizando la IA de OpenAI.
     */
    public function generateContentGPT(Request $request)
    {
        $this->validatePrompt($request);
        $prompt = $request->input('prompt');
        $systemContent = 'You are an expert copywriter. Please provide a list of 6 blog topics with 3 to 5 subtitles for each topic. Use "### Topic X:" to denote titles and "- ***" to denote subtitles. Do not include the name of the company in each subtitle, mix and match';
        $content = $this->contentService->generateContentGPT($systemContent, $prompt);

        return response()->json([
            'content' => $content,
        ]);
    }

    /**
     * Genera contenido utilizando la IA de Perplexity.
     */
    public function generateContentPerplexity(Request $request)
    {
        $this->validatePrompt($request);
        $prompt = $request->input('prompt');
        $systemContent = 'You are an expert copywriter. Please provide a list of 6 blog topics with 3 to 5 subtitles for each topic. Use "### Topic X:" to denote titles and "- ***" to denote subtitles. Do not include the name of the company in each subtitle, mix and match';
        $content = $this->contentService->generateContentPerplexity($systemContent, $prompt);

        return response()->json([
            'content' => $content,
        ]);
    }


    public function generateMetaTitle(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');
        $metaTitle = $this->contentService->generateMetaTitle($prompt);

        // Strip any quotes that might be present in the response
        $metaTitle = trim($metaTitle, '"');

        return response()->json([
            'success' => true,
            'content' => $metaTitle
        ]);
    }


    /**
     * Genera una meta descripción.
     */
    public function generateMetaDescription(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');
        $metaDescription = $this->contentService->generateMetaDescription($prompt);
        $metaDescription = trim($metaDescription, '');


        return response()->json([
            'success' => true,
            'content' => $metaDescription
        ]);
    }

    public function generateExtraBlog(Request $request)
    {
        $prompt = $request->input('prompt');

        $generatedContent = $this->contentService->generateExtraBlog($prompt);

        if ($generatedContent) {
            return response()->json(['content' => $generatedContent]);
        }

        return response()->json(['error' => 'Error generating content.'], 500);
    }

    public function generateNearbyCitiesAndAirports(Request $request, $id)
    {
        // Validar que el campo 'city' esté presente y no esté vacío
        $request->validate([
            'city' => 'required|string|min:1',
        ]);

        $client = Client::where('highlevel_id', $id)->first();
        if (!$client)  return response()->json(['message' => 'User is not authenticated'], 401);

        // Obtener la ciudad del request
        $city = trim($request->input('city'));

        // Llamar al servicio para generar la lista de ciudades y aeropuertos cercanos
        $result = $this->contentService->generateNearbyCitiesAndAirports($city);

        // Verificar si se generó contenido correctamente
        if ($result) {
            return response()->json(['data' => $result]);
        }

        // Devolver un error en caso de fallo
        return response()->json(['error' => 'Error generating nearby cities and airports.'], 500);
    }



    public function generateContentLong(Request $request)
    {
        $this->validatePrompt($request);

        $prompt = $request->input('prompt');
        $systemContent = 'You are an expert copywriter. Please keep your response between 275 and 325 characters.';
        $content = $this->contentService->generateContentGPT($systemContent, $prompt);

        return response()->json([
            'content' => $content,
        ]);
    }


    public function generateContentShort(Request $request)
    {
        $this->validatePrompt($request);
        $prompt = $request->input('prompt');
        $systemContent = 'You are an expert copywriter. Please keep your response between 150 and 256 characters.';
        $content = $this->contentService->generateContentGPT($systemContent, $prompt);

        return response()->json([
            'content' => $content,
        ]);
    }

    public function generateContentSpun(Request $request)
    {
        $this->validatePrompt($request);
        $prompt = $request->input('prompt');
        $systemContent = 'You are an expert copywriter. Write a detailed description.';
        $content = $this->contentService->generateContentGPT($systemContent, $prompt);


        $systemSpintax = 'YOu are an expert copywriter. Please respond in spintax format, where multiple options are separated by pipes | and groups of options are enclosed in curly braces {}';
        $prompt_spintax =  'Convert the following description into spintax format with multiple options for words and phrases:' . $content;

        $content = $this->contentService->generateContentGPT($systemSpintax, $prompt_spintax);

        return response()->json([
            'content' => $content,
        ]);
    }
    public function generateContentKeywords(Request $request)
    {
        $this->validatePrompt($request);
        $prompt = $request->input('prompt');
        $systemContent = 'You are an SEO expert. Generate a list of keywords relevant to the limousine and black car service industry. Return the keywords as a comma-separated list without numbers.';
        $keywords = $this->contentService->generateContentGPT($systemContent, $prompt);

        return response()->json([
            'content' => $keywords,
        ]);
    }


    public function generateAds(Request $request)
    {
        try {
            $validated = $request->validate([
                'city' => 'required|string',
                'state' => 'required|string',
                'service_type' => 'required|string',
                'keywords' => 'required',
                'base_title' => 'sometimes|string',
                'base_content' => 'sometimes|string',
                'final_url' => 'sometimes|string|url',
                'path1' => 'sometimes|string|max:15',
                'path2' => 'sometimes|string|max:15'
            ]);

            // Process keywords
            $keywordsArray = array_map(function ($keyword) {
                return isset($keyword['text']) ? $keyword['text'] : $keyword;
            }, $validated['keywords']);

            $keywords = implode(', ', $keywordsArray);
            $location = $validated['city'] . ', ' . $validated['state'];

            // Set default URL if not provided
            $finalUrl = $validated['final_url'] ?? 'https://example.com';
            $path1 = $validated['path1'] ?? 'transport';
            $path2 = $validated['path2'] ?? 'premium';

            $systemContent =
                <<<PROMPT
                You are an expert in Google Ads for executive transportation services. Generate exactly 2 responsive search ads (RSA) with:
    
                **REQUIREMENTS:**
                1. Strict JSON format with:
                - headlines: array of 7-15 objects (text + pinned_field)
                - descriptions: array of 4 objects (text + pinned_field)
                - path1 and path2 (15 chars max each)
                - final_url
    
                2. Mandatory content:
                - Location: {$location}
                - Keywords: {$keywords}
                - Service type: {$validated['service_type']}
    
                3. Output structure:
                [
                    {
                        "headlines": [
                            {"text": "Text 1", "pinned_field": "HEADLINE_1"},
                            {"text": "Text 2", "pinned_field": null},
                            {"text": "Text 3", "pinned_field": null}
                        ],
                        "descriptions": [
                            {"text": "Desc 1", "pinned_field": "DESCRIPTION_1"},
                            {"text": "Desc 2", "pinned_field": null}
                        ],
                        "path1": "{$path1}",
                        "path2": "{$path2}",
                        "final_url": "{$finalUrl}"
                    },
                    {
                        "headlines": [
                            {"text": "Text 1", "pinned_field": "HEADLINE_1"},
                            {"text": "Text 2", "pinned_field": null},
                            {"text": "Text 3", "pinned_field": null}
                        ],
                        "descriptions": [
                            {"text": "Desc 1", "pinned_field": "DESCRIPTION_1"},
                            {"text": "Desc 2", "pinned_field": null}
                        ],
                        "path1": "{$path1}",
                        "path2": "{$path2}",
                        "final_url": "{$finalUrl}"
                    }
                ]
    
                4. Strict rules:
                - Each headline must be max 30 characters
                - Each description must be max 90 characters
                - Each ad must have exactly 1 headline pinned as HEADLINE_1
                - Each ad must have exactly 1 description pinned as DESCRIPTION_1
                - Non-pinned texts should be creative variations
                - Use the provided keywords naturally
                
                5. Headline optimization:
                - Create highly diverse headlines - avoid ANY repetition of phrases or concepts
                - Each headline must have a distinct angle or benefit
                - Prioritize high-intent keywords in headlines (e.g., "Book", "Reserve", "Hire")
                - Include location-specific headlines
                - Use popular industry keywords strategically in different headlines
                - Include numbers and specific benefits when possible (e.g., "24/7 Service", "15-Min Pickup")
                - Mix question headlines with statement headlines for variety
                - Include at least 2 headlines with strong CTAs
                
                6. Description optimization:
                - Include relevant call-to-actions in descriptions
                - Emphasize different benefits in each description
                - Include social proof elements (e.g., "Trusted by executives")
                - Address specific pain points (e.g., "No waiting time", "Always on time")
                - Optimize for professional corporate transportation services
                
                7. Ad effectiveness:
                - Create meaningful variations that target different user intents
                - Ensure enough content variety to maximize ad relevance scores
                - Write conversational, natural-sounding headlines that avoid keyword stuffing
                - Balance promotional language with informative content
                - Include industry-specific terminology that resonates with target audience
                PROMPT;

            $userContent = "Generate 2 RSA ads for {$validated['service_type']} in {$location} using these keywords: {$keywords}. Focus on corporate limo and black car services. Include airport transfers as a key service.";

            $content = $this->contentService->generateContentPerplexity($systemContent, $userContent);

            // Parse JSON
            $ads = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error parsing generated ads');
            }

            // Validate basic structure and RSA requirements
            foreach ($ads as $index => $ad) {
                if (!isset($ad['headlines'], $ad['descriptions'])) {
                    throw new \Exception('Invalid ad structure');
                }

                // Validate headlines
                if (count($ad['headlines']) < 3 || count($ad['headlines']) > 15) {
                    throw new \Exception('Each ad must have between 3 and 15 headlines');
                }

                $pinnedHeadlines = array_filter($ad['headlines'], function ($h) {
                    return $h['pinned_field'] === 'HEADLINE_1';
                });

                if (count($pinnedHeadlines) !== 1) {
                    throw new \Exception('Each ad must have exactly 1 headline pinned as HEADLINE_1');
                }

                // Check headline length
                foreach ($ad['headlines'] as $headline) {
                    if (strlen($headline['text']) > 30) {
                        $ads[$index]['headlines'] = array_map(function ($h) {
                            if (strlen($h['text']) > 30) {
                                $h['text'] = substr($h['text'], 0, 30);
                            }
                            return $h;
                        }, $ad['headlines']);
                    }
                }

                // Validate descriptions
                if (count($ad['descriptions']) < 2 || count($ad['descriptions']) > 4) {
                    throw new \Exception('Each ad must have between 2 and 4 descriptions');
                }

                $pinnedDescriptions = array_filter($ad['descriptions'], function ($d) {
                    return $d['pinned_field'] === 'DESCRIPTION_1';
                });

                if (count($pinnedDescriptions) !== 1) {
                    throw new \Exception('Each ad must have exactly 1 description pinned as DESCRIPTION_1');
                }

                // Check description length
                foreach ($ad['descriptions'] as $description) {
                    if (strlen($description['text']) > 90) {
                        $ads[$index]['descriptions'] = array_map(function ($d) {
                            if (strlen($d['text']) > 90) {
                                $d['text'] = substr($d['text'], 0, 90);
                            }
                            return $d;
                        }, $ad['descriptions']);
                    }
                }

                // Validate paths
                if (isset($ad['path1']) && strlen($ad['path1']) > 15) {
                    $ads[$index]['path1'] = substr($ad['path1'], 0, 15);
                }

                if (isset($ad['path2']) && strlen($ad['path2']) > 15) {
                    $ads[$index]['path2'] = substr($ad['path2'], 0, 15);
                }
            }

            return response()->json([
                'success' => true,
                'ads' => $ads,
                'formatted_ads' => $this->formatRSAsForDisplay($ads, $validated['city'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function formatRSAsForDisplay(array $rsaAds, string $city): array
    {
        return array_map(function ($ad) use ($city) {
            return [
                'headlines' => $ad['headlines'],
                'descriptions' => $ad['descriptions'],
                'path1' => $ad['path1'] ?? 'servicio',
                'path2' => $ad['path2'] ?? 'ejecutivo',
                'final_url' => $ad['final_url'] ?? $this->generateDefaultUrl($city, $ad['path1'] ?? '', $ad['path2'] ?? '')
            ];
        }, $rsaAds);
    }

    private function generateDefaultUrl(string $city, string $path1, string $path2): string
    {
        $base = config('app.url');
        $citySlug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $city));
        $path1Slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $path1));
        $path2Slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $path2));

        return "{$base}/{$path1Slug}/{$path2Slug}/{$citySlug}";
    }

    private function validatePrompt(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|min:1',
        ]);
    }
}
