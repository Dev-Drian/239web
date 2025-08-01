<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\Utils;

class ImageGeneratorService
{
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('STABILITY_AI_KEY', 'sk-MDZITc6nf15m4HuCLPW29PH5QeQlxqgf4oeZAkts8F9smdOs');
    }

    /**
     * Genera una imagen con el aspect ratio especificado.
     *
     * @param string $prompt
     * @param string $aiType
     * @param string $outputFormat
     * @param string $aspectRatio
     * @return array
     */
    public function generateImage(string $prompt, string $aiType = 'sd3', string $outputFormat = 'jpeg', string $aspectRatio = '1:1')
    {
        try {
            $response = $this->client->post('https://api.stability.ai/v2beta/stable-image/generate/' . $aiType, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'image/*'
                ],
                'multipart' => [
                    [
                        'name' => 'prompt',
                        'contents' => $prompt
                    ],
                    [
                        'name' => 'output_format',
                        'contents' => $outputFormat
                    ],
                    [
                        'name' => 'aspect_ratio',
                        'contents' => $aspectRatio
                    ]
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to generate image');
            }

            // Generar ruta relativa basada en la fecha actual
            $relativePath = 'image_ai/' . Carbon::now()->format('Y/m') . '/';
            
            // Crear directorio si no existe
            if (!File::exists(public_path($relativePath))) {
                File::makeDirectory(public_path($relativePath), 0755, true);
            }

            // Generar nombre de archivo único
            $filename = uniqid('ai-') . '.' . $outputFormat;
            $fullPath = public_path($relativePath . $filename);

            // Guardar la imagen
            file_put_contents($fullPath, $response->getBody());

            return [
                'success' => true,
                'image_url' => url($relativePath . $filename),
                'filename' => $filename,
                'path' => $relativePath . $filename
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => 'API Request failed: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to process image: ' . $e->getMessage()
            ];
        }
    }
    public function generateImagesConcurrently(string $prompt, array $aiTypes = ['sd3', 'core', 'ultra'], string $outputFormat = 'jpeg')
    {
        try {
            // Crear un array de promesas para las solicitudes concurrentes
            $promises = [];
            foreach ($aiTypes as $aiType) {
                $promises[$aiType] = $this->client->postAsync('https://api.stability.ai/v2beta/stable-image/generate/' . $aiType, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Accept' => 'image/*',
                    ],
                    'multipart' => [
                        [
                            'name' => 'prompt',
                            'contents' => $prompt,
                        ],
                        [
                            'name' => 'output_format',
                            'contents' => $outputFormat,
                        ],
                    ],
                ]);
            }

            // Esperar a que todas las promesas se resuelvan
            $responses = Utils::settle($promises)->wait();

            // Procesar las respuestas
            $results = [];
            foreach ($responses as $aiType => $response) {
                if ($response['state'] === 'fulfilled') {
                    // Generar ruta relativa basada en la fecha actual
                    $relativePath = 'image_ai/' . Carbon::now()->format('Y/m') . '/';

                    // Crear directorio si no existe
                    if (!File::exists(public_path($relativePath))) {
                        File::makeDirectory(public_path($relativePath), 0755, true);
                    }

                    // Generar nombre de archivo único
                    $filename = uniqid('ai-') . '.' . $outputFormat;
                    $fullPath = public_path($relativePath . $filename);

                    // Guardar la imagen
                    file_put_contents($fullPath, $response['value']->getBody());

                    $results[$aiType] = [
                        'success' => true,
                        'image_url' => url($relativePath . $filename),
                        'filename' => $filename,
                        'path' => $relativePath . $filename,
                    ];
                } else {
                    $results[$aiType] = [
                        'success' => false,
                        'error' => 'API Request failed: ' . $response['reason']->getMessage(),
                    ];
                }
            }

            return $results;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to process images: ' . $e->getMessage(),
            ];
        }
    }

    // Métodos deleteImage y findImagePath sin cambios
    public function deleteImage(string $filePath)
    {
        try {
            // Verificar si el archivo existe en la ruta especificada
            if (!File::exists(public_path($filePath))) {
                return [
                    'success' => false,
                    'message' => 'Image file does not exist.',
                ];
            }
    
            // Intentar eliminar el archivo
            File::delete(public_path($filePath));
    
            // Verificar si el archivo fue eliminado correctamente
            if (!File::exists(public_path($filePath))) {
                return [
                    'success' => true,
                    'message' => 'Image deleted successfully.',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to delete image file.',
                ];
            }
        } catch (\Exception $e) {
            // Capturar y devolver cualquier excepción
            return [
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage(),
            ];
        }
    }

    private function findImagePath(string $filename)
    {
        $basePath = 'image_ai';
    
        // Construir la ruta esperada basada en la fecha actual
        $relativePath = $basePath . '/' . Carbon::now()->format('Y/m') . '/' . $filename;
    
        // Verificar si el archivo existe en la ruta esperada
        if (File::exists(public_path($relativePath))) {
            return $relativePath;
        }
    
        // Si no se encuentra en la ruta esperada, buscar recursivamente (como último recurso)
        $files = File::allFiles(public_path($basePath));
    
        foreach ($files as $file) {
            if ($file->getFilename() === $filename) {
                return str_replace(public_path(), '', $file->getPathname());
            }
        }
    
        // Si no se encuentra en ninguna parte, devolver null
        return null;
    }
}