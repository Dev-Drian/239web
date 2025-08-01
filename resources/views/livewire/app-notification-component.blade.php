<div x-data="{ open: false }" class="relative" @click.away="open = false" wire:key="notification-dropdown">
    <!-- Notification bell button -->
    <button wire:click="toggleDropdown" @click="open = !open"
        class="relative flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
        aria-label="Notifications">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-xs font-bold text-white bg-blue-500 rounded-full shadow-sm">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification panel -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute right-0 z-50 mt-2 w-80 origin-top-right bg-white rounded-lg shadow-xl border border-blue-100 overflow-hidden"
        style="display: none;">
        <!-- Header -->
        <div class="bg-white px-4 py-3 border-b border-blue-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-blue-800">Notifications</h3>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead"
                    class="text-xs font-medium text-blue-500 hover:text-blue-700 transition-colors duration-200">
                    Mark all as read
                </button>
            @endif
        </div>

        <!-- Notification list -->
        <div class="max-h-[350px] overflow-y-auto overscroll-contain">
            @forelse($notifications as $notification)
                <div wire:key="notification-{{ $notification->id }}"
                    class="group border-b border-blue-50 last:border-0">
                    <a href="{{ $this->getNotificationUrl($notification) }}" 
                       wire:click="markAsRead('{{ $notification->id }}')"
                       class="block hover:no-underline">
                        <div
                            class="flex p-3 hover:bg-blue-50 transition-colors duration-150 {{ !$notification->read_at ? 'border-l-2 border-blue-500' : 'border-l-2 border-transparent' }}">
                            <!-- Icon based on notification type -->
                            <div class="flex-shrink-0 pt-0.5">
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-full {{ !$notification->read_at ? 'bg-blue-100' : 'bg-gray-100' }}">
                                    @if($notification->data['type'] === 'chat')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 {{ !$notification->read_at ? 'text-blue-500' : 'text-gray-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    @elseif($notification->data['type'] === 'task')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 {{ !$notification->read_at ? 'text-blue-500' : 'text-gray-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 {{ !$notification->read_at ? 'text-blue-500' : 'text-gray-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="ml-3 flex-1 overflow-hidden">
                                <!-- Title: Message Type (Chat or Task) -->
                                <p class="text-xs font-medium text-blue-800 uppercase tracking-wide mb-1">
                                    {{ $notification->data['title'] }}
                                </p>

                                <!-- From User -->
                                <p class="text-sm font-semibold text-blue-900 truncate mt-0.5">
                                    {{ $notification->data['from_user'] ?? $notification->data['assigned_by'] ?? '' }}
                                </p>

                                <!-- Message -->
                                <p class="text-sm text-gray-700 mt-1">
                                    {{ $notification->data['message'] }}
                                </p>

                                <!-- Time -->
                                <p class="text-xs text-blue-400 mt-2 flex items-center">
                                    <svg class="mr-1 h-3 w-3 text-blue-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Action button -->
                            @if (!$notification->read_at)
                                <div
                                    class="flex-shrink-0 self-start ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                    <button wire:click.stop="markAsRead('{{ $notification->id }}')"
                                        class="p-1 rounded text-xs font-medium text-blue-500 hover:text-blue-700 hover:bg-blue-100">
                                        Mark as read
                                    </button>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-8 px-4 bg-blue-50">
                    <div class="rounded-full bg-white p-3 mb-2">
                        <svg class="h-8 w-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-blue-600">No notifications</p>
                    <p class="text-xs text-blue-400 mt-1">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <!-- Footer with view all link -->
        {{-- @if (count($notifications) > 0)
            <div class="px-4 py-3 bg-gray-50 border-t border-blue-100">
                <a href="{{ route('notifications.index') }}"
                    class="block w-full py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors duration-200 text-center">
                    View all notifications
                </a>
            </div>
        @endif --}}
    </div>
</div>