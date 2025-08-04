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

    <div @click.away="showModal = false" class="glass-dark rounded-xl p-6 w-full max-w-md shadow-2xl mx-4 border border-white/15">

        <!-- Header -->
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-xl font-semibold text-white">Start New Conversation</h3>
            <button @click="$wire.closeModal()" class="text-slate-400 hover:text-white">
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
                    :class="modalChatType === 'private' ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium' :
                        'glass border border-white/20 text-slate-300 font-medium'">
                    Private Chat
                </button>
                <button @click="modalChatType = 'group'" class="flex-1 py-2 px-4 rounded-full transition-colors"
                    :class="modalChatType === 'group' ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium' :
                        'glass border border-white/20 text-slate-300 font-medium'">
                    Group Chat
                </button>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="createChat">
            <!-- User Search -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-300 mb-2">Search User</label>
                <div class="relative">
                    <input type="text" wire:model.debounce.300ms="modalUserSearch"
                        placeholder="Search by name or email"
                        class="w-full glass border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white placeholder-slate-400">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- User List -->
                <div class="mt-3 max-h-48 overflow-y-auto glass-dark rounded-lg border border-white/15">
                    @if (count($searchResults) > 0)
                        @foreach ($searchResults as $user)
                            <div @click="$wire.selectModalUser({{ $user->id }})"
                                class="flex items-center p-3 hover:bg-white/5 cursor-pointer border-b border-white/10 last:border-b-0">
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                                @if (in_array($user->id, $modalSelectedUsers))
                                    <div class="ml-auto">
                                        <div class="bg-indigo-500 rounded-full p-1">
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
                        <div class="p-3 text-center text-slate-400">No users found</div>
                    @endif
                </div>
            </div>

            <!-- Selected Users -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-300 mb-2">Selected Users</label>
                <div class="flex flex-wrap gap-2 p-3 glass-dark rounded-lg min-h-[60px] border border-white/15">
                    @foreach ($this->getSelectedUsers() as $user)
                        <div class="flex items-center bg-indigo-500/20 text-indigo-300 pl-2 pr-1 py-1 rounded-full border border-indigo-400/30">
                            <span>{{ $user->name }}</span>
                            <button type="button" @click="$wire.removeUser({{ $user->id }})"
                                class="ml-1 text-indigo-400 hover:text-indigo-300">
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
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Group Name (only for group chats) -->
            <div x-show="modalChatType === 'group'" class="mb-5" x-transition>
                <label class="block text-sm font-medium text-slate-300 mb-2">Group Name</label>
                <input type="text" wire:model="modalGroupName" placeholder="Enter group name"
                    class="w-full glass border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white placeholder-slate-400">
                @error('modalGroupName')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <button type="button" @click="$wire.closeModal()"
                    class="px-4 py-2 text-slate-300 border border-white/20 rounded-lg hover:bg-white/5 glass">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white rounded-lg shadow-md">
                    Create Chat
                </button>
            </div>
        </form>
    </div>
</div>
