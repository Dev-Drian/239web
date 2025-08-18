<script>
    {{-- Variables globales para el blog --}}
    // Función para normalizar URLs de sitios web
    function normalizeWebsiteUrl(url) {
        if (!url) return '';
        
        // Remover espacios en blanco
        let normalizedUrl = url.trim();
        
        // Agregar https:// si no tiene protocolo
        if (!normalizedUrl.startsWith('http://') && !normalizedUrl.startsWith('https://')) {
            normalizedUrl = 'https://' + normalizedUrl;
        }
        
        // Forzar HTTPS
        if (normalizedUrl.startsWith('http://')) {
            normalizedUrl = normalizedUrl.replace('http://', 'https://');
        }
        
        // Remover slash final
        normalizedUrl = normalizedUrl.replace(/\/$/, '');
        
        return normalizedUrl;
    }
    
    window.website = normalizeWebsiteUrl(@json($client->website ?? ''));
    window.city = @json($client->primary_city ?? $client->city ?? '');
    window.businessName = @json($client->name ?? '');
            
    {{-- Manejar servicios correctamente --}}
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
    {{-- Rutas para GPT y Perplexity --}}
    const gptEndpoint = "{{ route('generate-content.gpt') }}";
    const perplexityEndpoint = "{{ route('generate-content.perplexity') }}";
</script>

<script>
    {{-- Funcionalidad de los botones AI --}}
    document.querySelectorAll('.ai-type-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.ai-type-button').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'bg-white', 'text-gray-700');
                btn.classList.add('transform', 'transition-all', 'duration-200');
            });
                            
            this.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-lg', 'scale-105');
                            
            if (this.id === 'gptButton') {
                document.getElementById('perplexityButton').classList.add('bg-white', 'text-gray-700', 'scale-100');
            } else {
                document.getElementById('gptButton').classList.add('bg-white', 'text-gray-700', 'scale-100');
            }
        });
    });

    {{-- Función para alternar subtítulos --}}
    function toggleSubtitles(index) {
        const subtitles = document.getElementById(`subtitles-${index}`);
        const icon = document.getElementById(`icon-${index}`);
        
        if (subtitles.style.maxHeight) {
            subtitles.style.maxHeight = null;
            icon.classList.remove('rotate-180');
            subtitles.classList.add('opacity-0');
        } else {
            subtitles.style.maxHeight = `${subtitles.scrollHeight}px`;
            icon.classList.add('rotate-180');
            subtitles.classList.remove('opacity-0');
        }
    }

    {{-- Funciones JavaScript originales --}}
    function updateTopicTitle(index, newTitle) {
        topics[index].title = newTitle;
    }

    function updateSubtitle(topicIndex, subtitleIndex, newSubtitle) {
        topics[topicIndex].subtitles[subtitleIndex] = newSubtitle;
    }

    function deleteSubtitle(topicIndex, subtitleIndex) {
        topics[topicIndex].subtitles.splice(subtitleIndex, 1);
        renderTopicCards();
    }

    function addSubtitle(topicIndex) {
        topics[topicIndex].subtitles.push("New Subtitle");
        renderTopicCards();
    }

    function deleteTopic(index) {
        topics.splice(index, 1);
        renderTopicCards();
    }

    function useTopic(index) {
        const topic = topics[index];
        console.log("Using topic:", topic);
    }
</script>

