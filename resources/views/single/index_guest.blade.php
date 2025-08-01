<x-guest-layout>
    <!-- Contenido anterior sin cambios hasta la sección de la galería -->
    <div class="bg-gradient-to-b from-gray-50 to-white py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">AI Image Generator</h1>
                <p class="mt-2 text-sm text-gray-600">Create and manage AI-generated images with ease</p>
            </div>

            <!-- Generator Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <!-- Generator Form -->
                <form id="imageGeneratorForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Prompt Input -->
                        <div class="w-full">
                            <label for="prompt" class="block text-sm font-medium text-gray-700 mb-2">
                                Prompt
                            </label>
                            <div class="relative">
                                <textarea id="prompt" name="prompt" rows="2"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out resize-none"
                                    placeholder="Enter your prompt here">Realistic mercedes sprinter black with the Brooklyn bridge as background</textarea>
                            </div>
                        </div>

                        <!-- Controls Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Model Select -->
                            <div>
                                <label for="ai-type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Model
                                </label>
                                <select id="ai-type" name="ai_type"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out">
                                    <option value="sd3">SD3</option>
                                    <option value="core">Core</option>
                                    <option value="ultra">Ultra</option>
                                </select>
                            </div>

                            <!-- Format Select -->
                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700 mb-2">
                                    Format
                                </label>
                                <select id="output_format" name="output_format"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out">
                                    <option selected value="jpeg">JPEG</option>
                                    <option value="png">PNG</option>
                                    <option value="webp">WebP</option>
                                </select>
                            </div>

                            <!-- Aspect Ratio Select -->
                            <div>
                                <label for="aspect_ratio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Aspect Ratio
                                </label>
                                <select id="aspect_ratio" name="aspect_ratio"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out">
                                    <option value="16:9">16:9</option>
                                    <option value="1:1">1:1</option>
                                    <option value="21:9">21:9</option>
                                    <option value="2:3">2:3</option>
                                    <option value="3:2">3:2</option>
                                    <option value="4:5">4:5</option>
                                    <option value="5:4">5:4</option>
                                    <option value="9:16">9:16</option>
                                    <option value="9:21">9:21</option>
                                </select>
                            </div>

                            <!-- Generate Button -->
                            <div class="flex items-end">
                                <button type="submit" id="generateBtn"
                                    class="w-full h-10 px-6 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                                    Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Gallery Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Gallery</h2>
                </div>

                <div id="gallery"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @forelse ($images ?? [] as $image)
                        <div
                            class="group relative bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="cursor-pointer" onclick="openCarousel({{ $loop->index }})">
                                <img src="{{ asset($image->filename) }}" alt="{{ $image->nombre }}"
                                    class="w-full h-48 object-cover transition-transform duration-200 group-hover:scale-105">
                            </div>
                            <div class="p-3">
                                <div class="flex items-center gap-1">
                                    <input type="text"
                                        class="text-xs text-gray-700 bg-transparent border-0 focus:ring-0 p-0 w-full filename-input"
                                        value="{{ pathinfo($image->nombre, PATHINFO_FILENAME) }}"
                                        data-id="{{ $image->id }}"
                                        data-extension="{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}">
                                    <span
                                        class="text-xs text-gray-400">.{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}</span>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <button
                                        onclick="downloadImage('{{ asset($image->filename) }}', '{{ pathinfo($image->nombre, PATHINFO_FILENAME) }}.{{ pathinfo($image->nombre, PATHINFO_EXTENSION) }}')"
                                        class="text-xs text-indigo-600 hover:text-indigo-700 transition-colors duration-150">
                                        Download
                                    </button>
                                    <button onclick="renameImage('{{ $image->id }}')"
                                        class="text-xs text-green-600 hover:text-green-700 transition-colors duration-150">
                                        Rename
                                    </button>
                                    <form class="deleteImageForm" data-id="{{ $image->id }}" method="POST"
                                        onsubmit="confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-red-600 hover:text-red-700 transition-colors duration-150">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No images generated yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Modal -->
    <div id="carouselModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300">
        <div class="relative w-full max-w-6xl mx-4">
            <!-- Close button with improved styling -->
            <button onclick="closeCarousel()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 z-50 group p-2">
                <svg class="w-8 h-8 transition-transform duration-200 group-hover:rotate-90" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="relative">
                <!-- Image counter -->
                <div class="absolute -top-12 left-0 text-white/80 text-sm">
                    <span id="imageCounter"></span>
                </div>

                <!-- Navigation buttons with improved styling -->
                <button onclick="previousImage()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white/80 hover:text-white transition-all duration-200 hover:scale-110 group bg-black/50 rounded-full p-3 hover:bg-black/70">
                    <svg class="w-8 h-8 transform transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div id="carouselContent" class="flex items-center justify-center min-h-[50vh] p-4">
                    <div class="relative w-full flex justify-center items-center">
                        <img id="carouselImage" src="" alt="carousel image"
                            class="max-h-[80vh] w-auto object-contain opacity-0 transition-opacity duration-300 rounded-lg shadow-2xl">
                        <!-- Loading spinner -->
                        <div id="imageLoader" class="absolute inset-0 flex items-center justify-center">
                            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white/20 border-t-white">
                            </div>
                        </div>
                    </div>
                </div>

                <button onclick="nextImage()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/80 hover:text-white transition-all duration-200 hover:scale-110 group bg-black/50 rounded-full p-3 hover:bg-black/70">
                    <svg class="w-8 h-8 transform transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Image information -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white p-6 opacity-0 transition-opacity duration-300"
                id="imageInfo">
                <h3 id="imageName" class="text-lg font-semibold mb-1"></h3>
                <p id="imageDetails" class="text-sm text-gray-300"></p>
            </div>
        </div>
    </div>




    <script>
        let currentImageIndex = 0;
        const images = @json($images ?? []);
        const baseUrl = "{{ asset('') }}"; // Obtiene la base URL correctamente
    
        function openCarousel(index) {
            currentImageIndex = index;
            const modal = document.getElementById('carouselModal');
            modal.classList.remove('hidden');
            // Fade in
            requestAnimationFrame(() => {
                modal.style.opacity = '1';
            });
            document.body.style.overflow = 'hidden';
            updateCarouselImage();
        }
    
        function closeCarousel() {
            const modal = document.getElementById('carouselModal');
            // Fade out
            modal.style.opacity = '0';
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
    
            // Mostrar loader y ocultar imagen actual
            imageLoader.style.display = 'flex';
            carouselImage.style.opacity = '0';
            imageInfo.style.opacity = '0';
    
            // Actualizar contador de imágenes
            imageCounter.textContent = `Imagen ${currentImageIndex + 1} de ${images.length}`;
    
            // Crear un nuevo objeto de imagen para precargar
            const newImage = new Image();
            newImage.onload = function () {
                // Ocultar loader
                imageLoader.style.display = 'none';
    
                // Actualizar y mostrar imagen
                carouselImage.src = this.src;
                carouselImage.alt = image.nombre;
    
                // Fade in de la imagen y la información
                requestAnimationFrame(() => {
                    carouselImage.style.opacity = '1';
                    imageInfo.style.opacity = '1';
                });
    
                // Actualizar la información de la imagen
                document.getElementById('imageName').textContent = image.nombre;
              
            };
    
            // Asignar la URL de la imagen con la baseUrl obtenida de Laravel
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
            return date.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    
        // Manejo de swipes en dispositivos táctiles
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
    
        // Manejo de teclas para navegación
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
    
        // Cerrar el modal al hacer clic fuera de la imagen
        document.getElementById('carouselModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeCarousel();
            }
        });
    
        // Precargar imágenes adyacentes
        function preloadAdjacentImages() {
            if (!images || images.length <= 1) return;
    
            const nextIndex = (currentImageIndex + 1) % images.length;
            const prevIndex = (currentImageIndex - 1 + images.length) % images.length;
    
            new Image().src = baseUrl + images[nextIndex].filename;
            new Image().src = baseUrl + images[prevIndex].filename;
        }
    </script>
    


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modelSelect = document.getElementById('ai-type');
            const formatSelect = document.getElementById('output_format');
            const webpOption = formatSelect.querySelector('.webp-option');

            // Función para mostrar/ocultar la opcgión WebP
            function toggleWebpOption() {
                if (modelSelect.value === 'sd3') {
                    webpOption.style.display = 'none'; // Oculta WebP si el modelo es SD3
                    if (formatSelect.value === 'webp') {
                        formatSelect.value = 'jpeg'; // Cambia a JPEG si WebP estaba seleccionado
                    }
                } else {
                    webpOption.style.display = 'block'; // Muestra WebP para otros modelos
                }
            }

            // Escuchar cambios en el select de modelo
            modelSelect.addEventListener('change', toggleWebpOption);

            // Ejecutar la función al cargar la página
            toggleWebpOption();
        });
    </script>

    <script>
        // Function to confirm deletion
        function confirmDelete(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the form that triggered the event
            const form = event.target;

            // Get the image ID from the form's data-id attribute
            const imageId = form.getAttribute('data-id');

            // Show confirmation alert
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with deletion
                    deleteImage(imageId, form);
                }
            });
        }

        // Function to delete the image using AJAX
        function deleteImage(imageId, form) {
            const url = `{{ route('image.delete', ':id') }}`.replace(':id', imageId); // Build the URL

            // Send AJAX request
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success alert
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The image has been deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Remove the image from the DOM without reloading the page
                            form.closest('div.group').remove();
                        });
                    } else {
                        // Show error alert
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Could not delete the image.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while deleting the image.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>

    <script>
        function downloadImage(url, filename) {
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(console.error);
        }

        function renameImage(imageId) {
            const newName = document.querySelector(`input[data-id="${imageId}"]`).value.trim();
            const extension = document.querySelector(`input[data-id="${imageId}"]`).dataset.extension;
            const fullName = `${newName}.${extension}`;
            const renameImageUrl = `{{ route('image.rename', ':id') }}`.replace(':id', imageId);

            // Validate that the name is not empty
            if (!newName) {
                alert('Please enter a valid name.');
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
                        alert(data.message || 'Image renamed successfully!');
                    } else {
                        alert(data.message || 'Error renaming image.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while renaming the image.');
                });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const generateImage = '{{ route('image.generate', $id) }}';
            const generateBtn = document.getElementById('generateBtn');
            const imageGeneratorForm = document.getElementById('imageGeneratorForm');
            let isGenerating = false;

            imageGeneratorForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita el envío tradicional del formulario

                if (isGenerating) return; // Evita múltiples envíos
                isGenerating = true;

                // Cambiar el texto del botón y añadir el loader
                generateBtn.innerHTML = `
                <div class="flex items-center justify-center">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                    <span class="ml-2">Generating...</span>
                </div>
            `;
                generateBtn.disabled = true;

                // Obtener los datos del formulario
                const formData = new FormData(imageGeneratorForm);
                const prompt = formData.get('prompt');
                const aiType = formData.get('ai_type');
                const format = formData.get('output_format');
                const aspectRatio = formData.get('aspect_ratio');

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
                            // Aquí puedes manejar la respuesta, por ejemplo, actualizar la galería
                            Swal.fire({
                                title: 'Image generated!',
                                text: 'The image has been generated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            // Recargar la galería o añadir la nueva imagen dinámicamente
                            location.reload(); // Recargar la página para ver la nueva imagen
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Error generating image: ' + data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while generating the image.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    })
                    .finally(() => {
                        // Restaurar el botón a su estado original
                        generateBtn.innerHTML = 'Generate';
                        generateBtn.disabled = false;
                        isGenerating = false;
                    });
            });
        });
    </script>
</x-guest-layout>