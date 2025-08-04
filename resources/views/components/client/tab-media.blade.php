<div id="media-tab" class="tab-content p-6">
    <div class="glass-dark rounded-2xl shadow-2xl border border-white/15 p-6 backdrop-blur-xl">
        <h3 class="text-2xl font-bold mb-6 pb-3 border-b border-white/15 text-white flex items-center">
            <div class="w-3 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full mr-3"></div>
            Media Management
            <span class="ml-3 text-sm font-normal text-slate-400">For citations only</span>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Logo Section -->
            <div class="space-y-4">
                <label for="logo_url" class="flex items-center gap-2 text-md font-semibold text-slate-300 mb-3 group-hover:text-purple-300 transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Logo URL
                </label>
                <input type="url" id="logo_url" name="details[logo_url]"
                    class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 backdrop-blur-xl"
                    placeholder="Enter logo URL" value="{{ $client->clientDetails->logo_url ?? '' }}"
                    oninput="updateImagePreview('logo_url', 'logo-preview', 'logo-preview-container')">
                
                @if (isset($client->clientDetails) && $client->clientDetails->logo_url)
                    <div class="mt-4 glass-dark rounded-xl p-2 border border-white/15">
                        <img id="logo-preview" src="{{ asset($client->clientDetails->logo_url) }}" alt="Logo"
                            class="max-h-64 w-full object-contain rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openCenteredPreview('{{ asset($client->clientDetails->logo_url) }}')">
                    </div>
                @else
                    <div class="mt-4 hidden glass-dark rounded-xl p-2 border border-white/15" id="logo-preview-container">
                        <img id="logo-preview" src="/placeholder.svg" alt="Logo"
                            class="max-h-64 w-full object-contain rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
            </div>

            <!-- Video Section -->
            <div class="space-y-4">
                <label for="video_url" class="flex items-center gap-2 text-md font-semibold text-slate-300 mb-3 group-hover:text-purple-300 transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Video URL
                </label>
                <input type="url" id="video_url" name="details[video_url]"
                    class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 backdrop-blur-xl"
                    placeholder="Enter video URL (YouTube, Vimeo, etc.)"
                    value="{{ $client->clientDetails->video_url ?? '' }}"
                    oninput="updateVideoPreview('video_url', 'video-preview', 'video-preview-container')">
                
                @if (isset($client->clientDetails) && $client->clientDetails->video_url)
                    <div class="mt-4 glass-dark rounded-xl p-2 border border-white/15">
                        <iframe id="video-preview" src="{{ asset($client->clientDetails->video_url) }}" frameborder="0"
                            muted controls class="w-full h-64 rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openFullVideo('{{ asset($client->clientDetails->video_url) }}')"
                            allowfullscreen></iframe>
                    </div>
                @else
                    <div class="mt-4 hidden glass-dark rounded-xl p-2 border border-white/15" id="video-preview-container">
                        <iframe id="video-preview" src="" frameborder="0" muted controls
                            class="w-full h-64 rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </div>

        <!-- Photos Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <!-- Photo 1 -->
            <div class="space-y-4">
                <label for="photo1_url" class="flex items-center gap-2 text-md font-semibold text-slate-300 mb-3 group-hover:text-purple-300 transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Photo 1 URL
                </label>
                <input type="url" id="photo1_url" name="details[photo1_url]"
                    class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 backdrop-blur-xl"
                    placeholder="Enter URL for photo 1" value="{{ $client->clientDetails->photo1_url ?? '' }}"
                    oninput="updateImagePreview('photo1_url', 'photo1-preview', 'photo1-preview-container')">
                
                @if (isset($client->clientDetails) && $client->clientDetails->photo1_url)
                    <div class="mt-4 glass-dark rounded-xl p-2 border border-white/15">
                        <img id="photo1-preview" src="{{ $client->clientDetails->photo1_url }}" alt="Photo 1"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openCenteredPreview('{{ $client->clientDetails->photo1_url }}')">
                    </div>
                @else
                    <div class="mt-4 hidden glass-dark rounded-xl p-2 border border-white/15" id="photo1-preview-container">
                        <img id="photo1-preview" src="/placeholder.svg" alt="Photo 1"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
            </div>

            <!-- Photo 2 -->
            <div class="space-y-4">
                <label for="photo2_url" class="flex items-center gap-2 text-md font-semibold text-slate-300 mb-3 group-hover:text-purple-300 transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Photo 2 URL
                </label>
                <input type="url" id="photo2_url" name="details[photo2_url]"
                    class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 backdrop-blur-xl"
                    placeholder="Enter URL for photo 2" value="{{ $client->clientDetails->photo2_url ?? '' }}"
                    oninput="updateImagePreview('photo2_url', 'photo2-preview', 'photo2-preview-container')">
                
                @if (isset($client->clientDetails) && $client->clientDetails->photo2_url)
                    <div class="mt-4 glass-dark rounded-xl p-2 border border-white/15">
                        <img id="photo2-preview" src="{{ $client->clientDetails->photo2_url }}" alt="Photo 2"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openCenteredPreview('{{ $client->clientDetails->photo2_url }}')">
                    </div>
                @else
                    <div class="mt-4 hidden glass-dark rounded-xl p-2 border border-white/15" id="photo2-preview-container">
                        <img id="photo2-preview" src="/placeholder.svg" alt="Photo 2"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="fullscreen-modal"
        class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-md items-center justify-center">
        <button id="close-modal" type="button"
            class="absolute top-4 right-4 text-white bg-black/50 rounded-full w-12 h-12 flex items-center justify-center hover:bg-black/70 focus:outline-none focus:ring-2 focus:ring-white/50 text-2xl transition-all duration-200">
            &times;
        </button>
        <img id="fullscreen-image" class="max-w-full max-h-full object-contain" style="display:none;">
        <iframe id="fullscreen-video" class="w-5/6 h-5/6" style="display:none;" frameborder="0" allowfullscreen></iframe>
    </div>

    <div id="centered-preview-modal"
        class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-md items-center justify-center m-4">
        <div class="glass-dark rounded-2xl shadow-2xl p-8 max-w-2xl max-h-2xl overflow-auto border border-white/15">
            <button id="close-centered-preview" type="button"
                class="absolute top-4 right-4 text-slate-300 bg-black/30 rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-white/50 text-xl transition-all duration-200">
                &times;
            </button>
            <img id="centered-preview-image" class="w-full h-auto object-contain rounded-xl">
        </div>
    </div>

    <script>
        // Same JavaScript functions but with dark theme notifications
        let isSubmitting = false;
        
        function updateImagePreview(inputId, previewId, containerId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);
            const url = input.value;
            
            if (url) {
                preview.src = url;
                container.classList.remove('hidden');
                preview.onclick = function() {
                    openCenteredPreview(url);
                };
            } else {
                preview.src = '';
                container.classList.add('hidden');
                preview.onclick = null;
            }
        }

        function updateVideoPreview(inputId, previewId, containerId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);
            const url = input.value;
            
            if (url) {
                preview.src = url;
                container.classList.remove('hidden');
            } else {
                preview.src = '';
                container.classList.add('hidden');
            }
        }

        function openCenteredPreview(src) {
            const modal = document.getElementById('centered-preview-modal');
            const previewImage = document.getElementById('centered-preview-image');
            const closeModal = document.getElementById('close-centered-preview');
            
            previewImage.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            const closeHandler = (e) => {
                e.preventDefault();
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                closeModal.removeEventListener('click', closeHandler);
                modal.removeEventListener('click', modalHandler);
            };
            
            const modalHandler = (e) => {
                if (e.target === modal) {
                    closeHandler(e);
                }
            };
            
            closeModal.addEventListener('click', closeHandler);
            modal.addEventListener('click', modalHandler);
        }

        function openFullVideo(src) {
            const modal = document.getElementById('fullscreen-modal');
            const fullImage = document.getElementById('fullscreen-image');
            const fullVideo = document.getElementById('fullscreen-video');
            const closeModal = document.getElementById('close-modal');
            
            fullVideo.src = src;
            fullVideo.controls = true;
            fullVideo.autoplay = false;
            fullVideo.muted = false;
            fullVideo.classList.remove('hidden');
            fullVideo.classList.add('block');
            fullImage.style.display = 'none';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            const closeHandler = (e) => {
                e.preventDefault();
                fullVideo.pause();
                fullVideo.src = '';
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                closeModal.removeEventListener('click', closeHandler);
                modal.removeEventListener('click', modalHandler);
            };
            
            const modalHandler = (e) => {
                if (e.target === modal) {
                    closeHandler(e);
                }
            };
            
            closeModal.addEventListener('click', closeHandler);
            modal.addEventListener('click', modalHandler);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const logoPreview = document.getElementById('logo-preview');
            if (logoPreview) {
                logoPreview.onclick = function() {
                    openCenteredPreview(this.src);
                };
            }
            
            const photo1Preview = document.getElementById('photo1-preview');
            if (photo1Preview) {
                photo1Preview.onclick = function() {
                    openCenteredPreview(this.src);
                };
            }
            
            const photo2Preview = document.getElementById('photo2-preview');
            if (photo2Preview) {
                photo2Preview.onclick = function() {
                    openCenteredPreview(this.src);
                };
            }
        });
    </script>
</div>