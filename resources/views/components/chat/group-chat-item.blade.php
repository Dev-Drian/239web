{{-- filepath: c:\xampp\htdocs\limo-partner\resources\views\components\chat\group-chat-item.blade.php --}}
@props(['chat'])

<button wire:click="selectChat( 'group',{{ $chat->id }})" 
    @click="closeSidebarOnMobile()" 
    class="w-full text-left py-2 rounded-lg hover:bg-indigo-50 transition duration-200 flex items-center justify-between relative group"
    :class="{'px-3': isSidebarOpen, 'px-1 justify-center': !isSidebarOpen && !isMobileView}">
    
    <div class="flex items-center" :class="{'space-x-3': isSidebarOpen}">
        <div class="relative flex-shrink-0">
            @if ($chat->image)
                <div class="relative">
                    <img src="{{ $chat->image }}" alt="{{ $chat->name }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-teal-500"
                        onerror="this.onerror=null;this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2ZmZiIgc3Ryb2tlPSIjMGRjYmM3IiBzdHJva2Utd2lkdGg9IjEuNSI+PHBhdGggZD0iTTE3IDIwaDJhMiAyIDAgMDAyLTJ2LTJhMSAxIDAgMDAtMS0xaC0xYTYgNiAwIDAxLTYtNnYtMmEyIDIgMCAwMC0yLTJoLTJhMiAyIDAgMDAtMiAydjJhNiA2IDAgMDEtNiA2SDJhMSAxIDAgMDAtMSAxdjJhMiAyIDAgMDAyIDJoMlYxMGE0IDQgMCAwMTQtNGgyYTQgNCAwIDAxNCA0djEweiIvPjwvc3ZnPg=='">
                    @if ($chat->unread_messages_count > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-md">
                            {{ $chat->unread_messages_count }}
                        </span>
                    @endif
                </div>
            @else
                <div
                    class="relative w-10 h-10 bg-gradient-to-br from-teal-500 to-green-400 text-white rounded-full flex items-center justify-center flex-shrink-0">
                    {{ strtoupper(substr($chat->name, 0, 1)) }}
                    @if ($chat->unread_messages_count > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-md">
                            {{ $chat->unread_messages_count }}
                        </span>
                    @endif
                </div>
            @endif
        </div>
        <div class="text-left min-w-0" x-show="isSidebarOpen">
            <span class="text-gray-800 font-medium block truncate">{{ $chat->name }}</span>
            @if ($chat->last_message)
                <span class="text-xs text-gray-500 truncate max-w-[180px] block">
                    {{ $chat->last_message_sender ? $chat->last_message_sender . ': ' : '' }}
                    {{ $chat->last_message }}
                </span>
            @endif
        </div>
    </div>
    <div class="flex flex-col items-end" x-show="isSidebarOpen">
        @if ($chat->last_message_time)
            <span class="text-xs text-gray-400 whitespace-nowrap">
                {{ $chat->last_message_time->diffForHumans() }}
            </span>
        @endif
    </div>
</button>