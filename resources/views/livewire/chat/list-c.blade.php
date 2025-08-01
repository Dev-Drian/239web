{{-- filepath: c:\xampp\htdocs\limo-partner\resources\views\livewire\chat\list-c.blade.php --}}
<div class="flex flex-col md:flex-row h-screen bg-gray-100" 
    x-data="{ 
        isSidebarOpen: window.innerWidth >= 768, 
        isMobileView: window.innerWidth < 768,
        closeSidebarOnMobile() {
            if (this.isMobileView) {
                this.isSidebarOpen = false;
            }
        }
    }" 
    @resize.window="isMobileView = window.innerWidth < 768; isSidebarOpen = window.innerWidth >= 768">
    
    <!-- SIDEBAR -->
    <div id="sidebar" 
        class="bg-white shadow-lg transition-all duration-300 flex flex-col fixed md:relative z-30"
        :class="{
            'w-64 h-full': isSidebarOpen,
            'w-0 h-full': !isSidebarOpen && isMobileView,
            'w-16 h-full': !isSidebarOpen && !isMobileView,
            'left-0 top-0': true
        }">
        
        <!-- HEADER -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-indigo-50">
            <h1 class="font-bold text-xl text-indigo-800" 
                x-show="isSidebarOpen" 
                x-transition>Messages</h1>
            <button @click="isSidebarOpen = !isSidebarOpen"
                class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200 p-1 rounded-full hover:bg-indigo-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        :d="isSidebarOpen ? 'M11 19l-7-7 7-7' : 'M19 11l-7 7-7-7'" />
                </svg>
            </button>
        </div>

        <!-- BUTTON TO CREATE NEW CHAT -->
        <div class="px-4 py-3" x-show="isSidebarOpen" x-transition>
            <button wire:click="openModal"
                class="w-full flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                id="newChatButton">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span x-show="isSidebarOpen" x-transition>New Chat</span>
            </button>
        </div>

        <!-- CHAT LIST -->
        <x-chat.chat-list :privateChats="$privateChats" :groupChats="$groupChats" />
    </div>

    <!-- MOBILE OVERLAY -->
    <div x-show="isSidebarOpen && isMobileView" 
        @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-20"></div>

    <!-- MAIN CONTENT -->
    <div id="chat-content"
        class="flex-1 flex flex-col bg-white transition-all duration-300 border-l border-gray-200 h-full">
        
        <!-- Mobile Header -->
        <div class="bg-white py-2 px-4 flex items-center justify-between border-b border-gray-200 md:hidden">
            <button @click="isSidebarOpen = true"
                class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200 p-1 rounded-full hover:bg-indigo-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <h1 class="font-bold text-lg text-indigo-800">
                @if ($selectedChatType && $selectedId)
                    {{ $selectedChatType == 'private' 
                        ? ($privateChats->firstWhere('id', $selectedId)?->other_user?->name ?? 'Unknown User') 
                        : ($groupChats->firstWhere('id', $selectedId)?->name ?? 'Unknown Group') }}
                @else
                    Messages
                @endif
            </h1>
            <button wire:click="openModal"
                class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200 p-1 rounded-full hover:bg-indigo-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
        
        @if ($selectedChatType && $selectedId)
            <livewire:chat.window :chatType="$selectedChatType" :chatId="$selectedId" :key="'chat-window-' . $selectedId" />
        @else
            <!-- Welcome Message -->
            <div class="flex-1 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-50 to-blue-50 p-4">
                <div class="text-center p-6 max-w-md bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="p-3 mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-indigo-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Your Messaging</h2>
                    <p class="text-gray-600 mb-6">Select an existing conversation or start a new one to begin chatting</p>
                    <button wire:click="openModal"
                        class="inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Start New Chat</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- MODAL FOR NEW CHAT -->
    <x-chat.create-modal :searchResults="$searchResults" :modalSelectedUsers="$modalSelectedUsers" 
        :modalChatType="$modalChatType" :modalUserSearch="$modalUserSearch" :modalGroupName="$modalGroupName" />
</div>