<script>
    {{-- Variables globales --}}
    let currentOpenTopicIndex = null;
    let topics = [];

    {{-- Función para generar contenido --}}
    function contentGenerate() {
        const spinner = document.getElementById('suggestionsSpinner');
        const area = document.getElementById('suggestionsArea');
        
        spinner.classList.remove('hidden');
        spinner.classList.add('animate-pulse');
        area.innerHTML = '';

        const validationErrors = [];
        if (!businessName) validationErrors.push("Business Name");
        if (!city) validationErrors.push("City");
        if (!services || services.length === 0) validationErrors.push("Services");
        if (!website) validationErrors.push("Website");

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
            spinner.classList.add('hidden');
            return;
        }

        {{-- Resto del código original --}}
        const aiType = document.querySelector('.ai-type-button.active').textContent.trim().toLowerCase();
        const prompt = `The business named ${escapeHtml(businessName)} is located in ${escapeHtml(city)}. It offers the following services: ${services.map(service => escapeHtml(service)).join(", ")}. Please suggest 6 blog topics with 3 to 5 subtitles for each topic. Do include the name of the company in 2 titles or subtitles mix and match.`;
        const endpoint = aiType === 'gpt' ? gptEndpoint : perplexityEndpoint;

        $.ajax({
            url: endpoint,
            type: 'POST',
            data: {
                prompt: prompt,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
                processTopicsResponse(response);
            },
            error: function(xhr, status, error) {
                area.innerHTML = `
                    <div class="p-6 bg-red-50 border-2 border-red-200 rounded-xl text-red-700">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Error generating suggestions</p>
                                <p class="text-sm mt-1">${error || 'Please try again later'}</p>
                            </div>
                        </div>
                    </div>
                `;
            },
            complete: function() {
                spinner.classList.add('hidden');
                spinner.classList.remove('animate-pulse');
            }
        });
    }

    {{-- Resto de funciones JavaScript originales mantenidas igual --}}
    function processTopicsResponse(response) {
        topics = [];
        const content = typeof response === 'object' && response.content ? response.content : response;
        
        if (typeof content !== 'string') {
            console.error("Response is not a string:", content);
            return;
        }

        const lines = content.split('\n');
        let currentTopic = null;
        let waitingForTitle = false;

        lines.forEach((line, index) => {
            line = line.trim();
            
            if (line.startsWith('### ')) {
                if (currentTopic) {
                    topics.push(currentTopic);
                }
                                
                const titleInSameLine = line.replace('### ', '').replace(/^Topic \d+:\s*/, '');
                                
                if (titleInSameLine.trim()) {
                    currentTopic = {
                        title: cleanText(titleInSameLine),
                        subtitles: []
                    };
                } else {
                    waitingForTitle = true;
                    currentTopic = {
                        title: '',
                        subtitles: []
                    };
                }
            }
            else if (waitingForTitle && line && !line.startsWith('-')) {
                currentTopic.title = cleanText(line);
                waitingForTitle = false;
            }
            else if (line.startsWith('-')) {
                if (currentTopic) {
                    const subtitle = line.replace(/^-\s*/, '').replace(/\*\*\*/g, '');
                    currentTopic.subtitles.push(cleanText(subtitle));
                }
            }
        });

        if (currentTopic) {
            topics.push(currentTopic);
        }

        renderTopicCards();
    }

    function renderTopicCards() {
        let html = '';
        if (topics.length === 0) {
            html = `
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <p class="text-lg font-medium">No topics generated yet</p>
                </div>
            `;
        } else {
            html = `<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">`;
            topics.forEach((topic, index) => {
                html += `
                    <div class="border-2 border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-white to-gray-50 hover:border-blue-300">
                        <div class="flex justify-between items-center cursor-pointer mb-4" onclick="toggleSubtitles(${index})">
                            <input type="text" value="${escapeHtml(topic.title)}"
                                class="font-bold text-lg text-gray-900 bg-transparent border-none focus:ring-0 w-full pr-4"
                                onchange="updateTopicTitle(${index}, this.value)">
                            <svg id="icon-${index}" class="h-6 w-6 text-blue-500 transform transition-transform duration-300 flex-shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        
                        <div id="subtitles-${index}" class="space-y-3 overflow-hidden transition-all duration-300 max-h-0 opacity-0">
                            ${topic.subtitles.map((subtitle, i) => `
                                <div class="flex items-center justify-between pl-4 py-2 bg-white rounded-lg border border-gray-100 group hover:border-blue-200 transition-all duration-200">
                                    <input type="text" value="${escapeHtml(subtitle)}"
                                        class="text-sm text-gray-700 bg-transparent border-none focus:ring-0 w-full font-medium"
                                        onchange="updateSubtitle(${index}, ${i}, this.value)">
                                    <button onclick="deleteSubtitle(${index}, ${i})"
                                        class="ml-2 text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-all duration-200 p-1 rounded-full hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            `).join('')}
                            
                            <button onclick="addSubtitle(${index})"
                                class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Add Subtitle</span>
                            </button>
                        </div>
                        
                        <div class="mt-6 flex flex-wrap gap-3">
                            <button onclick="useTopic(${index})"
                                class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Use Topic</span>
                            </button>
                            
                            <button onclick="deleteTopic(${index})"
                                class="px-4 py-2 bg-gray-200 hover:bg-red-100 text-gray-700 hover:text-red-600 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                                Delete
                            </button>
                        </div>
                    </div>
                `;
            });
            html += `</div>`;
        }
        document.getElementById('suggestionsArea').innerHTML = html;
    }

    {{-- Funciones auxiliares --}}
    function useTopic(index) {
        const topic = topics[index];
        topic.title = cleanText(topic.title);
        topic.subtitles = topic.subtitles.map(subtitle => cleanText(subtitle));

        const aiType = document.querySelector('.ai-type-button.active').textContent.trim().toLowerCase();
        const encodedTopic = encodeURIComponent(JSON.stringify(topic));
        const encodedModel = encodeURIComponent(aiType);
        const url = `${createRoute}?topic=${encodedTopic}&model=${encodedModel}`;

        showLoadingScreen();
        setTimeout(() => {
            window.location.href = url;
        }, 100);
    }

    function showLoadingScreen() {
        if (document.getElementById('loading-overlay')) return;

        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex flex-col justify-center items-center z-50';
        
        loadingOverlay.innerHTML = `
            <div class="relative">
                <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin absolute top-2 left-2" style="animation-direction: reverse; animation-duration: 0.8s;"></div>
            </div>
            <p class="mt-6 text-white text-lg font-semibold">Processing, please wait...</p>
            <p class="mt-2 text-blue-200 text-sm">This may take a few moments</p>
        `;
        
        document.body.appendChild(loadingOverlay);
    }

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
        text = text.replace(/^\d+\.\s*/, '');
        text = text.replace(/\*\*/g, '');
        text = text.trim();
        text = text.replace(/\s+/g, ' ');
        return text;
    }

    {{-- Verificar variables --}}
    if (typeof window.website === 'undefined') {
        console.error('Website variable is not defined');
        window.website = '';
    }
    if (typeof window.blog === 'undefined') {
        console.error('Blog variable is not defined');
        window.blog = [];
    }

    {{-- Single Article Functions --}}
    const singleArticleRoute = "{{ route('blog.single-article', $client->highlevel_id) }}";

    function openSingleArticleModal() {
        document.getElementById('singleArticleModal').classList.remove('hidden');
        document.getElementById('articleTitle').focus();
    }

    function closeSingleArticleModal() {
        document.getElementById('singleArticleModal').classList.add('hidden');
        document.getElementById('articleTitle').value = '';
        document.getElementById('singleArticleLoading').classList.add('hidden');
        document.getElementById('generateSingleArticleBtn').disabled = false;
    }

    // AI Type buttons for Single Article modal
    document.querySelectorAll('#singleArticleModal .ai-type-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('#singleArticleModal .ai-type-button').forEach(btn => {
                btn.classList.remove('active', 'bg-green-600', 'text-white', 'bg-white', 'text-gray-700');
                btn.classList.add('transform', 'transition-all', 'duration-200');
            });
                            
            this.classList.add('active', 'bg-green-600', 'text-white', 'shadow-lg', 'scale-105');
                            
            if (this.id === 'singleGptButton') {
                document.getElementById('singlePerplexityButton').classList.add('bg-white', 'text-gray-700', 'scale-100');
            } else {
                document.getElementById('singleGptButton').classList.add('bg-white', 'text-gray-700', 'scale-100');
            }
        });
    });

    function generateSingleArticle() {
        const title = document.getElementById('articleTitle').value.trim();
        const model = document.querySelector('#singleArticleModal .ai-type-button.active').id === 'singleGptButton' ? 'gpt' : 'perplexity';
        
        if (!title) {
            alert('Please enter an article title');
            return;
        }

        // Show loading state
        document.getElementById('singleArticleLoading').classList.remove('hidden');
        document.getElementById('generateSingleArticleBtn').disabled = true;

        // Prepare data
        const data = {
            title: title,
            model: model,
            _token: '{{ csrf_token() }}'
        };

        // Make API call
        fetch(singleArticleRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Create topic object for the single article
                const topic = {
                    title: title,
                    subtitles: []
                };

                // Redirect to create page with the generated content
                const encodedTopic = encodeURIComponent(JSON.stringify(topic));
                const encodedModel = encodeURIComponent(model);
                const url = `${createRoute}?topic=${encodedTopic}&model=${encodedModel}&refresh=true`;
                
                // Store the generated content in sessionStorage for the create page
                sessionStorage.setItem('singleArticleContent', data.content);
                
                window.location.href = url;
            } else {
                alert('Error generating article: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating article. Please try again.');
        })
        .finally(() => {
            document.getElementById('singleArticleLoading').classList.add('hidden');
            document.getElementById('generateSingleArticleBtn').disabled = false;
        });
    }

    // Close modal when clicking outside
    document.getElementById('singleArticleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSingleArticleModal();
        }
    });

    // Handle Enter key in title input
    document.getElementById('articleTitle').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            generateSingleArticle();
        }
    });
</script>

<script src="{{ asset('js/blog/blog.js') }}"></script>

<style>
    .ai-type-button.active {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4) !important;
    }
    
    .ai-type-button.active:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        transform: translateY(-1px) !important;
    }
    
    .ai-type-button:not(.active) {
        background-color: white !important;
        color: #374151 !important;
    }
    
    .ai-type-button:not(.active):hover {
        background-color: #f9fafb !important;
        transform: translateY(-1px) !important;
    }
    
    {{-- Single Article Modal Styles --}}
    #singleArticleModal .ai-type-button.active {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4) !important;
    }
    
    #singleArticleModal .ai-type-button.active:hover {
        background: linear-gradient(135deg, #047857 0%, #065f46 100%) !important;
        transform: translateY(-1px) !important;
    }
    
    #singleArticleModal .ai-type-button:not(.active) {
        background-color: white !important;
        color: #374151 !important;
    }
    
    #singleArticleModal .ai-type-button:not(.active):hover {
        background-color: #f9fafb !important;
        transform: translateY(-1px) !important;
    }
    
    {{-- Animaciones personalizadas --}}
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
