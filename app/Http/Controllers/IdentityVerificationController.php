<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\IdentityVerification;

class IdentityVerificationController extends Controller
{


    public function index($id)
    {
        if($id !=  "w5WJYYP0BOcZnnAaWj2M"){
            return view('clients.client_404');
        }
        
        $client =  Client::where('highlevel_id',$id)->first();

        if (!$client) {
            return view('clients.client_404');
        }

        $verifications = IdentityVerification::latest()->paginate(10);
        return view('identity-verification.index', compact('verifications'));
    }


    public function store(Request $request,$id)
    {
        try {
            if($id !=  "w5WJYYP0BOcZnnAaWj2M"){
                return view('clients.client_404');
            }
            
            $client =  Client::where('highlevel_id',$id)->first();

            if (!$client) {
                return view('clients.client_404');
            }


            $data = $request->all();

            // Verificar si hay datos
            if (empty($data)) {
                return response()->json([
                    'message' => 'No data provided'
                ], 400);
            }

            // Descargar y almacenar las imágenes
            $fileUrls = $data['fileUrls'] ?? [];
            $savedImages = [];

            foreach ($fileUrls as $type => $url) {
                try {
                    // Obtener la imagen
                    $response = Http::timeout(30)->get($url);

                    if ($response->successful()) {
                        // Obtener la extensión de la imagen
                        $extension = $this->getImageExtension($response->header('content-type'));

                        // Definir el nombre y la ruta del archivo
                        $relativePath = 'uploads/' . Carbon::now()->format('Y/m') . '/';
                        $fileName = uniqid('doc-') . '-' . $type . '.' . $extension;
                        $fullPath = public_path($relativePath . $fileName);

                        // Crear el directorio si no existe
                        if (!File::exists(public_path($relativePath))) {
                            File::makeDirectory(public_path($relativePath), 0755, true);
                        }

                        // Guardar la imagen en public_html/uploads
                        file_put_contents($fullPath, $response->body());

                        // Guardar la URL pública
                        $savedImages[$type] = url($relativePath . $fileName);
                    }
                } catch (\Exception $e) {
                    Log::error("Error downloading image {$type}: " . $e->getMessage());
                    continue;
                }
            }

            // Si no se pudo guardar ninguna imagen, lanzar error
            if (empty($savedImages) && !empty($fileUrls)) {
                throw new \Exception('Could not save any of the provided images');
            }

            // Guardar las URLs locales en formato JSON
            $fileUrlsJson = json_encode($savedImages);

            // Crear el JSON para more, excluyendo los campos que no queremos
            $jsonMore = json_encode(array_diff_key($data, array_flip([
                'data',
                'status',
                'fileUrls'
            ])));

            // Crear el registro con los campos mapeados
            $verification = IdentityVerification::create([
                'doc_first_name' => $data['data']['docFirstName'] ?? $data['data']['orgFirstName'] ?? null,
                'doc_last_name' => $data['data']['docLastName'] ?? $data['data']['orgLastName'] ?? null,
                'doc_number' => $data['data']['docNumber'] ?? null,
                'doc_expiry' => $data['data']['docExpiry'] ?? null,
                'doc_nationality' => $data['data']['docNationality'] ?? null,
                'doc_type' => $data['data']['docType'] ?? null,
                'status' => $data['status']['overall'] ?? 'REVIEWING',
                'file_urls' => $fileUrlsJson,
                'more' => $jsonMore
            ]);

            return response()->json([
                'message' => 'Verification created successfully',
                'data' => $verification
            ], 201);
        } catch (\Exception $e) {
            // Limpiar cualquier archivo que se haya subido en caso de error
            foreach ($savedImages as $url) {
                $filePath = public_path(parse_url($url, PHP_URL_PATH));
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            return response()->json([
                'message' => 'Error creating verification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getImageExtension($mimeType)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/bmp' => 'bmp'
        ];

        return $extensions[$mimeType] ?? 'jpg';
    }
}
