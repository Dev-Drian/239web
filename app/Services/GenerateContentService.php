<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class GenerateContentService
{
    protected string $openAiApiKey;
    protected string $perplexityApiKey;

    protected string $openAiUrl = 'https://api.openai.com/v1/chat/completions';
    protected string $perplexityUrl = 'https://api.perplexity.ai/chat/completions';

    public function __construct()
    {
        $this->openAiApiKey = config('services.openai.api_key') ?? "sdas";
        $this->perplexityApiKey = config('services.perplexity.api_key') ?? "asds";
    }

    /**
     * Genera contenido utilizando la API de OpenAI GPT.
     */
    public function generateContentGPT(string $systemContent, string $userContent, array $historyMessages = []): ?string
    {
        try {
            // Construir el arreglo de mensajes
            $messages = [];
    
            // Agregar mensaje del sistema si no está en el historial
            if (empty($historyMessages)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemContent,
                ];
            } else {
                $messages = $historyMessages;
            }
    
            // Agregar mensaje del usuario actual
            $messages[] = [
                'role' => 'user',
                'content' => $userContent,
            ];
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'max_tokens' => 2000,  // Aumentado para permitir artículos completos
                'temperature' => 0.7,
            ]);
    
            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
    
            Log::error('OpenAI API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI): ' . $e->getMessage());
        }
    
        return "Error generating content with OpenAI.";
    }
    /**
     * Genera contenido utilizando la API de Perplexity.
     */
    public function generateContentPerplexity(string $systemContent, string $userContent): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->perplexityApiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->perplexityUrl, [
                'model' => 'sonar-pro',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemContent, // Contenido dinámico para el rol 'system'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userContent, // Contenido dinámico para el rol 'user'
                    ],
                ],
                'max_tokens' => 1800,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                Log::info('Perplexity API Response: ' . $response->body());
                return $response->json('choices.0.message.content');
            }

            Log::error('Perplexity API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (Perplexity): ' . $e->getMessage());
        }

        return "Error generating content with Perplexity.";
    }


    /**
     * Genera un meta título utilizando la API de OpenAI.
     */
    public function generateMetaTitle(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert copywriter. Please generate an SEO-friendly meta title between 50 to 60 characters.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => 60, // Limitar a 60 tokens (caracteres)
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenAI API Error (Meta Title): ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI - Meta Title): ' . $e->getMessage());
        }

        return "Error generating meta title with OpenAI.";
    }
    /**
     * Genera una meta descripción utilizando la API de OpenAI.
     */
    public function generateMetaDescription(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert copywriter. Please generate an SEO-friendly meta description between 140 to 170 characters.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => 170, // Limitar a 170 tokens (caracteres)
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenAI API Error (Meta Description): ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI - Meta Description): ' . $e->getMessage());
        }

        return "Error generating meta description with OpenAI.";
    }


    public function extractMetadata(string $content): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert in text analysis. Extract relevant metadata such as title, description, and keywords from the provided content.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $content,
                    ],
                ],
                'max_tokens' => 250,
                'temperature' => 0.5,
            ]);

            if ($response->successful()) {
                $metadata = $response->json('choices.0.message.content');
                return json_decode($metadata, true);
            }

            Log::error('OpenAI API Error (Meta Extract): ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (Meta Extract): ' . $e->getMessage());
        }

        return null;
    }
    public function generateExtraBlog(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert copywriter. Generate a complementary paragraph based on the prompt and provided content. 

IMPORTANT RULES:
- ALWAYS mention the specific city in your content
- ONLY mention landmarks and places that are actually located in the specified city
- NEVER mix landmarks from different cities
- Be geographically accurate and specific

IMPORTANT URL RULES:
- ONLY use real, working URLs for landmarks and businesses
- NEVER use fake URLs like "https://example.com" or "https://landmark-website.com"
- If you don\'t know the exact URL, use Google Maps with city name: <a href="https://maps.google.com/search?q=PLACE_NAME+CITY_NAME" target="_blank">Place Name</a>
- All URLs must start with https://
- Always include target="_blank" in links
- ALWAYS include the city name in Google Maps searches

Example format: <a href="https://maps.google.com/search?q=Louvre+Museum+Paris" target="_blank">Louvre Museum in Paris</a>',
                    ],
                    [   
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenAI API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Genera contenido utilizando la API de OpenAI GPT con soporte para archivos (Vision).
     */
    public function generateContentGPTWithFiles(string $systemContent, string $userContent = '', array $attachments = [], array $historyMessages = []): ?string
    {
        try {
            // Construir el arreglo de mensajes
            $messages = [];
    
            // Agregar mensaje del sistema si no está en el historial
            if (empty($historyMessages)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemContent,
                ];
            } else {
                // Filtrar mensajes con contenido nulo o vacío y reindexar
                $messages = array_values(array_filter($historyMessages, function($message) {
                    return isset($message['content']) && $message['content'] !== null && $message['content'] !== '';
                }));
            }
    
            // Preparar el contenido del usuario con archivos
            $userMessage = [
                'role' => 'user',
                'content' => []
            ];
    
            // Agregar texto del usuario
            if (!empty($userContent)) {
                $userMessage['content'][] = [
                    'type' => 'text',
                    'text' => $userContent
                ];
            } elseif (!empty($attachments)) {
                // Si no hay texto pero hay archivos, agregar un mensaje por defecto
                $userMessage['content'][] = [
                    'type' => 'text',
                    'text' => 'Please analyze the attached files and respond according to their content. Be specific and detailed in your analysis.'
                ];
            }
    
            // Procesar archivos adjuntos
            foreach ($attachments as $attachment) {
                $filePath = storage_path('app/' . $attachment['path']);
                
                if (file_exists($filePath)) {
                    $fileContent = file_get_contents($filePath);
                    $mimeType = $attachment['type'];
                    
                    // Determinar el tipo de archivo
                    if (str_starts_with($mimeType, 'image/')) {
                        // Es una imagen
                        $base64Image = base64_encode($fileContent);
                        $userMessage['content'][] = [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'data:' . $mimeType . ';base64,' . $base64Image
                            ]
                        ];
                    } elseif (in_array($mimeType, ['text/plain', 'application/pdf'])) {
                        // Es un documento de texto o PDF
                        if ($mimeType === 'application/pdf') {
                            // Procesar PDF usando la librería
                            try {
                                $parser = new Parser();
                                $pdf = $parser->parseFile($filePath);
                                $textContent = $pdf->getText();
                            } catch (\Exception $e) {
                                $textContent = "Error al procesar PDF: " . $attachment['name'];
                                Log::error('PDF parsing error: ' . $e->getMessage());
                            }
                        } else {
                            $textContent = $fileContent;
                        }
                        
                        $userMessage['content'][] = [
                            'type' => 'text',
                            'text' => "Contenido del archivo '" . $attachment['name'] . "':\n" . $textContent
                        ];
                    }
                }
            }
    
            $messages[] = $userMessage;
    
            // Usar GPT-4o para soporte de vision
            $model = !empty($attachments) ? 'gpt-4o' : 'gpt-4o-mini';
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => $model,
                'messages' => $messages,
                'max_tokens' => 1800,
                'temperature' => 0.7,
            ]);
    
            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
    
            Log::error('OpenAI API Error (Vision): ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI Vision): ' . $e->getMessage());
        }
    
        return "Error generating content with OpenAI Vision.";
    }

    /**
     * Genera contenido utilizando la API de Perplexity con soporte para archivos.
     */
    public function generateContentPerplexityWithFiles(string $systemContent, string $userContent = '', array $attachments = []): ?string
    {
        try {
            // Procesar archivos para Perplexity
            $enhancedContent = $userContent;
            
            // Si no hay contenido de texto pero hay archivos, agregar un mensaje por defecto
            if (empty($enhancedContent) && !empty($attachments)) {
                $enhancedContent = 'Please analyze the attached files and respond according to their content. Be specific and detailed in your analysis.';
            }
            
            foreach ($attachments as $attachment) {
                $filePath = storage_path('app/' . $attachment['path']);
                
                if (file_exists($filePath)) {
                    $mimeType = $attachment['type'];
                    
                    if (str_starts_with($mimeType, 'image/')) {
                        // Para imágenes, Perplexity puede procesarlas directamente
                        $base64Image = base64_encode(file_get_contents($filePath));
                        $enhancedContent .= "\n\n[Imagen adjunta: " . $attachment['name'] . " - " . $mimeType . "]";
                    } elseif (in_array($mimeType, ['text/plain', 'application/pdf'])) {
                        // Para documentos de texto
                        if ($mimeType === 'text/plain') {
                            $textContent = file_get_contents($filePath);
                            $enhancedContent .= "\n\nContenido del archivo '" . $attachment['name'] . "':\n" . $textContent;
                        } elseif ($mimeType === 'application/pdf') {
                            // Procesar PDF usando la librería
                            try {
                                $parser = new Parser();
                                $pdf = $parser->parseFile($filePath);
                                $textContent = $pdf->getText();
                                $enhancedContent .= "\n\nContenido del archivo PDF '" . $attachment['name'] . "':\n" . $textContent;
                            } catch (\Exception $e) {
                                $enhancedContent .= "\n\n[Error al procesar PDF: " . $attachment['name'] . "]";
                                Log::error('PDF parsing error (Perplexity): ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->perplexityApiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->perplexityUrl, [
                'model' => 'sonar-pro',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemContent,
                    ],
                    [
                        'role' => 'user',
                        'content' => $enhancedContent,
                    ],
                ],
                'max_tokens' => 1800,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('Perplexity API Error (Files): ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (Perplexity Files): ' . $e->getMessage());
        }

        return "Error generating content with Perplexity.";
    }
     public function generateNearbyCitiesAndAirports(string $city): ?array
    {
        try {
            $prompt = "Provide a precise JSON response for {$city} with:
                - List of 30 nearby cities within 30 miles
                - List of local airports with names and IATA codes
                - Only return valid, clean JSON
                - No additional explanatory text

                Example format:
                {
                    \"cities\": [\"City1\", \"City2\", ...],
                    \"airports\": [
                        {\"name\": \"Airport Name\", \"IATA_code\": \"XXX\"}
                    ]
                }";
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->openAiUrl, [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that provides accurate and structured data.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0,
                'max_tokens' => 800,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');

                // Clean up the response: Remove any leading or trailing non-JSON content
                $json_start = strpos($content, '{');
                $json_end = strrpos($content, '}');
                if ($json_start !== false && $json_end !== false) {
                    $clean_json = substr($content, $json_start, $json_end - $json_start + 1);
                    return json_decode($clean_json, true);
                } else {
                    Log::error('Unable to parse JSON content', ['response_content' => $content]);
                    return null;
                }
            }

            Log::error('OpenAI API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Connection Error (OpenAI): ' . $e->getMessage());
        }

        return null;
    }
}
