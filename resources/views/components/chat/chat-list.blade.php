{{-- filepath: c:\xampp\htdocs\limo-partner\resources\views\components\chat\chat-list.blade.php --}}
<div class="flex-1 overflow-y-auto" x-show="isSidebarOpen || !isMobileView">
    <!-- Chats Privados -->
    <div class="px-4 py-2">
        <h2 class="sidebar-heading text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2"
            x-show="isSidebarOpen">Private Chats</h2>
        <div class="space-y-1">
            @foreach ($privateChats as $chat)
                <x-chat.private-chat-item :chat="$chat" />
            @endforeach
        </div>
    </div>

    <!-- Chats Grupales -->
    <div class="px-4 py-2 border-t border-gray-200">
        <h2 class="sidebar-heading text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2"
            x-show="isSidebarOpen">Groups</h2>
        <div class="space-y-1">
            @foreach ($groupChats as $chat)
                <x-chat.group-chat-item :chat="$chat" />
            @endforeach
        </div>
    </div>
</div>