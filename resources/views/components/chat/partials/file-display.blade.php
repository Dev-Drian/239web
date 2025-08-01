<div>
    @if ($message->file_path)
                <div class="mb-2">
                    @if ($message->file_info['is_image'])
                        {{-- Visualizador de imágenes --}}
                        <div class="rounded-lg overflow-hidden mb-1 relative group">
                            <img src="{{ $message->file_info['url'] }}" alt="{{ $message->file_info['name'] }}" 
                                class="w-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <a href="{{ $message->file_info['url'] }}" target="_blank" download="{{ $message->file_info['name'] }}"
                                    class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition-colors duration-150">
                                    <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @elseif ($message->file_info['is_video'])
                        {{-- Visualizador de videos --}}
                        <div class="rounded-lg overflow-hidden mb-1">
                            <video controls class="w-full">
                                <source src="{{ $message->file_info['url'] }}" type="{{ $message->file_mime_type }}">
                                Tu navegador no soporta videos.
                            </video>
                        </div>
                    @elseif ($message->file_info['is_audio'])
                        {{-- Reproductor de audio --}}
                        <div class="rounded-lg bg-gray-100 p-2 mb-1">
                            <div class="flex items-center mb-2">
                                <svg class="h-8 w-8 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <div class="overflow-hidden">
                                    <p class="font-medium text-sm truncate">{{ $message->file_info['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $message->file_info['size'] }}</p>
                                </div>
                            </div>
                            <audio controls class="w-full">
                                <source src="{{ $message->file_info['url'] }}" type="{{ $message->file_mime_type }}">
                                Tu navegador no soporta audio.
                            </audio>
                        </div>
                    @else
                        {{-- Documentos y otros archivos --}}
                        <a href="{{ $message->file_info['url'] }}" target="_blank" download="{{ $message->file_info['name'] }}"
                            class="flex items-center p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-150 mb-1 {{ $message->is_own ? 'text-gray-800' : '' }}">
                            
                            {{-- Icono según tipo de archivo --}}
                            @if ($message->file_info['extension'] == 'pdf')
                                <svg class="h-10 w-10 text-red-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif (in_array($message->file_info['extension'], ['doc', 'docx']))
                                <svg class="h-10 w-10 text-blue-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif (in_array($message->file_info['extension'], ['xls', 'xlsx']))
                                <svg class="h-10 w-10 text-green-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif (in_array($message->file_info['extension'], ['ppt', 'pptx']))
                                <svg class="h-10 w-10 text-orange-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            @elseif (in_array($message->file_info['extension'], ['zip', 'rar']))
                                <svg class="h-10 w-10 text-yellow-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            @else
                                <svg class="h-10 w-10 text-gray-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @endif
                            
                            <div class="overflow-hidden">
                                <p class="font-medium text-sm truncate">{{ $message->file_info['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $message->file_info['size'] }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            @endif
</div>