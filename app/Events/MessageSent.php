<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $chatId;

    public function __construct($message, $chatId)
    {
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function broadcastOn()
    {
        // Canal principal del chat
        $channels = [new PrivateChannel('chat.'.$this->chatId)];
        
        // Canal de notificación para cada usuario (excepto el remitente)
        foreach ($this->message->chat->users as $user) {
            if ($user->id != $this->message->sender_id) {
                $channels[] = new PrivateChannel('user.'.$user->id);
            }
        }
        
        return $channels;
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
