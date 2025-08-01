<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-10 py-8">
        <!-- Header Component -->
        <x-blog-header />

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content Area (75%) -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Content Editor Component -->
                <x-blog-content-editor :topic="$topic" :generatedContent="$generatedContent" />

                <!-- Image Generator Component -->
                <x-blog-image-generator />
            </div>

            <!-- Sidebar (25%) -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Image Preview Component -->
                <x-blog-image-preview :client="$client" />
            </div>

        </div>
    </div>
    <!-- Modal para la vista previa -->
    <!-- Modal para la vista previa -->


    <!-- Modal para la vista previa -->
    <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Blog Preview</h2>
                <button id="closePreviewModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <div id="previewContent"></div>
        </div>
    </div>


    @push('js')
        <script>
            // rutas para cuando escale
            const metaDataRoute = "{{ route('generate-meta-title') }}";
            const metaDescripcionRoute = "{{ route('generate-meta-description') }}";
            const extraBlogRoute = "{{ route('generate-extra-blog') }}";
            const imageGeneratorRoute = "{{ route('image.generate', $client->highlevel_id) }}";
            const website = @json($client->website).replace(/\/$/, '');
            const createBlog = "{{ route('blog.store', $client->highlevel_id) }}";
            const showRoute = "{{ route('blog.show', $client->highlevel_id) }}";
            const city = @json($client->city);
            
        </script>

        <!-- Estilos CSS para mejorar la presentación del contenido HTML -->
        <style>
            /* Estilos para el editor CKEditor */
            .ck-content {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                line-height: 1.6;
                color: #374151;
            }
            
            .ck-content h1, .ck-content h2, .ck-content h3, .ck-content h4, .ck-content h5, .ck-content h6 {
                color: #1f2937;
                font-weight: 600;
                margin-top: 1.5em;
                margin-bottom: 0.75em;
            }
            
            .ck-content h1 { 
                font-size: 2rem; 
                border-bottom: 2px solid #e5e7eb;
                padding-bottom: 0.5em;
            }
            
            .ck-content h2 { 
                font-size: 1.5rem; 
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 0.25em;
            }
            
            .ck-content h3 { font-size: 1.25rem; }
            
            .ck-content p {
                margin-bottom: 1em;
                line-height: 1.75;
            }
            
            .ck-content a {
                color: #2563eb;
                text-decoration: underline;
            }
            
            .ck-content a:hover {
                color: #1d4ed8;
            }
            
            .ck-content ul, .ck-content ol {
                margin-bottom: 1em;
                padding-left: 1.5em;
            }
            
            .ck-content li {
                margin-bottom: 0.5em;
            }
            
            .ck-content blockquote {
                border-left: 4px solid #e5e7eb;
                padding-left: 1em;
                margin: 1.5em 0;
                font-style: italic;
                color: #6b7280;
                background-color: #f9fafb;
                padding: 1em;
                border-radius: 0.375rem;
            }
            
            /* Estilos para la vista previa */
            .prose {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                line-height: 1.6;
                color: #374151;
            }
            
            .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
                color: #1f2937;
                font-weight: 600;
                margin-top: 1.5em;
                margin-bottom: 0.75em;
            }
            
            .prose h1 { 
                font-size: 2.25rem; 
                border-bottom: 2px solid #e5e7eb;
                padding-bottom: 0.5em;
            }
            
            .prose h2 { 
                font-size: 1.875rem; 
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 0.25em;
            }
            
            .prose h3 { font-size: 1.5rem; }
            
            .prose p {
                margin-bottom: 1em;
                line-height: 1.75;
            }
            
            .prose a {
                color: #2563eb;
                text-decoration: underline;
            }
            
            .prose a:hover {
                color: #1d4ed8;
            }
            
            .prose ul, .prose ol {
                margin-bottom: 1em;
                padding-left: 1.5em;
            }
            
            .prose li {
                margin-bottom: 0.5em;
            }
            
            .prose blockquote {
                border-left: 4px solid #e5e7eb;
                padding-left: 1em;
                margin: 1.5em 0;
                font-style: italic;
                color: #6b7280;
                background-color: #f9fafb;
                padding: 1em;
                border-radius: 0.375rem;
            }
        </style>

        <script src="{{ asset('js/blog/main.js') }}"></script>
        <script src="{{ asset('js/blog/util.js') }}"></script>
        <script src="{{ asset('js/blog/image-generator.js') }}"></script>
        <script src="{{ asset('js/blog/editor.js') }}"></script>
        <script src="{{ asset('js/blog/metada.js') }}"></script>




        <script>
            function setupWordPressFetching() {

                $.ajax({
                    url: website + '/wp-json/limo-blogs/v1/categories',
                    type: 'GET',
                    timeout: 10000,
                    success: function(data) {
                        const categoriesSelect = $('#categoriesSelect');

                        if (Array.isArray(data)) {
                            data.forEach(category => {
                                categoriesSelect.append(
                                    `<option value="${category.id}">${category.name}</option>`
                                );
                            });
                            // showAlert('success', 'Categories loaded successfully');
                        } else {
                            console.error("Unexpected data format:", data);
                            showAlert('warning', 'Unexpected data format when loading categories');
                        }

                        $('#loadingSpinner').addClass('hidden');
                    },
                    error: function(error) {
                        $('#loadingSpinner').addClass('hidden');
                        showAlert('error', 'Error loading blog categories. Please try again later.');
                        console.error("Error fetching categories:", error);
                    }
                });


            }

            // Configuración del envío del formulario
            function setupFormSubmission() {
                document.getElementById('contentForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Evitar envío tradicional del formulario

                    // Asegurarse de que el contenido del editor esté incluido
                    if (!editorInstance) {
                        showAlert('error', 'Editor not initialized. Please refresh the page.');
                        return;
                    }

                    const formData = new FormData(this);
                    const payload = {
                        content: editorInstance.getData(),
                        website: website, // Cambiar a la URL de tu sitio web
                        generated_image: imageUrl ?? null,
                        schedule_date: formData.get('schedule_date'),
                        post_status: formData.get('post_status'),
                        categories: formData.getAll('categories'),
                        title: formData.get('title')
                    };
                    console.log(payload);

                    // Mostrar spinner
                    const submitSpinner = document.getElementById('submitSpinner');
                    submitSpinner.classList.remove('hidden');

                    fetch(createBlog, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(payload),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Verifica que data.permalink esté correctamente definido
                            console.log(data.permalink,typeof(data.data.permalink));
                            // Oculta el spinner
                            submitSpinner.classList.add('hidden');

                            // Usa data en lugar de payload
                            const status = payload.post_status; // Mantén esto si payload contiene el estado enviado

                            let alertConfig = {
                                title: '',
                                html: '',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                showCancelButton: false
                            };

                            switch (status) {
                                case 'publish':
                                    alertConfig = {
                                        title: 'Blog Published Successfully!',
                                        html: `
                                                <p class="mb-4">Your blog post is now live.</p>
                                                <a href="${data.data.permalink}" target="_blank" 
                                                class="text-blue-600 hover:text-blue-800 underline">
                                                View Blog Post
                                                </a>
                                            `,
                                        icon: 'success',
                                        confirmButtonText: 'Done',
                                        showCancelButton: true,
                                        cancelButtonText: 'View All Posts',
                                        cancelButtonColor: '#3085d6'
                                    };
                                    break;
                                case 'draft':
                                    alertConfig = {
                                        title: 'Draft Saved',
                                        html: 'Your blog post has been saved as a draft',
                                        icon: 'info',
                                        confirmButtonText: 'OK'
                                    };
                                    break;
                                case 'schedule':
                                    alertConfig = {
                                        title: 'Blog Scheduled',
                                        html: `Post scheduled for publication on ${payload.schedule_date}`,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    };
                                    break;
                            }

                            Swal.fire(alertConfig).then((result) => {
                                if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                                    window.location.href = showRoute;
                                }
                            });
                        })
                        .catch(error => {
                            // Oculta el spinner en caso de error
                            submitSpinner.classList.add('hidden');
                            console.error('Error:', error);

                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while creating the blog post.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        });
                });
            }
        </script>
        <script>
            // Parse the selected pages from PHP to JavaScript
            const selectedPages = {!! json_encode(json_decode($client->selected_pages)) !!};

            // Función para mostrar las páginas seleccionadas
            function displaySelectedPages(pages) {
                // Contenedor principal con desplazamiento y tamaño fijo
                const $pagesContainer = $('<div>')
                    .addClass(
                        'pages-container bg-gray-100 border border-gray-300 rounded-lg overflow-auto p-4'
                    )
                    .css({
                        'height': '200px',
                        'width': '100%',
                        'max-width': '100%',
                        'margin': '0 auto'
                    });

                // Crear lista ordenada
                const $orderedList = $('<ol>')
                    .addClass('list-decimal list-inside space-y-2');

                // Crear elementos de lista para cada página
                pages.forEach(function(page) {
                    const $listItem = $('<li>')
                        .addClass('text-gray-800 hover:text-blue-600 transition-all')
                        .append(
                            $('<a>')
                            .attr('href', '#') // Cambiar a # para evitar navegación
                            .attr('data-page-url', page.url) // Almacenar la URL como atributo de datos
                            .attr('data-page-title', page.title) // Almacenar el título como atributo de datos
                            .addClass(
                                'text-md font-medium break-words hover:underline page-link')
                            .text(page.title)
                            .on('click', function(e) {
                                e.preventDefault(); // Prevenir comportamiento predeterminado
                                applyLinkToSelectedText($(this).attr('data-page-url'), $(
                                    this).attr('data-page-title'));
                            })
                        );

                    // Añadir elemento de lista a la lista ordenada
                    $orderedList.append($listItem);
                });

                // Añadir lista ordenada al contenedor principal
                $pagesContainer.append($orderedList);

                // Limpiar contenedor existente y añadir uno nuevo
                $('#select-container').html($pagesContainer);

                // Agregar título explicativo al contenedor
                $('#select-container').prepend(
                    $('<div>')
                    .addClass('text-sm text-gray-600 mb-2 font-medium')
                    .text(
                        'Select text in the editor and click on a page to create a link:'
                    )
                );
            }

            // Función para aplicar enlace al texto seleccionado en el editor
            function applyLinkToSelectedText(url, pageTitle) {
                // Verificar que el editor existe
                if (!editorInstance) {
                    showAlert('error', 'Editor not initialized. Please refresh the page.');
                    return;
                }

                // Obtener selección actual del editor
                const selection = editorInstance.model.document.selection;

                // Verificar si hay texto seleccionado
                if (selection.isCollapsed) {
                    // Si no hay selección, mostrar alerta
                    showAlert('warning', 'Please select some text in the editor first to create a link.');
                    return;
                }

                // Crear modelo de enlace
                editorInstance.execute('link', url, {
                    linkIsExternal: true,
                    linkIsDownloadable: false
                });

                // Mostrar mensaje de éxito
                showAlert('success', `Link created to "${pageTitle}"`);
            }

            // Asegúrate de que el editor tenga estilos CSS para los enlaces
            const editorStyles = `
            .ck-content a {
                color: blue;
                text-decoration: underline;
            }
        `;

            // Agregar estilos al editor
            const styleElement = document.createElement('style');
            styleElement.innerHTML = editorStyles;
            document.head.appendChild(styleElement);

            // Mostrar las páginas seleccionadas cuando el documento esté listo
            document.addEventListener('DOMContentLoaded', () => {
                displaySelectedPages(selectedPages);
            });
        </script>

        <script>
            // ui.js - Funcionalidad para elementos de interfaz de usuario

            // Configuración de elementos fijos
            function setupStickyElements() {
                // Ajuste de posición para asegurar que ambos elementos se muestren correctamente
                const handleScroll = () => {
                    const scrollTop = $(window).scrollTop();
                    const blocksSectionHeight = $('#available-blocks-section').outerHeight();
                    const windowHeight = $(window).height();

                    // Ajustar posición del segundo elemento para que siempre sea visible
                    // sin superponerse con el primero
                    if (scrollTop + blocksSectionHeight + 20 > windowHeight) {
                        $('#image-preview-section').css('top', Math.max(8, windowHeight - $('#image-preview-section')
                            .outerHeight()));
                    } else {
                        $('#image-preview-section').css('top', 'calc(8rem + 170px)');
                    }
                };

                $(window).on('scroll resize', handleScroll);
                handleScroll(); // Ejecutar al inicio
            }
        </script>
    @endpush

    <footer class="w-full text-center py-6 text-gray-500 text-sm border-t mt-8">
        <p>
            This site is protected by U.S. data protection laws. <br>
            <a href="{{ route('privacy.policy') }}" class="text-blue-600 hover:underline">Privacy Policy</a> |
            <a href="{{ route('terms.service') }}" class="text-blue-600 hover:underline">Terms of Service</a>
        </p>
    </footer>
</x-guest-layout>
