<!-- resources/views/components/chat/messages-container.blade.php -->
<div class="flex-1 overflow-y-auto p-4 space-y-4 main-bg" id="messages-container" 
    wire:ignore.self
    x-data="{
        loading: false,
        canLoadMore: @js($totalPages > 1),
        userScrolledUp: false,
        scrollThreshold: 100,
        
        init() {
            this.setupScrollListener();
            this.scrollToBottom(true);
            this.setupEventListeners();
        },
        
        setupScrollListener() {
            this.$el.addEventListener('scroll', () => {
                const { scrollTop, scrollHeight, clientHeight } = this.$el;
                this.userScrolledUp = (scrollHeight - (scrollTop + clientHeight)) > this.scrollThreshold;
            });
        },
        
        setupEventListeners() {
            Livewire.on('messageSent', () => {
                if (!this.userScrolledUp) {
                    this.scrollToBottom();
                }
            });
            
            Livewire.on('conversationLoaded', () => {
                this.scrollToBottom(true);
            });
            
            Livewire.on('messageDeleted', () => {
                // Opcional: Mostrar un mensaje toast de confirmación
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg';
                toast.textContent = 'Message deleted';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            });
        },
        
        scrollToBottom(instant = false) {
            const container = this.$el;
            const behavior = instant ? 'auto' : 'smooth';
            
            requestAnimationFrame(() => {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: behavior
                });
            });
        },
        
        async loadMore() {
            if (this.loading || !this.canLoadMore) return;
            
            this.loading = true;
            const previousHeight = this.$el.scrollHeight;
            
            try {
                await $wire.loadMore();
                
                this.$nextTick(() => {
                    this.$el.scrollTop = this.$el.scrollHeight - previousHeight;
                    this.loading = false;
                });
            } catch (error) {
                console.error('Error loading messages:', error);
                this.loading = false;
            }
        }
    }"
    x-init="init">

    @if ($showLoadMoreButton)
        <div x-show="canLoadMore && !loading" class="flex justify-center py-2" x-transition>
            <button @click="loadMore()"
                class="px-4 py-2 glass border border-white/20 text-slate-300 rounded-full text-sm font-medium hover:bg-white/5 transition-colors">
                Load previous messages
            </button>
        </div>

        <div x-show="loading" class="flex justify-center py-2" x-transition>
            <svg class="animate-spin h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @endif

    <div class="space-y-4">
        @forelse ($messages as $message)
            <x-chat.message-item :message="$message" :key="'message-'.$message->id" />
        @empty
            <div class="flex flex-col items-center justify-center h-full text-slate-400 py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="text-lg">No messages yet</p>
                <p class="text-sm">Send the first message to start</p>
            </div>
        @endforelse
    </div>

    <div id="scroll-anchor"></div>
</div>