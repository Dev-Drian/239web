<?php

namespace App\Livewire;

use Livewire\Component;

class AppNotificationComponent extends Component
{
    public $notifications;
    public $unreadCount;
    public $showDropdown = false;
    public $perPage = 10;

    protected $listeners = [
        'refreshNotifications',
        'echo:notifications,NotificationSent' => 'refreshNotifications'
    ];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications()
    {
        if (auth()->check()) {
            // Get the latest notifications (both read and unread, but limit by perPage)
            $this->notifications = auth()->user()->notifications()
                ->latest()
                ->limit($this->perPage)
                ->get();

            $this->unreadCount = auth()->user()->unreadNotifications()->count();
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->refreshNotifications();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->refreshNotifications();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        if ($this->showDropdown) {
            // Refresh notifications when opening the dropdown
            $this->refreshNotifications();
        }
    }

    /**
     * Generate the appropriate URL for each notification type
     */
    public function getNotificationUrl($notification)
    {
        switch ($notification->data['type'] ?? '') {
            case 'chat':
                return route('chat.index');

            case 'task':
                return route('board.show',$notification->data['board_id'] ?? 0);
                

            default:
                // return route('notifications.index');
        }
    }

    public function render()
    {
        return view('livewire.app-notification-component');
    }
}
