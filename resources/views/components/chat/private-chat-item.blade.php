{{-- filepath: c:\xampp\htdocs\limo-partner\resources\views\components\chat\private-chat-item.blade.php --}}
@props(['chat'])

<button wire:click="selectChat( 'private',{{ $chat->id }})" @click="closeSidebarOnMobile()"
    class="w-full text-left py-2 rounded-lg hover:bg-indigo-50 transition duration-200 flex items-center justify-between relative group"
    :class="{ 'px-3': isSidebarOpen, 'px-1 justify-center': !isSidebarOpen && !isMobileView }">

    <div class="flex items-center" :class="{ 'space-x-3': isSidebarOpen }">
        <div class="relative flex-shrink-0">
            <img src="{{ $chat->other_user->profile_photo_url }}" alt="{{ $chat->other_user->name }}"
                class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-300">
            @if ($chat->unread_messages_count > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-md">
                    {{ $chat->unread_messages_count }}
                </span>
            @endif
        </div>
        <div class="text-left min-w-0" x-show="isSidebarOpen">
            <span class="text-gray-800 font-medium block truncate">{{ $chat->other_user->name }}</span>
            @if ($chat->last_message)
                <span class="text-xs text-gray-500 truncate max-w-[180px] block">
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
