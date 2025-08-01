<div class="bg-white/95 backdrop-blur-sm p-4 border-t border-gray-200 sticky bottom-0 transition-all duration-300">
    <!-- Vista previa de archivo -->
    @if ($previewFile)
        <div class="mb-3 relative">
            <div class="inline-block chat-file-preview bg-gray-100 rounded-lg p-3">
                @if ($previewFile['type'] === 'image')
                    <img src="{{ $previewFile['url'] }}" alt="Preview" class="h-32 rounded-md">
                @else
                    <div class="flex items-center space-x-3">
                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $previewFile['name'] }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $previewFile['size'] ?? '' }}</p>
                        </div>
                    </div>
                @endif
                <button wire:click="removeFile" class="file-remove-btn">
                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Formulario de envío -->
    <form wire:submit.prevent="sendMessage" class="flex items-center space-x-3" x-data="{
        showEmojiPicker: false,
        showFilePicker: false,
        fileType: null,
        emojis: ['😀', '😂', '😍', '🤔', '👍', '❤️', '🔥', '🎉', '🙏', '😊', '🥳', '😎', '🤯', '👏', '💯', '🤷', '🙄', '😢'],
        addEmoji(emoji) {
            this.$refs.messageInput.value += emoji;
            $wire.mensaje = this.$refs.messageInput.value;
            this.$refs.messageInput.focus();
        },
        setFileType(type) {
            this.fileType = type;
            setTimeout(() => this.$refs.messageInput.focus(), 100);
        },
        handleKeydown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                if (this.$refs.messageInput.value.trim() !== '' || $wire.file) {
                    $wire.sendMessage();
                }
            }
        }
    }">
        <!-- Botón para adjuntar archivos -->
        <div class="relative">
            <button type="button" @click="showFilePicker = !showFilePicker; showEmojiPicker = false"
                class="text-gray-500 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100/80 transition-all duration-300 active:scale-95"
                title="Adjuntar archivo">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </button>

            <!-- Menú de adjuntos -->
            <div x-show="showFilePicker" @click.away="showFilePicker = false"
                class="absolute bottom-12 left-0 bg-white rounded-lg shadow-lg p-2 w-48 z-10 border border-gray-200"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <!-- Opción para imágenes -->
                <label
                    class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer rounded transition-colors">
                    <input type="file" wire:model="file" class="hidden" accept="image/*"
                        @change="setFileType('image')">
                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Imagen
                </label>

                <!-- Opción para documentos -->
                <label
                    class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer rounded transition-colors">
                    <input type="file" wire:model="file" class="hidden"
                        accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar" @change="setFileType('file')">
                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Documento
                </label>
            </div>
        </div>

        <!-- Botón de emojis -->
        <button type="button" @click="showEmojiPicker = !showEmojiPicker; showFilePicker = false"
            class="text-gray-500 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100/80 transition-all duration-300 active:scale-95"
            title="Emojis">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>

        <!-- Selector de emojis -->
        <div x-show="showEmojiPicker" @click.away="showEmojiPicker = false"
            class="absolute bottom-16 left-16 bg-white rounded-lg shadow-lg p-2 z-10 border border-gray-200"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="grid grid-cols-8 gap-1">
                <template x-for="emoji in emojis">
                    <button type="button" @click="addEmoji(emoji)"
                        class="text-2xl hover:bg-gray-100 rounded p-1 transition-colors" x-text="emoji"
                        title="Insertar emoji"></button>
                </template>
            </div>
        </div>

        <!-- Campo de mensaje -->
        <div class="flex-1 relative">
            <input type="text" wire:model.live="mensaje" x-ref="messageInput" @keydown="handleKeydown($event)"
                class="w-full rounded-full px-5 py-3 border border-gray-300/80 
        focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 
        bg-white/90 transition-all duration-300 placeholder-gray-400 shadow-sm"
                placeholder="Escribe un mensaje...">
        </div>

        <!-- Botón de enviar -->
        <!-- Botón de enviar -->
        <button type="submit"
            class="p-2 rounded-full transition-all duration-300 hover:bg-gray-100/80 active:scale-95"
            :class="{
                'text-indigo-600 hover:text-indigo-700': $wire.mensaje.trim().length > 0 || $wire.file,
                'text-gray-400': $wire.mensaje.trim().length === 0 && !$wire.file
            }"
            :disabled="$wire.mensaje.trim().length === 0 && !$wire.file" title="Enviar mensaje">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </form>
</div>
