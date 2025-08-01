<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;
    public $type;

    /**
     * @param string $type Tipo de notificación ('chat' o 'task')
     * @param array $data Contenido personalizado de la notificación
     */
    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Canales de entrega
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Contenido para base de datos y broadcast
     */
    public function toArray($notifiable): array
    {
        switch ($this->type) {
            case 'chat':
                return [
                    'type' => 'chat',
                    'title' => 'New Message',
                    'message' => $this->data['mensaje'] ?? '',
                    'from_user' => $this->data['from_user'] ?? null,
                    'chat_id' => $this->data['chat_id'] ?? null,
                    'time' => now()->format('Y-m-d H:i:s'),
                ];

            case 'task':
                return [
                    'type' => 'task',
                    'title' => 'Task Assigned',
                    'message' => "You've been assigned: " . ($this->data['titulo'] ?? ''),
                    'task_id' => $this->data['task_id'] ?? null,
                    'assigned_by' => $this->data['from_user'] ?? null,
                    'board_id' => $this->data['board_id'] ?? null,
                    'time' => now()->format('Y-m-d H:i:s'),
                ];

            default:
                return [
                    'type' => 'info',
                    'title' => 'Information',
                    'message' => $this->data['mensaje'] ?? 'General notification',
                    'time' => now()->format('Y-m-d H:i:s'),
                ];
        }
    }
}
