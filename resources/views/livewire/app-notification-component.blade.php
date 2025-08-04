<div x-data="{ open: false }" class="relative" @click.away="open = false" wire:key="notification-dropdown">
    <!-- Notification bell button - Estilo oscuro -->
    <button wire:click="toggleDropdown" @click="open = !open"
        class="relative flex items-center justify-center w-11 h-11 rounded-xl glass text-blue-300 hover:bg-blue-500/20 hover:text-blue-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400/50 shadow-lg"
        aria-label="Notifications">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 flex items-center justify-center min-w-[20px] h-[20px] px-1 text-xs font-bold text-white bg-gradient-to-r from-blue-500 to-purple-500 rounded-full shadow-lg animate-pulse ring-2 ring-white/20">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification panel - Estilo oscuro -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="absolute right-0 z-[9999] mt-3 w-80 origin-top-right glass-dark rounded-2xl shadow-2xl border border-white/20 overflow-hidden backdrop-blur-xl"
        style="display: none;">

        <!-- Header -->
        <div class="glass-dark px-6 py-4 border-b border-white/15 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Notificaciones</h3>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead"
                    class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors duration-200 hover:bg-blue-500/20 px-3 py-1 rounded-lg">
                    Marcar todas como leídas
                </button>
            @endif
        </div>

        <!-- Notification list -->
        <div class="max-h-[400px] overflow-y-auto beautiful-scrollbar">
            @forelse($notifications as $notification)
                <div wire:key="notification-{{ $notification->id }}"
                    class="group border-b border-white/10 last:border-0 hover:bg-white/5 transition-all duration-200">
                    <a href="{{ $this->getNotificationUrl($notification) }}"
                        wire:click="markAsRead('{{ $notification->id }}')" class="block hover:no-underline">
                        <div
                            class="flex p-4 {{ !$notification->read_at ? 'border-l-4 border-blue-500 bg-blue-500/10' : 'border-l-4 border-transparent' }}">
                            <!-- Icon based on notification type -->
                            <div class="flex-shrink-0 pt-1">
                                <div
                                    class="w-10 h-10 flex items-center justify-center rounded-xl {{ !$notification->read_at ? 'bg-blue-500/20 ring-2 ring-blue-500/30' : 'bg-slate-700/50' }} transition-all duration-200">
                                    @if ($notification->data['type'] === 'chat')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 {{ !$notification->read_at ? 'text-blue-400' : 'text-slate-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    @elseif($notification->data['type'] === 'task')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 {{ !$notification->read_at ? 'text-blue-400' : 'text-slate-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 {{ !$notification->read_at ? 'text-blue-400' : 'text-slate-400' }}"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="ml-4 flex-1 overflow-hidden">
                                <!-- Title: Message Type (Chat or Task) -->
                                <p class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-1">
                                    {{ $notification->data['title'] }}
                                </p>
                                <!-- From User -->
                                <p class="text-sm font-semibold text-white truncate">
                                    {{ $notification->data['from_user'] ?? ($notification->data['assigned_by'] ?? '') }}
                                </p>
                                <!-- Message -->
                                <p class="text-sm text-slate-300 mt-1 line-clamp-2">
                                    {{ $notification->data['message'] }}
                                </p>
                                <!-- Time -->
                                <p class="text-xs text-slate-400 mt-2 flex items-center">
                                    <svg class="mr-1 h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Action button -->
                            @if (!$notification->read_at)
                                <div
                                    class="flex-shrink-0 self-start ml-2 opacity-0 group-hover:opacity-100 transition-all duration-200">
                                    <button wire:click.stop="markAsRead('{{ $notification->id }}')"
                                        class="p-2 rounded-lg text-xs font-medium text-blue-400 hover:text-blue-300 hover:bg-blue-500/20 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 px-6">
                    <div class="rounded-2xl glass p-4 mb-4">
                        <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-white mb-1">Sin notificaciones</p>
                    <p class="text-sm text-slate-400">¡Estás al día con todo!</p>
                </div>
            @endforelse
        </div>

        <!-- Footer with view all link -->
        {{-- @if (count($notifications) > 0)
            <div class="px-6 py-4 glass-dark border-t border-white/15">
                <a href="{{ route('notifications.index') }}"
                    class="block w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white text-sm font-semibold rounded-xl transition-all duration-200 text-center shadow-lg hover:shadow-xl hover:scale-105">
                    Ver todas las notificaciones
                </a>
            </div>
        @endif --}}
    </div>
</div>

