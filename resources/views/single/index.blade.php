<x-app-layout>
    <div class="min-h-screen main-bg py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Enhanced Header Section -->
            <div class="mb-8 text-center">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-purple-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">AI Image Generator</h1>
                        <p class="mt-2 text-sm text-slate-400">Create and manage AI-generated images with ease</p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Generator Section -->
            <div class="glass-dark shadow-2xl rounded-2xl p-6 mb-8 border border-white/15 backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-white">Image Generator</h2>
                </div>

                <!-- Generator Form -->
                <form id="imageGeneratorForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Enhanced Prompt Input -->
                        <div class="w-full">
                            <label for="prompt" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Prompt
                            </label>
                            <div class="relative">
                                <textarea id="prompt" name="prompt" rows="3"
                                    class="block w-full rounded-2xl glass border border-white/20 shadow-lg focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/50 text-sm transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                    placeholder="Enter your creative prompt here...">Realistic mercedes sprinter black with the Brooklyn bridge as background</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-slate-500" id="charCount">0/500</div>
                            </div>
                        </div>

                        <!-- Enhanced Controls Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Model Select -->
                            <div>
                                <label for="ai-type" class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Model
                                </label>
                                <select id="ai-type" name="ai_type"
                                    class="block w-full rounded-xl glass border border-white/20 shadow-lg focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/50 text-sm transition-all duration-300 bg-transparent text-white backdrop-blur-xl">
                                    <option value="sd3" class="bg-slate-800 text-white">SD3</option>
                                    <option value="core" class="bg-slate-800 text-white">Core</option>
                                    <option value="ultra" class="bg-slate-800 text-white">Ultra</option>
                                </select>
                            </div>

                            <!-- Format Select -->
                            <div>
                                <label for="format" class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Format
                                </label>
                                <select id="output_format" name="output_format"
                                    class="block w-full rounded-xl glass border border-white/20 shadow-lg focus:border-green-500/50 focus:ring-2 focus:ring-green-500/50 text-sm transition-all duration-300 bg-transparent text-white backdrop-blur-xl">
                                    <option selected value="jpeg" class="bg-slate-800 text-white">JPEG</option>
                                    <option value="png" class="bg-slate-800 text-white">PNG</option>
                                    <option value="webp" class="bg-slate-800 text-white webp-option">WebP</option>
                                </select>
                            </div>

                            <!-- Aspect Ratio Select -->
                            <div>
                                <label for="aspect_ratio" class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                    </svg>
                                    Aspect Ratio
                                </label>
                                <select id="aspect_ratio" name="aspect_ratio"
                                    class="block w-full rounded-xl glass border border-white/20 shadow-lg focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/50 text-sm transition-all duration-300 bg-transparent text-white backdrop-blur-xl">
                                    <option value="16:9" class="bg-slate-800 text-white">16:9</option>
                                    <option value="1:1" class="bg-slate-800 text-white">1:1</option>
                                    <option value="21:9" class="bg-slate-800 text-white">21:9</option>
                                    <option value="2:3" class="bg-slate-800 text-white">2:3</option>
                                    <option value="3:2" class="bg-slate-800 text-white">3:2</option>
                                    <option value="4:5" class="bg-slate-800 text-white">4:5</option>
                                    <option value="5:4" class="bg-slate-800 text-white">5:4</option>
                                    <option value="9:16" class="bg-slate-800 text-white">9:16</option>
                                    <option value="9:21" class="bg-slate-800 text-white">9:21</option>
                                </select>
                            </div>

                            <!-- Enhanced Generate Button -->
                            <div class="flex items-end">
                                <button type="submit" id="generateBtn"
                                    class="w-full h-12 px-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-medium rounded-2xl hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Enhanced Gallery Section -->
            <div class="glass-dark shadow-2xl rounded-2xl p-6 border border-white/15 backdrop-blur-xl">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-white">Gallery</h2>
                    </div>
                    <div class="glass px-3 py-1 rounded-xl border border-white/20 backdrop-blur-xl">
                        <span class="text-xs text-slate-400">
                            <span class="text-cyan-400 font-semibold">{{ count($images ?? []) }}</span> images
                        </span>
                    </div>
                </div>

                <div id="gallery" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @forelse ($images ?? [] as $image)
                        <div class="group relative glass rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-white/20 backdrop-blur-xl">
                            <div class="cursor-pointer" onclick="openCarousel({{ $loop->index }})">
                                <img src="{{ asset($image->filename) }}" alt="{{ $image->nombre }}"
                                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <div class="flex items-center gap-1 mb-3">
                                    <input type="text"
                                        class="text-xs text-white bg-transparent border-0 focus:ring-0 p-0 w-full filename-input font-medium"
                                        value="{{ pathinfo($image->nombre, PATHINFO_FILENAME) }}"
                                        data-id="{{ $image->id }}"
                                        data-extension="{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}">
                                    <span class="text-xs text-slate-400">.{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center gap-2">
                                    <button
                                        onclick="downloadImage('{{ asset($image->filename) }}', '{{ pathinfo($image->nombre, PATHINFO_FILENAME) }}.{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}')"
                                        class="flex items-center gap-1 text-xs text-blue-400 hover:text-blue-300 transition-colors duration-200 px-2 py-1 rounded-lg hover:bg-blue-500/10">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2h-6z" />
                                        </svg>
                                        Download
                                    </button>
                                    
                                    <button onclick="renameImage('{{ $image->id }}')"
                                        class="flex items-center gap-1 text-xs text-green-400 hover:text-green-300 transition-colors duration-200 px-2 py-1 rounded-lg hover:bg-green-500/10">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Rename
                                    </button>
                                    
                                    <form class="deleteImageForm" data-id="{{ $image->id }}" method="POST" onsubmit="confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center gap-1 text-xs text-red-400 hover:text-red-300 transition-colors duration-200 px-2 py-1 rounded-lg hover:bg-red-500/10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="w-16 h-16 bg-slate-500/20 rounded-2xl flex items-center justify-center mb-4 mx-auto ring-2 ring-slate-500/30">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">No images generated yet</h3>
                            <p class="text-sm text-slate-400">Start creating amazing AI-generated images!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Carousel Modal -->
    <div id="carouselModal"
        class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-sm flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-6xl mx-4">
            <!-- Enhanced Close button -->
            <button onclick="closeCarousel()"
                class="absolute -top-12 right-0 text-white hover:text-red-400 z-50 group p-2 glass rounded-full border border-white/20 backdrop-blur-xl transition-all duration-300 hover:scale-110">
                <svg class="w-6 h-6 transition-transform duration-200 group-hover:rotate-90" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="relative">
                <!-- Enhanced Image counter -->
                <div class="absolute -top-12 left-0 glass px-4 py-2 rounded-xl border border-white/20 backdrop-blur-xl">
                    <span id="imageCounter" class="text-white text-sm font-medium"></span>
                </div>
                
                <!-- Enhanced Navigation buttons -->
                <button onclick="previousImage()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-blue-400 transition-all duration-300 hover:scale-110 group glass rounded-2xl p-4 border border-white/20 backdrop-blur-xl shadow-2xl">
                    <svg class="w-6 h-6 transform transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <div id="carouselContent" class="flex items-center justify-center min-h-[50vh] p-4">
                    <div class="relative w-full flex justify-center items-center">
                        <img id="carouselImage" src="/placeholder.svg" alt="carousel image"
                            class="max-h-[80vh] w-auto object-contain opacity-0 transition-opacity duration-300 rounded-2xl shadow-2xl">
                        <!-- Enhanced Loading spinner -->
                        <div id="imageLoader" class="absolute inset-0 flex items-center justify-center">
                            <div class="glass rounded-2xl p-6 border border-white/20 backdrop-blur-xl">
                                <div class="animate-spin rounded-full h-12 w-12 border-4 border-white/20 border-t-white mb-4"></div>
                                <p class="text-white text-sm">Loading image...</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button onclick="nextImage()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-blue-400 transition-all duration-300 hover:scale-110 group glass rounded-2xl p-4 border border-white/20 backdrop-blur-xl shadow-2xl">
                    <svg class="w-6 h-6 transform transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            
            <!-- Enhanced Image information -->
            <div class="absolute bottom-0 left-0 right-0 glass border-t border-white/20 text-white p-6 opacity-0 transition-opacity duration-300 backdrop-blur-xl rounded-b-2xl"
                id="imageInfo">
                <h3 id="imageName" class="text-lg font-semibold mb-1"></h3>
                <p id="imageDetails" class="text-sm text-slate-300"></p>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Enhanced animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-slideInUp {
            animation: slideInUp 0.3s ease-out;
        }

        .animate-fadeInScale {
            animation: fadeInScale 0.3s ease-out;
        }

        /* Custom scrollbar for gallery */
        #gallery::-webkit-scrollbar {
            width: 8px;
        }

        #gallery::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        #gallery::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        #gallery::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Enhanced hover effects */
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
        }

        /* Textarea character counter */
        #prompt:focus + .absolute {
            color: rgb(168, 85, 247);
        }
    </style>
    @endpush

    @push('js')
    <script>
        let userId = @json(Auth::user()->id);
        let currentImageIndex = 0;
        const images = @json($images ?? []);
        const baseUrl = "{{ asset('') }}";

        // Character counter for prompt
        document.addEventListener('DOMContentLoaded', function() {
            const promptTextarea = document.getElementById('prompt');
            const charCount = document.getElementById('charCount');
            
            promptTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = `${length}/500`;
                charCount.className = length > 450 ? 'absolute bottom-3 right-3 text-xs text-red-400' : 'absolute bottom-3 right-3 text-xs text-slate-500';
            });
            
            // Initialize character count
            const initialLength = promptTextarea.value.length;
            charCount.textContent = `${initialLength}/500`;
        });

        function openCarousel(index) {
            currentImageIndex = index;
            const modal = document.getElementById('carouselModal');
            modal.classList.remove('hidden');
            
            // Enhanced fade in
            requestAnimationFrame(() => {
                modal.style.opacity = '1';
                modal.style.transform = 'scale(1)';
            });
            
            document.body.style.overflow = 'hidden';
            updateCarouselImage();
            showNotification('Image viewer opened! 🖼️', 'info');
        }

        function closeCarousel() {
            const modal = document.getElementById('carouselModal');
            
            // Enhanced fade out
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function updateCarouselImage() {
            if (!images || !images[currentImageIndex]) return;
            
            const image = images[currentImageIndex];
            const carouselImage = document.getElementById('carouselImage');
            const imageLoader = document.getElementById('imageLoader');
            const imageInfo = document.getElementById('imageInfo');
            const imageCounter = document.getElementById('imageCounter');
            
            // Show loader and hide current image
            imageLoader.style.display = 'flex';
            carouselImage.style.opacity = '0';
            imageInfo.style.opacity = '0';
            
            // Update image counter
            imageCounter.textContent = `Image ${currentImageIndex + 1} of ${images.length}`;
            
            // Create new image object for preloading
            const newImage = new Image();
            newImage.onload = function () {
                // Hide loader
                imageLoader.style.display = 'none';
                
                // Update and show image
                carouselImage.src = this.src;
                carouselImage.alt = image.nombre;
                
                // Enhanced fade in
                requestAnimationFrame(() => {
                    carouselImage.style.opacity = '1';
                    imageInfo.style.opacity = '1';
                });
                
                // Update image information
                document.getElementById('imageName').textContent = image.nombre;
                document.getElementById('imageDetails').textContent = `Created: ${formatDate(image.created_at)}`;
            };
            
            newImage.src = baseUrl + image.filename;
        }

        function previousImage() {
            const newIndex = (currentImageIndex - 1 + images.length) % images.length;
            if (newIndex !== currentImageIndex) {
                currentImageIndex = newIndex;
                updateCarouselImage();
            }
        }

        function nextImage() {
            const newIndex = (currentImageIndex + 1) % images.length;
            if (newIndex !== currentImageIndex) {
                currentImageIndex = newIndex;
                updateCarouselImage();
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Enhanced notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const colors = {
                success: 'from-emerald-500 to-green-600 border-emerald-400',
                error: 'from-red-500 to-pink-600 border-red-400',
                info: 'from-blue-500 to-indigo-600 border-blue-400'
            };
            
            notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm glass backdrop-blur-xl`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ?
                             '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            type === 'error' ?
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                        }
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white/80 hover:text-white transition-colors duration-200 transform hover:scale-110">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }, 4000);
        }

        // Touch and keyboard navigation
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('carouselModal').addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('carouselModal').addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextImage();
                } else {
                    previousImage();
                }
            }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function (event) {
            const modal = document.getElementById('carouselModal');
            if (modal.classList.contains('hidden')) return;

            switch (event.key) {
                case 'ArrowLeft':
                    previousImage();
                    break;
                case 'ArrowRight':
                    nextImage();
                    break;
                case 'Escape':
                    closeCarousel();
                    break;
            }
        });

        // Close modal when clicking outside
        document.getElementById('carouselModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeCarousel();
            }
        });

        // Model select functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modelSelect = document.getElementById('ai-type');
            const formatSelect = document.getElementById('output_format');
            const webpOption = formatSelect.querySelector('.webp-option');

            function toggleWebpOption() {
                if (modelSelect.value === 'sd3') {
                    webpOption.style.display = 'none';
                    if (formatSelect.value === 'webp') {
                        formatSelect.value = 'jpeg';
                    }
                } else {
                    webpOption.style.display = 'block';
                }
            }

            modelSelect.addEventListener('change', toggleWebpOption);
            toggleWebpOption();
        });
    </script>

    <!-- SweetAlert2 for enhanced alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Delete functionality -->
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            
            const form = event.target;
            const imageId = form.getAttribute('data-id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#ffffff',
                backdrop: 'rgba(0, 0, 0, 0.8)'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteImage(imageId, form);
                }
            });
        }

        function deleteImage(imageId, form) {
            const url = `{{ route('imageUser.delete', ':id') }}`.replace(':id', imageId);
            
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The image has been successfully deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            background: 'rgba(15, 23, 42, 0.95)',
                            color: '#ffffff'
                        }).then(() => {
                            form.closest('div.group').remove();
                            showNotification('Image deleted successfully! 🗑️', 'success');
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error deleting the image.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            background: 'rgba(15, 23, 42, 0.95)',
                            color: '#ffffff'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting image! ⚠️', 'error');
                });
        }
    </script>

    <!-- Download functionality -->
    <script>
        function downloadImage(url, filename) {
            showNotification('Starting download... ⬇️', 'info');
            
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    showNotification('Download completed! ✅', 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Download failed! ⚠️', 'error');
                });
        }

        function renameImage(imageId) {
            const newName = document.querySelector(`input[data-id="${imageId}"]`).value.trim();
            const extension = document.querySelector(`input[data-id="${imageId}"]`).dataset.extension;
            const fullName = `${newName}.${extension}`;
            const renameImageUrl = `{{ route('imageUser.rename', ':id') }}`.replace(':id', imageId);

            if (!newName) {
                showNotification('Please enter a valid name! ⚠️', 'error');
                return;
            }

            fetch(renameImageUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        name: fullName,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Failed to rename image');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification('Image renamed successfully! ✏️', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('Error renaming image! ⚠️', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error renaming image! ⚠️', 'error');
                });
        }
    </script>

    <!-- Generate functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const generateImage = '{{ route('imageUser.generate') }}';
            const generateBtn = document.getElementById('generateBtn');
            const imageGeneratorForm = document.getElementById('imageGeneratorForm');
            let isGenerating = false;

            imageGeneratorForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (isGenerating) return;
                
                isGenerating = true;
                generateBtn.innerHTML = `
                    <div class="flex items-center justify-center">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                        <span>Generating...</span>
                    </div>
                `;
                generateBtn.disabled = true;

                const formData = new FormData(imageGeneratorForm);
                const prompt = formData.get('prompt');
                const aiType = formData.get('ai_type');
                const format = formData.get('output_format');
                const aspectRatio = formData.get('aspect_ratio');

                showNotification('Generating your image... 🎨', 'info');

                fetch(generateImage, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        prompt: prompt,
                        ai_type: aiType,
                        output_format: format,
                        aspect_ratio: aspectRatio,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Image generated successfully! 🎉', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showNotification('Error generating image! ⚠️', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error generating image! ⚠️', 'error');
                })
                .finally(() => {
                    generateBtn.innerHTML = `
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Generate
                    `;
                    generateBtn.disabled = false;
                    isGenerating = false;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
