<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GenerateContentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GenerateController extends Controller
{
    protected $generateContentService;

    public function __construct(GenerateContentService $generateContentService)
    {
        $this->generateContentService = $generateContentService;
    }

    public function index()
    {
        return view('generate.index');
    }

    public function chat(Request $request)
    {
        $userContent = $request->input('message');
        $aiModel = $request->input('ai_model', 'gpt');
        $userId = auth()->id() ?? $request->ip();
        $cacheKey = 'chat_history_' . $userId;

        // Procesar archivos adjuntos
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    // Guardar archivo temporalmente
                    $path = $file->store('temp/attachments', 'local');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
            }
        }

        // Obtener historial anterior (sin system message)
        $conversationHistory = Cache::get($cacheKey, []);

        // System message según el modelo seleccionado
        $systemMessage = $this->getSystemMessage($aiModel);

        // Limitar historial (por tokens o mensajes)
        $limitedHistory = $this->limitHistoryByTokens($conversationHistory);

        // Construir payload para el modelo seleccionado
        $messagesForModel = array_merge(
            [$systemMessage],
            $limitedHistory,
            [['role' => 'user', 'content' => $userContent ?? '']]
        );

        // Obtener respuesta según el modelo
        $responseContent = $this->getResponseFromModel($aiModel, $messagesForModel, $attachments);

        // Actualizar historial (agregar ambos mensajes)
        $updatedHistory = array_merge($limitedHistory, [
            ['role' => 'user', 'content' => $userContent],
            ['role' => 'assistant', 'content' => $responseContent]
        ]);

        // Guardar en caché
        Cache::put($cacheKey, $updatedHistory, now()->addHours(2));

        // Limpiar archivos temporales
        $this->cleanupTempFiles($attachments);

        return response()->json([
            'response' => $responseContent,
            'model' => $aiModel,
            'attachments_count' => count($attachments)
        ]);
    }

    private function getSystemMessage($model)
    {
        switch ($model) {
            case 'perplexity':
                return [
                    'role' => 'system',
                    'content' => 'You are a smart virtual assistant powered by Perplexity AI. You provide accurate and up-to-date information, and you can analyze documents and images. Always respond helpfully, precisely, and in English. If the user asks in another language, respond in that language.'
                ];
            case 'gpt':
            default:
                return [
                    'role' => 'system',
                    'content' => 'You are a smart virtual assistant powered by GPT-4. You provide contextual and intelligent responses and can help with a wide variety of tasks. Always respond helpfully, precisely, and in English. If the user asks in another language, respond in that language.'
                ];
        }
    }

    private function getResponseFromModel($model, $messages, $attachments = [])
    {
        // Extraer el último mensaje del usuario
        $userMessage = end($messages)['content'] ?? '';
        $systemMessage = $messages[0]['content'] ?? ''; // Primer mensaje es el system
        
        // Si no hay mensaje de texto pero hay archivos, crear un mensaje por defecto
        if (empty($userMessage) && !empty($attachments)) {
            $userMessage = "Por favor analiza los archivos adjuntos y responde según su contenido. Sé específico y detallado en tu análisis.";
        }
        
        switch ($model) {
            case 'perplexity':
                // Usar el método de Perplexity con archivos
                return $this->generateContentService->generateContentPerplexityWithFiles(
                    $systemMessage,
                    $userMessage,
                    $attachments
                );
            
            case 'gpt':
            default:
                // Usar el método de GPT con archivos (Vision)
                return $this->generateContentService->generateContentGPTWithFiles(
                    $systemMessage,
                    $userMessage,
                    $attachments,
                    $messages
                );
        }
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    private function cleanupTempFiles($attachments)
    {
        foreach ($attachments as $attachment) {
            if (Storage::disk('local')->exists($attachment['path'])) {
                Storage::disk('local')->delete($attachment['path']);
            }
        }
    }

    private function limitHistoryByTokens(array $history, int $maxTokens = 2000): array
    {
        $totalTokens = 0;
        $limitedHistory = [];

        // Revertir para tomar los más recientes primero
        foreach (array_reverse($history) as $message) {
            $messageTokens = strlen($message['content']) / 4; // Aproximación
            if ($totalTokens + $messageTokens > $maxTokens) break;

            $limitedHistory[] = $message;
            $totalTokens += $messageTokens;
        }

        return array_reverse($limitedHistory);
    }
}
