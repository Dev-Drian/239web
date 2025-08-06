<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-white">
                    {{ __('Blog Management') }}
                </h2>
                <span class="text-sm text-slate-400">Content Publishing System</span>
            </div>
        </div>
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <x-stat-card iconColor="indigo" title="Total Posts" value="0" id="totalPosts" />
            <x-stat-card iconColor="green" title="Indexed" value="0" id="indexedPosts" />
            <x-stat-card iconColor="yellow" title="Pending" value="0" id="pendingPosts" />
        </div>
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="flex justify-center my-8 ">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
        </div>
        <!-- Blog Posts Table -->
        <div x-data="{ open: false }"
            class="glass-dark shadow-xl sm:rounded-lg mb-6 transition-all duration-300 hover:shadow-lg overflow-hidden border border-white/15">
            <button @click="open = !open"
                class="w-full text-left px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold uppercase tracking-wider focus:outline-none flex items-center justify-between">
                <span>Show/Hide Blog Table</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-500 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="overflow-x-auto p-4 glass-dark rounded-b-lg shadow-inner">
                    <table class="min-w-full divide-y divide-white/15">
                        <thead class="glass-dark">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Posts Indexed</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">PR</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Date Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="postsTable" class="glass-dark divide-y divide-white/15"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Blog Topic Suggestions Component -->
        <div class="glass-dark rounded-xl shadow-lg w-full h-full overflow-hidden border border-white/15">
            <!-- Header Section -->
            <div class="px-6 py-4 flex justify-between items-center bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border-b border-white/15">
                <div>
                    <h3 class="text-lg font-medium text-white">Blog Topic Suggestions</h3>
                    <p class="text-sm text-slate-300">Generate and manage blog topics</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- AI Type Toggle Buttons -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-300">AI Type:</span>
                        <div class="flex rounded-lg overflow-hidden border border-white/20">
                            <button id="gptButton"
                                class="px-3 py-1.5 bg-indigo-500 text-white font-medium text-sm hover:bg-indigo-600 transition-colors ai-type-button active">
                                GPT
                            </button>
                            <button id="perplexityButton"
                                class="px-3 py-1.5 glass-dark text-slate-300 font-medium text-sm hover:bg-white/10 transition-colors ai-type-button">
                                Perplexity
                            </button>
                        </div>
                    </div>
                    <!-- Generate Suggestions Button -->
                    <button id="getSuggestions"
                        class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center"
                        onclick="contentGenerate()">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Give Topic Suggestions
                    </button>
                </div>
            </div>
            <!-- Content Section -->
            <div class="p-6 overflow-y-auto h-[calc(100%-120px)] glass-dark rounded-b-xl">
                <!-- Spinner de carga -->
                <div id="suggestionsSpinner" class="hidden flex flex-col items-center justify-center py-12 space-y-3">
                    <div class="flex space-x-2">
                        <div class="h-4 w-4 bg-indigo-500 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                        <div class="h-4 w-4 bg-indigo-400 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                        <div class="h-4 w-4 bg-indigo-300 rounded-full animate-bounce"></div>
                    </div>
                    <span class="text-slate-300 text-lg font-medium">Generating suggestions...</span>
                </div>
                <!-- Área de sugerencias -->
                <div id="suggestionsArea" class="space-y-4 divide-y divide-white/15"></div>
            </div>
        </div>
        <!-- Modal para enviar a index -->
        <div id="submitToIndexModal"
            class="hidden fixed inset-0 bg-black bg-opacity-80 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
            <div class="relative top-20 mx-auto p-6 border w-96 shadow-xl rounded-lg glass-dark border-white/15">
                <!-- Modal Header -->
                <div class="text-center mb-4">
                    <h3 class="text-xl leading-6 font-semibold text-white">Submit to Index</h3>
                    <p class="text-sm text-slate-300 mt-2">Enter the campaign name to submit the post for indexing.</p>
                </div>
                <!-- Modal Body -->
                <div class="mt-5">
                    <label for="campaignName" class="block text-sm font-medium text-slate-300 mb-1">Campaign Name</label>
                    <input type="text" id="campaignName" placeholder="Enter Campaign Name"
                        class="mt-1 p-3 glass border border-white/20 rounded-lg w-full bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-200"
                        aria-label="Campaign Name">
                </div>
                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button onclick="closeModal()"
                        class="px-4 py-2 glass-dark text-slate-300 text-base font-medium rounded-lg shadow-sm hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-colors duration-200">
                        Cancel
                    </button>
                    <button id="submitIndexBtn"
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-base font-medium rounded-lg shadow-sm hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-colors duration-200">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para enviar a index -->
    <div id="submitToIndexModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <!-- Modal Container -->
        <div
            class="relative top-20 mx-auto p-6 border w-96 shadow-xl rounded-lg bg-white transform transition-all duration-300 ease-in-out">
            <!-- Modal Header -->
            <div class="text-center mb-4">
                <h3 class="text-xl leading-6 font-semibold text-gray-900">Submit to Index</h3>
                <p class="text-sm text-gray-600 mt-2">Enter the campaign name to submit the post for indexing.</p>
            </div>

            <!-- Modal Body -->
            <div class="mt-5">
                <label for="campaignName" class="block text-sm font-medium text-gray-700 mb-1">Campaign Name</label>
                <input type="text" id="campaignName" placeholder="Enter Campaign Name"
                    class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    aria-label="Campaign Name">
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200">
                    Cancel
                </button>
                <button id="submitIndexBtn"
                    class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                    Submit
                </button>
            </div>
        </div>
    </div>


    <script>
        // Variables globales para el blog
        window.website = @json($client->website ?? '').replace(/\/$/, '');
        window.city = @json($client->city ?? '');
        window.businessName = @json($client->name ?? '');
        
        // Manejar servicios correctamente - puede ser array, string JSON, o null
        let servicesData = @json($client->services ?? []);
        if (typeof servicesData === 'string') {
            try {
                servicesData = JSON.parse(servicesData);
            } catch (e) {
                console.error('Error parsing services:', e);
                servicesData = [];
            }
        }
        window.services = Array.isArray(servicesData) ? servicesData : [];
        
        window.blog = @json($client->blog ?? []);



        const submitUrlRoute = "{{ route('blog.submitUrls', $client->highlevel_id) }}";
        const createRoute = "{{ route('blog.create', $client->highlevel_id) }}";

        // Rutas para GPT y Perplexity
        const gptEndpoint = "{{ route('generate-content.gpt') }}"; // Ruta para GPT
        const perplexityEndpoint = "{{ route('generate-content.perplexity') }}"; // para obtener sugerencias

        // Función para abrir el modal con animación
    </script>


    <script>
        document.querySelectorAll('.ai-type-button').forEach(button => {
            button.addEventListener('click', function() {
                // Limpiar todos los botones primero
                document.querySelectorAll('.ai-type-button').forEach(btn => {
                    btn.classList.remove('active', 'bg-blue-600', 'text-white', 'bg-white', 'text-gray-700');
                });
                
                // Aplicar el estilo azul al botón clickeado
                this.classList.add('active', 'bg-blue-600', 'text-white');
                
                // Aplicar el estilo gris al otro botón
                if (this.id === 'gptButton') {
                    document.getElementById('perplexityButton').classList.add('bg-white', 'text-gray-700');
                } else {
                    document.getElementById('gptButton').classList.add('bg-white', 'text-gray-700');
                }
            });
        });


        // Función para alternar la visibilidad de los subtítulos
        function toggleSubtitles(index) {
            const subtitles = document.getElementById(`subtitles-${index}`);
            const icon = document.getElementById(`icon-${index}`);
            if (subtitles.style.maxHeight) {
                subtitles.style.maxHeight = null;
                icon.classList.remove('rotate-180');
            } else {
                subtitles.style.maxHeight = `${subtitles.scrollHeight}px`;
                icon.classList.add('rotate-180');
            }
        }

        // Función para actualizar el título de un tema
        function updateTopicTitle(index, newTitle) {
            topics[index].title = newTitle;
        }

        // Función para actualizar un subtítulo
        function updateSubtitle(topicIndex, subtitleIndex, newSubtitle) {
            topics[topicIndex].subtitles[subtitleIndex] = newSubtitle;
        }

        // Función para eliminar un subtítulo
        function deleteSubtitle(topicIndex, subtitleIndex) {
            topics[topicIndex].subtitles.splice(subtitleIndex, 1);
            renderTopicCards(); // Volver a renderizar las tarjetas
        }

        // Función para añadir un subtítulo
        function addSubtitle(topicIndex) {
            topics[topicIndex].subtitles.push("New Subtitle");
            renderTopicCards(); // Volver a renderizar las tarjetas
        }

        // Función para eliminar un tema
        function deleteTopic(index) {
            topics.splice(index, 1);
            renderTopicCards(); // Volver a renderizar las tarjetas
        }

        // Función para usar un tema (debes implementar su lógica)
        function useTopic(index) {
            const topic = topics[index];
            console.log("Using topic:", topic);
            // Aquí puedes agregar la lógica para usar el tema seleccionado
        }
    </script>
    <!-- Script para manejar el modal y las sugerencias -->
    <script>
        // Variables globales
        let currentOpenTopicIndex = null;
        let topics = []; // Agregamos la definición de topics que faltaba



        // Función para abrir el modal de sugerencias
        function contentGenerate() {
            $('#suggestionsSpinner').show();
            $('#suggestionsArea').html('');
            const validationErrors = [];

            if (!businessName) {
                validationErrors.push("Business Name");
            }
            if (!city) {
                validationErrors.push("City");
            }
            if (!services || services.length === 0) {
                validationErrors.push("Services");
            }
            if (!website) {
                validationErrors.push("Website");
            }

            // If there are validation errors, show SweetAlert
            if (validationErrors.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    html: `The following information is required:<br><br>
                        <span class="font-medium text-red-600">${validationErrors.join('<br>')}</span><br><br>
                        <strong>Update the information here:</strong>`,
                    confirmButtonText: 'Go to Update',
                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    customClass: {
                        container: 'sweet-alert-custom',
                        title: 'text-lg font-medium text-gray-900',
                        htmlContainer: 'text-base text-gray-700'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `{{ route('client.show', ['client' => $client->id]) }}?tab=services`;
                    }
                });
                return;
            }



            // Obtener el tipo de IA seleccionado
            const aiType = document.querySelector('.ai-type-button.active').textContent.trim().toLowerCase();
            console.log(aiType);

            // Construir el prompt
            const prompt =
                `The business named ${escapeHtml(businessName)} is located in ${escapeHtml(city)}. It offers the following services: ${services.map(service => escapeHtml(service)).join(", ")}. Please suggest 6 blog topics with 3 to 5 subtitles for each topic. Do include the name of the company in 2 titles or subtitles mix and match.`;

            // Determinar el endpoint según el tipo de IA
            const endpoint = aiType === 'gpt' ? gptEndpoint : perplexityEndpoint;

            // Petición AJAX
            $.ajax({
                url: endpoint,
                type: 'POST',
                data: {
                    prompt: prompt,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function(response) {
                    // Procesar la respuesta
                    console.log(response);
                    
                    processTopicsResponse(response); // Pasa la respuesta directamente
                },
                error: function(xhr, status, error) {
                    $('#suggestionsArea').html(`
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                    <p class="font-medium">Error generating suggestions</p>
                    <p class="text-sm mt-1">${error || 'Please try again later'}</p>
                </div>
            `);
                },
                complete: function() {
                    $('#suggestionsSpinner').hide();
                }
            });
        }

        // Función para procesar la respuesta y extraer temas
        function processTopicsResponse(response) {
            topics = [];

            // Extraer el contenido de la respuesta
            const content = typeof response === 'object' && response.content ? response.content : response;

            // Verificar si el contenido es un string
            if (typeof content !== 'string') {
                console.error("La respuesta no es un string:", content);
                return;
            }

            console.log("Contenido a procesar:", content);

            // Procesar el contenido
            const lines = content.split('\n');
            let currentTopic = null;
            let waitingForTitle = false;

            lines.forEach((line, index) => {
                line = line.trim();

                // Detectar títulos (formato: "### Topic 1: The Ultimate Guide..." o "### Topic 1:  \nTítulo")
                if (line.startsWith('### ')) {
                    if (currentTopic) {
                        topics.push(currentTopic);
                    }
                    
                    // Verificar si el título está en la misma línea o en la siguiente
                    const titleInSameLine = line.replace('### ', '').replace(/^Topic \d+:\s*/, '');
                    
                    if (titleInSameLine.trim()) {
                        // El título está en la misma línea
                        currentTopic = {
                            title: cleanText(titleInSameLine),
                            subtitles: []
                        };
                        console.log("Título encontrado (misma línea):", titleInSameLine);
                    } else {
                        // El título está en la siguiente línea
                        waitingForTitle = true;
                        currentTopic = {
                            title: '',
                            subtitles: []
                        };
                        console.log("Esperando título en la siguiente línea");
                    }
                }
                // Si estamos esperando un título, esta línea es el título
                else if (waitingForTitle && line && !line.startsWith('-')) {
                    currentTopic.title = cleanText(line);
                    waitingForTitle = false;
                    console.log("Título encontrado (línea siguiente):", line);
                }
                // Detectar subtítulos (formato: "- ***Subtítulo***")
                else if (line.startsWith('-')) {
                    if (currentTopic) {
                        // Eliminar "- " y "***" del subtítulo
                        const subtitle = line.replace(/^-\s*/, '').replace(/\*\*\*/g, '');
                        currentTopic.subtitles.push(cleanText(subtitle)); // Limpia el texto
                        console.log("Subtítulo encontrado:", subtitle);
                    }
                }
            });

            if (currentTopic) {
                topics.push(currentTopic);
            }

            console.log("Temas procesados:", topics);

            // Renderizar los temas en la interfaz
            renderTopicCards();
        }

        function renderTopicCards() {
            let html = '';

            if (topics.length === 0) {
                html = `<div class="text-center py-8 text-gray-500">No topics generated yet</div>`;
            } else {
                html = `<div class="grid grid-cols-1 md:grid-cols-2 gap-4">`;

                topics.forEach((topic, index) => {
                    html += `
                    <div class="border-2 rounded-lg p-4 hover:shadow-md transition-all duration-300 bg-white">
                        <!-- Título del tema -->
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleSubtitles(${index})">
                            <input type="text" value="${escapeHtml(topic.title)}"
                                class="font-medium text-gray-900 bg-transparent border-none focus:ring-0 w-full"
                                onchange="updateTopicTitle(${index}, this.value)">
                            <svg id="icon-${index}" class="h-5 w-5 text-gray-500 transform transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Subtítulos -->
                        <div id="subtitles-${index}" class="mt-2 space-y-2 overflow-hidden transition-all duration-300 max-h-0">
                            ${topic.subtitles.map((subtitle, i) => `
                                                                                                                                                                            <div class="flex items-center justify-between pl-4 group">
                                                                                                                                                                                <input type="text" value="${escapeHtml(subtitle)}"
                                                                                                                                                                                    class="text-sm text-gray-600 bg-transparent border-none focus:ring-0 w-full"
                                                                                                                                                                                    onchange="updateSubtitle(${index}, ${i}, this.value)">
                                                                                                                                                                                <button onclick="deleteSubtitle(${index}, ${i})"
                                                                                                                                                                                    class="ml-2 text-red-600 hover:text-red-900 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                                                                                                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                                                                                                                    </svg>
                                                                                                                                                                                </button>
                                                                                                                                                                            </div>
                                                                                                                                                                        `).join('')}

                            <!-- Botón para añadir subtítulo -->
                            <button onclick="addSubtitle(${index})"
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Subtitle
                            </button>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-4 flex flex-wrap gap-2">
                            <!-- Botón "Use Topic" -->
                            <button onclick="useTopic(${index})"
                                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-all duration-300 shadow-sm hover:shadow-md flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Use Topic
                            </button>

                            <!-- Botón para eliminar el tema -->
                            <button onclick="deleteTopic(${index})"
                                class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md transition-all duration-300 shadow-sm hover:shadow-md ml-auto">
                                Delete
                            </button>
                        </div>
                    </div>`;
                });

                html += `</div>`;
            }

            document.getElementById('suggestionsArea').innerHTML = html;
        }

        function useTopic(index) {
            const topic = topics[index];

            // Limpiar el título y los subtítulos antes de enviarlos
            topic.title = cleanText(topic.title);
            topic.subtitles = topic.subtitles.map(subtitle => cleanText(subtitle));

            // Obtener el tipo de IA seleccionado (GPT o Perplexity)
            const aiType = document.querySelector('.ai-type-button.active').textContent.trim().toLowerCase();

            // Codificar los datos para incluirlos en la URL
            const encodedTopic = encodeURIComponent(JSON.stringify(topic)); // Codificar el tema como JSON
            const encodedModel = encodeURIComponent(aiType); // Codificar el modelo

            // Construir la URL con los datos
            const url = `${createRoute}?topic=${encodedTopic}&model=${encodedModel}`;

            // 🔹 Mostrar el overlay de carga antes de redirigir
            showLoadingScreen();

            // Redirigir al usuario a la URL
            setTimeout(() => {
                window.location.href = url;
            }, 100); // Pequeña demora para mostrar el spinner antes de salir
        }

        function showLoadingScreen() {
            // Evitar que se agregue más de una vez
            if (document.getElementById('loading-overlay')) return;

            // Crear el overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'loading-overlay';
            loadingOverlay.style.position = 'fixed';
            loadingOverlay.style.top = '0';
            loadingOverlay.style.left = '0';
            loadingOverlay.style.width = '100vw';
            loadingOverlay.style.height = '100vh';
            loadingOverlay.style.background = 'rgba(0, 0, 0, 0.8)';
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.flexDirection = 'column';
            loadingOverlay.style.justifyContent = 'center';
            loadingOverlay.style.alignItems = 'center';
            loadingOverlay.style.zIndex = '9999';
            loadingOverlay.style.color = 'white';
            loadingOverlay.style.fontSize = '18px';
            loadingOverlay.style.fontFamily = 'Arial, sans-serif';

            // Crear el spinner
            const spinner = document.createElement('div');
            spinner.style.width = '50px';
            spinner.style.height = '50px';
            spinner.style.border = '5px solid rgba(255, 255, 255, 0.3)';
            spinner.style.borderTop = '5px solid white';
            spinner.style.borderRadius = '50%';
            spinner.style.animation = 'spin 1s linear infinite';

            // Crear el mensaje de espera
            const message = document.createElement('p');
            message.textContent = 'Processing, please wait...';
            message.style.marginTop = '15px';
            message.style.fontSize = '16px';
            message.style.opacity = '0.9';

            // Agregar elementos al overlay
            loadingOverlay.appendChild(spinner);
            loadingOverlay.appendChild(message);
            document.body.appendChild(loadingOverlay);

            // Agregar la animación de CSS
            const style = document.createElement('style');
            style.innerHTML = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
            document.head.appendChild(style);
        }

        // 🔹 Eliminar el loading al volver a la página, incluso con el botón de retroceso
        window.addEventListener('pageshow', () => {
            const loadingOverlay = document.getElementById('loading-overlay');
            if (loadingOverlay) {
                loadingOverlay.remove();
            }
        });


        function escapeHtml(str) {
            return str.replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function cleanText(text) {
            if (!text) return '';
            
            // Elimina números seguidos de un punto (ej: "1.", "2.", etc.)
            text = text.replace(/^\d+\.\s*/, ''); // Elimina el número y el punto al inicio
            // Elimina caracteres especiales como **
            text = text.replace(/\*\*/g, ''); // Elimina los **
            // Elimina espacios adicionales al inicio y final
            text = text.trim();
            // Elimina espacios múltiples
            text = text.replace(/\s+/g, ' ');
            
            console.log("Texto limpio:", text);
            return text;
        }
        // Función para renderizar las tarjetas de temas
    </script>
    <script>
        // Asegurar que las variables estén disponibles antes de cargar blog.js
        if (typeof window.website === 'undefined') {
            console.error('Website variable is not defined');
            window.website = '';
        }
        if (typeof window.blog === 'undefined') {
            console.error('Blog variable is not defined');
            window.blog = [];
        }
    </script>
    <script src="{{ asset('js/blog/blog.js') }}"></script>

    <style>
        /* Estilos personalizados para los botones de tipo AI */
        .ai-type-button.active {
            background-color: #2563eb !important; /* bg-blue-600 */
            color: white !important;
        }
        
        .ai-type-button.active:hover {
            background-color: #1d4ed8 !important; /* bg-blue-700 */
            color: white !important;
        }
        
        .ai-type-button:not(.active) {
            background-color: white !important;
            color: #374151 !important; /* text-gray-700 */
        }
        
        .ai-type-button:not(.active):hover {
            background-color: #f3f4f6 !important; /* bg-gray-100 */
            color: #374151 !important;
        }
    </style>

</x-guest-layout>
