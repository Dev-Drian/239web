<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Window extends Component
{
    use WithPagination, WithFileUploads;

    // Propiedades públicas del componente
    public $chatType;          // Tipo de chat (privado/grupo)
    public $chatId;            // ID del chat actual
    public $mensaje = '';      // Texto del mensaje a enviar
    public $perPage = 20;      // Mensajes por página
    public $totalMessages;     // Total de mensajes en el chat
    public $currentChat;       // Datos del chat actual
    public $isTyping = false;  // Indica si el usuario está escribiendo
    public $file;              // Archivo adjunto
    public $previewFile = null; // Vista previa del archivo
    public $email;
    // Configura listeners para eventos de Pusher
    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->chatId},.message.sent" => 'notifyShipped',
        ];
    }

    // Inicialización del componente
    public function mount($chatType, $chatId)
    {
        if (empty($chatType)) return;

        $this->chatType = $chatType;
        $this->chatId = $chatId;
        $this->loadChatData();
    }

    // Maneja evento de mensaje recibido
    public function notifyShipped($event)
    {
        // Verificar si el mensaje es para el chat actual
        if ($event['chatId'] == $this->chatId) {
            // Marcar como leído si el usuario está viendo este chat
            $this->markMessagesAsRead();
        }

        // Actualizar la lista de mensajes
        $this->loadChatData();
        $this->dispatch('refreshComponent')->self();
    }

    // Actualiza el chat cuando se recibe evento
    #[On('refreshWindow')]
    public function refreshChat($chatType, $chatId)
    {
        $this->updateChat($chatType, $chatId);
    }

    // Método para eliminar un mensaje
    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);

        // Verificar que el mensaje existe y pertenece al usuario actual
        if ($message && $message->sender_id == Auth::id()) {
            // Si tiene archivo adjunto, eliminarlo del almacenamiento
            if ($message->file_path) {
                Storage::disk('public')->delete($message->file_path);
            }

            // Eliminar el mensaje
            $message->delete();

            // Actualizar conteo de mensajes y datos del chat
            $this->totalMessages--;
            $this->loadChatData();

            // Notificar al frontend
            $this->dispatch('messageDeleted');

            // Mostrar notificación
            session()->flash('message', 'Message deleted successfully');
        } else {
            // Si el mensaje no existe o no pertenece al usuario
            session()->flash('error', 'Message not found or you do not have permission to delete it');
        }
    }

    // Se ejecuta cuando se actualiza el archivo adjunto
    public function updatedFile()
    {
        $this->validate(['file' => 'max:10240']); // Validar tamaño máximo 10MB

        // Generar vista previa según tipo de archivo
        if (str_contains($this->file->getMimeType(), 'image')) {
            $this->previewFile = [
                'type' => 'image',
                'url' => $this->file->temporaryUrl(),
                'name' => $this->file->getClientOriginalName(),
            ];
        } else {
            $this->previewFile = [
                'type' => 'file',
                'name' => $this->file->getClientOriginalName(),
                'extension' => $this->file->getClientOriginalExtension(),
                'size' => $this->formatBytes($this->file->getSize()),
            ];
        }
    }

    // Formatea bytes a tamaño legible
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    // Elimina el archivo adjunto
    public function removeFile()
    {
        $this->file = null;
        $this->previewFile = null;
    }

    // Actualiza los datos del chat
    public function updateChat($chatType, $chatId)
    {
        $this->chatType = $chatType;
        $this->chatId = $chatId;
        $this->resetPage();
        $this->loadChatData();
        $this->dispatch('refreshComponent')->self();
    }

    // Actualiza los listeners de eventos
    #[On('refreshChatListeners')]
    public function refreshListeners()
    {
        $this->dispatch('updateEchoListeners', chatId: $this->chatId);
    }

    // Carga los datos del chat
    protected function loadChatData()
    {
        $this->currentChat = Chat::with(['users'])->find($this->chatId);
        $this->totalMessages = $this->getMessagesQuery()->count();
        $this->markMessagesAsRead(); // Marcar mensajes como leídos
    }

    // Query base para obtener mensajes
    protected function getMessagesQuery()
    {
        return Message::where('chat_id', $this->chatId)
            ->with(['sender', 'reads']);
    }

    // Obtiene los mensajes formateados
    public function getMessagesProperty()
    {
        return $this->getMessagesQuery()
            ->orderBy('created_at', 'desc')
            ->limit($this->perPage)
            ->get()
            ->map(function ($message) {
                // Formatear datos básicos del mensaje
                $message->is_own = $message->sender_id === Auth::id();
                $message->formatted_time = $message->created_at->format('g:i A');
                $message->formatted_date = $message->created_at->format('M d, Y');

                // Formatear datos de archivo adjunto si existe
                if ($message->file_path) {
                    $message->file_info = $this->formatFileInfo($message);
                }

                return $message;
            })
            ->reverse(); // Ordenar de más antiguo a más nuevo
    }

    // Formatea la información del archivo adjunto
    protected function formatFileInfo($message)
    {
        return [
            'name' => $message->file_name,
            'size' => $message->file_size,
            'extension' => $message->file_extension,
            'type' => $message->message_type,
            'url' => asset('storage/' . $message->file_path),
            'is_image' => in_array($message->message_type, ['image']),
            'is_document' => in_array($message->message_type, ['document', 'pdf']),
            'is_video' => $message->message_type === 'video',
            'is_audio' => $message->message_type === 'audio',
        ];
    }

    // Obtiene el otro usuario en chat privado
    public function getOtherUserProperty()
    {
        if ($this->chatType !== 'private') return null;
        return $this->currentChat->users->where('id', '!=', Auth::id())->first();
    }

    // Carga más mensajes (paginación)
    public function loadMore()
    {
        $this->perPage += 20;
    }

    // Envía un nuevo mensaje
    public function sendMessage()
    {
        // Validar que haya mensaje o archivo
        if (empty($this->mensaje) && !$this->file) {
            return;
        }
    
        // 1. Crear el mensaje en la base de datos
        $messageData = $this->prepareMessageData();
    
        if ($this->file) {
            $messageData = array_merge($messageData, $this->processFileAttachment());
        }
    
        $message = Message::create($messageData);
        event(new MessageSent($message, $this->chatId));
    
        // 2. Preparar datos para notificaciones
        $recipients = [];
        $htmlContent = view('mail.index', [
            'asunto' => "New message in the chat: " . ($this->currentChat->name ?? $this->chatId),
            'message_content' => $this->mensaje,
            'date' => now()->format('Y-m-d H:i:s'),
            'from_user' => auth()->user()->name,
            'chat' => $this->currentChat->name ?? $this->chatId,
            'chat_id' => $this->chatId,
            'file' => $this->file ? $this->file->getClientOriginalName() : null
        ])->render();
    
        foreach ($this->currentChat->users as $usuario) {
            if ($usuario->id !== auth()->id()) {
                // Notificación interna (Laravel)
                $usuario->notify(new AppNotification('chat', [
                    'mensaje' => $this->mensaje,
                    'from_user' => auth()->user()->name,
                    'chat_id' => $this->chatId,
                ]));
                
                // Agregar destinatario al array
                $recipients[] = [
                    'email' => $usuario->email,
                ];
            }
        }
    
        // Enviar un solo webhook con todos los destinatarios
        if (!empty($recipients)) {
            $emailData = [
                'subject' => "New message in the chat:" . ($this->currentChat->name ?? $this->chatId),
                'to' => $recipients,
                'html' => $htmlContent,
                'from' => auth()->user()->name,
                'chat_id' => $this->chatId,
                'is_html' => true
            ];
    
            try {
                Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://hook.us1.make.com/0tp634g9oulv7m0f4yhelwj0kv1snlxy', $emailData);
            } catch (\Exception $e) {
                Log::error("Error al enviar a Make: " . $e->getMessage());
            }
        }
    
        // 3. Resetear el formulario
        $this->reset(['mensaje', 'file', 'previewFile']);
        $this->totalMessages++;
        $this->dispatch('messageSent');
    }
    // Prepara los datos básicos del mensaje
    protected function prepareMessageData()
    {
        return [
            'chat_id' => $this->chatId,
            'sender_id' => Auth::id(),
            'content' => $this->mensaje,
        ];
    }

    // Procesa el archivo adjunto
    protected function processFileAttachment()
    {
        $file = $this->file;
        $path = $file->store('chat_files', 'public');
        $mimeType = $file->getMimeType();

        // Determinar tipo de archivo
        $type = 'document';
        if (str_contains($mimeType, 'image')) $type = 'image';
        elseif (str_contains($mimeType, 'video')) $type = 'video';
        elseif (str_contains($mimeType, 'audio')) $type = 'audio';

        return [
            'message_type' => $type,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $this->formatBytes($file->getSize()),
            'file_extension' => $file->getClientOriginalExtension(),
            'file_mime_type' => $mimeType,
        ];
    }

    // Marca mensajes como leídos
    protected function markMessagesAsRead()
    {
        $unreadMessages = Message::where('chat_id', $this->chatId)
            ->where('sender_id', '!=', auth()->id())
            ->whereDoesntHave('reads', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        foreach ($unreadMessages as $message) {
            $message->reads()->attach(auth()->id(), ['read_at' => now()]);
        }
    }

    // Verifica si hay más mensajes por cargar
    public function hasMoreMessages()
    {
        return $this->totalMessages > $this->perPage;
    }

    // Renderiza la vista del componente
    public function render()
    {
        return view('livewire.chat.window', [
            'messages' => $this->messages,
            'otherUser' => $this->otherUser,
            'currentChat' => $this->currentChat,
            'hasMessages' => $this->messages->isNotEmpty(),
            'showLoadMoreButton' => $this->hasMoreMessages(),
            'totalPages' => $this->totalMessages > 0 ? ceil($this->totalMessages / $this->perPage) : 1,
            'previewFile' => $this->previewFile,
        ]);
    }
}
