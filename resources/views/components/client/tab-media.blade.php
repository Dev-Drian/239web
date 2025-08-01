<div id="media-tab" class="tab-content p-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h3 class="text-2xl font-bold mb-6 pb-3 border-b text-gray-800">For citations only</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <label for="logo_url" class="block text-md font-semibold text-gray-700">Logo URL</label>
                <input type="url" id="logo_url" name="details[logo_url]"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    placeholder="Enter logo URL" value="{{ $client->clientDetails->logo_url ?? '' }}"
                    oninput="updateImagePreview('logo_url', 'logo-preview', 'logo-preview-container')">

                @if (isset($client->clientDetails) && $client->clientDetails->logo_url)
                    <div class="mt-4">
                        <img id="logo-preview" src="{{ asset($client->clientDetails->logo_url) }}" alt="Logo"
                            class="max-h-64 w-full object-contain rounded-lg shadow-md cursor-pointer"
                            onclick="openCenteredPreview('{{ asset($client->clientDetails->logo_url) }}')">
                    </div>
                @else
                    <div class="mt-4 hidden" id="logo-preview-container">
                        <img id="logo-preview" src="" alt="Logo"
                            class="max-h-64 w-full object-contain rounded-lg shadow-md cursor-pointer">
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <label for="video_url" class="block text-md font-semibold text-gray-700">Video
                    URL</label>
                <input type="url" id="video_url" name="details[video_url]"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    placeholder="Enter video URL (YouTube, Vimeo, etc.)"
                    value="{{ $client->clientDetails->video_url ?? '' }}"
                    oninput="updateVideoPreview('video_url', 'video-preview', 'video-preview-container')">

                @if (isset($client->clientDetails) && $client->clientDetails->video_url)
                    <div class="mt-4">
                        <iframe id="video-preview" src="{{ asset($client->clientDetails->video_url) }}" frameborder="0"
                            muted controls class="w-full h-64 rounded-lg shadow-md cursor-pointer"
                            onclick="openFullVideo('{{ asset($client->clientDetails->video_url) }}')"
                            allowfullscreen></iframe>
                    </div>
                @else
                    <div class="mt-4 hidden" id="video-preview-container">
                        <iframe id="video-preview" src="" frameborder="0" muted controls
                            class="w-full h-64 rounded-lg shadow-md cursor-pointer" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div class="space-y-4">
                <label for="photo1_url" class="block text-md font-semibold text-gray-700">Photo 1
                    URL</label>
                <input type="url" id="photo1_url" name="details[photo1_url]"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    placeholder="Enter URL for photo 1" value="{{ $client->clientDetails->photo1_url ?? '' }}"
                    oninput="updateImagePreview('photo1_url', 'photo1-preview', 'photo1-preview-container')">

                @if (isset($client->clientDetails) && $client->clientDetails->photo1_url)
                    <div class="mt-4">
                        <img id="photo1-preview" src="{{ $client->clientDetails->photo1_url }}" alt="Photo 1"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer"
                            onclick="openCenteredPreview('{{ $client->clientDetails->photo1_url }}')">
                    </div>
                @else
                    <div class="mt-4 hidden" id="photo1-preview-container">
                        <img id="photo1-preview" src="" alt="Photo 1"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer">
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <label for="photo2_url" class="block text-md font-semibold text-gray-700">Photo 2
                    URL</label>
                <input type="url" id="photo2_url" name="details[photo2_url]"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    placeholder="Enter URL for photo 2" value="{{ $client->clientDetails->photo2_url ?? '' }}"
                    oninput="updateImagePreview('photo2_url', 'photo2-preview', 'photo2-preview-container')">

                @if (isset($client->clientDetails) && $client->clientDetails->photo2_url)
                    <div class="mt-4">
                        <img id="photo2-preview" src="{{ $client->clientDetails->photo2_url }}" alt="Photo 2"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer"
                            onclick="openCenteredPreview('{{ $client->clientDetails->photo2_url }}')">
                    </div>
                @else
                    <div class="mt-4 hidden" id="photo2-preview-container">
                        <img id="photo2-preview" src="" alt="Photo 2"
                            class="h-64 w-full object-cover rounded-lg shadow-md cursor-pointer">
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="fullscreen-modal"
        class="fixed inset-0 z-50 hidden bg-transparent backdrop-blur-md items-center justify-center">
        <button id="close-modal" type="button"
            class="absolute top-4 right-4 text-gray-800 bg-white bg-opacity-75 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-gray-400 text-2xl">
            &times;
            </button>
        <img id="fullscreen-image" class="max-w-full max-h-full object-contain" style="display:none;">
        <iframe id="fullscreen-video" class="w-5/6 h-5/6" style="display:none;" frameborder="0"
            allowfullscreen></iframe>
        </div>

    <div id="centered-preview-modal"
        class="fixed inset-0 z-50 hidden bg-transparent backdrop-blur-md items-center justify-center m-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl max-h-2xl overflow-auto">
            <button id="close-centered-preview" type="button"
                class="absolute top-4 right-4 text-gray-700 bg-gray-100 bg-opacity-75 rounded-full w-8 h-8 flex items-center justify-center hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-gray-400 text-xl">
                &times;
                </button>
            <img id="centered-preview-image" class="w-full h-auto object-contain">
            </div>
        </div>

    <script>
        // Estado global para controlar envíos
        let isSubmitting = false;


        function updateImagePreview(inputId, previewId, containerId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);
            const url = input.value;

            if (url) {
                preview.src = url;
                container.classList.remove('hidden');
                // Cambiamos el onclick para abrir la vista previa centrada
                preview.onclick = function() {
                    openCenteredPreview(url);
                };
            } else {
                preview.src = '';
                container.classList.add('hidden');
                preview.onclick = null; // Remove the onclick if no URL
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

        function openFullImage(src) {
            const modal = document.getElementById('fullscreen-modal');
            const fullImage = document.getElementById('fullscreen-image');
            const fullVideo = document.getElementById('fullscreen-video');
            const closeModal = document.getElementById('close-modal');

            fullImage.src = src;
            fullImage.style.display = 'block';
            fullVideo.style.display = 'none';

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const closeHandler = (e) => {
                e.preventDefault(); // Prevent form submission
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
                e.preventDefault(); // Prevent form submission
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

        function openCenteredPreview(src) {
            const modal = document.getElementById('centered-preview-modal');
            const previewImage = document.getElementById('centered-preview-image');
            const closeModal = document.getElementById('close-centered-preview');

            previewImage.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const closeHandler = (e) => {
                e.preventDefault(); // Prevent form submission
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
