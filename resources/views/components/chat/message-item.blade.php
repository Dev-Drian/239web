<div class="mb-4 group">
    <div class="flex flex-col {{ $message->is_own ? 'items-end' : 'items-start' }}">
        <span class="text-xs text-gray-500 mb-1 {{ $message->is_own ? 'text-right' : 'text-left' }}">
            {{ $message->sender->name }}
        </span>
        <div class="relative {{ $message->is_own ? 'bg-indigo-600 text-white' : 'bg-white text-gray-800' }} rounded-lg shadow-sm p-3 max-w-xs md:max-w-md lg:max-w-lg {{ $message->is_own ? 'rounded-br-none' : 'rounded-bl-none' }}">
            <div class="relative group" x-data="{ openDropdown: false, openModal: false, messageIdToDelete: null }">
                @if ($message->is_own)
                    <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            @click="openDropdown = !openDropdown"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full p-1 shadow-sm transition-colors focus:outline-none"
                            title="Message options"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
            
                        <div
                            x-show="openDropdown"
                            @click.away="openDropdown = false"
                            class="absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-md shadow-md z-10"
                            style="min-width: 120px;"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <button
                                @click.prevent="openDropdown = false; openModal = true; messageIdToDelete = {{ $message->id }};"
                                class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-50 focus:outline-none"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 0h-6" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
            
                    <div
                        x-show="openModal"
                        class="fixed top-0 left-0 w-full h-full flex items-center justify-center z-30"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                    >
                        <div class="bg-white rounded-md shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm deletion</h2>
                            <p class="text-gray-700 mb-4">Are you sure you want to delete this message?</p>
                            <div class="flex justify-end gap-2">
                                <button
                                    @click="openModal = false; messageIdToDelete = null;"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded focus:outline-none"
                                >
                                    Cancel
                                </button>
                                <button
                                    wire:click="deleteMessage(messageIdToDelete)"
                                    @click="openModal = false; messageIdToDelete = null;"
                                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded focus:outline-none"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Si tiene archivo adjunto --}}
            @if ($message->file_path)
                <div class="mb-2">
                    @include('components.chat.partials.file-display')
                </div>
            @endif

            {{-- Contenido del mensaje --}}
            @if ($message->content)
                <p class="text-sm whitespace-pre-wrap break-words">{{ $message->content }}</p>
            @endif

            {{-- Hora del mensaje --}}
            <div class="mt-1 text-xs {{ $message->is_own ? 'text-indigo-100' : 'text-gray-500' }} text-right">
                {{ $message->formatted_time }}
            </div>
        </div>
    </div>
</div>