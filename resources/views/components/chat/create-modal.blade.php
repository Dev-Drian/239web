<div x-data="{
    showModal: @entangle('showModal'),
    modalChatType: @entangle('modalChatType'),
    modalUserSearch: @entangle('modalUserSearch'),
    modalSelectedUsers: @entangle('modalSelectedUsers'),
    modalGroupName: @entangle('modalGroupName')
}" x-show="showModal" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gradient-to-br from-black/40 via-gray-800/30 to-black/40 backdrop-blur-md flex items-center justify-center z-50"
    @keydown.escape.window="showModal = false" style="display: none;">

    <div @click.away="showModal = false" class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl mx-4">

        <!-- Header -->
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-xl font-semibold text-gray-800">Start New Conversation</h3>
            <button @click="$wire.closeModal()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Type Selector -->
        <div class="mb-5">
            <div class="flex space-x-2 mb-6">
                <button @click="modalChatType = 'private'" class="flex-1 py-2 px-4 rounded-full transition-colors"
                    :class="modalChatType === 'private' ? 'bg-indigo-600 text-white font-medium' :
                        'bg-gray-200 text-gray-700 font-medium'">
                    Private Chat
                </button>
                <button @click="modalChatType = 'group'" class="flex-1 py-2 px-4 rounded-full transition-colors"
                    :class="modalChatType === 'group' ? 'bg-indigo-600 text-white font-medium' :
                        'bg-gray-200 text-gray-700 font-medium'">
                    Group Chat
                </button>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="createChat">
            <!-- User Search -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search User</label>
                <div class="relative">
                    <input type="text" wire:model.debounce.300ms="modalUserSearch"
                        placeholder="Search by name or email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- User List -->
                <div class="mt-3 max-h-48 overflow-y-auto bg-gray-50 rounded-lg">
                    @if (count($searchResults) > 0)
                        @foreach ($searchResults as $user)
                            <div @click="$wire.selectModalUser({{ $user->id }})"
                                class="flex items-center p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 last:border-b-0">
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                @if (in_array($user->id, $modalSelectedUsers))
                                    <div class="ml-auto">
                                        <div class="bg-indigo-600 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="p-3 text-center text-gray-500">No users found</div>
                    @endif
                </div>
            </div>

            <!-- Selected Users -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Selected Users</label>
                <div class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg min-h-[60px]">
                    @foreach ($this->getSelectedUsers() as $user)
                        <div class="flex items-center bg-indigo-100 text-indigo-800 pl-2 pr-1 py-1 rounded-full">
                            <span>{{ $user->name }}</span>
                            <button type="button" @click="$wire.removeUser({{ $user->id }})"
                                class="ml-1 text-indigo-600 hover:text-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('modalSelectedUsers')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Group Name (only for group chats) -->
            <div x-show="modalChatType === 'group'" class="mb-5" x-transition>
                <label class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                <input type="text" wire:model="modalGroupName" placeholder="Enter group name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('modalGroupName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <button type="button" @click="$wire.closeModal()"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md">
                    Create Chat
                </button>
            </div>
        </form>
    </div>
</div>
