<script>
    // Metadata generation functions - Usando funciones globales de utils
    function setupMetadataGeneration() {
        // DOM Elements con verificación
        const elements = {
            generateMetaTitle: document.getElementById('generateMetaTitle'),
            generateMetaDescription: document.getElementById('generateMetaDescription'),
            generateAllMeta: document.getElementById('generateAllMeta'),
            titleInput: document.getElementById('meta_title'),
            descriptionInput: document.getElementById('meta_description'),
            contentTitle: document.getElementById('title')
        };

        // Flags para prevenir múltiples peticiones
        let isGeneratingTitle = false;
        let isGeneratingDescription = false;

        // Verificar que los elementos existen
        if (!elements.generateMetaTitle || !elements.generateMetaDescription || !elements.generateAllMeta) {
            console.warn('Algunos elementos de metadata no fueron encontrados');
            return;
        }

        // Función principal para generar contenido meta
        function generateMetaContent(type, inputId, endpoint, spinnerId, contentTitle, contentDescription = '') {
            // Prevenir múltiples peticiones
            if (type === 'title' && isGeneratingTitle) {
                console.log('Ya se está generando el meta title...');
                return Promise.reject('Already generating title');
            }
            if (type === 'description' && isGeneratingDescription) {
                console.log('Ya se está generando la meta description...');
                return Promise.reject('Already generating description');
            }

            // Validaciones
            if (!contentTitle || contentTitle.trim() === '') {
                showAlert('warning', 'Please enter a blog title first');
                return Promise.reject('No title provided');
            }

            if (!endpoint) {
                showAlert('error', 'Endpoint not configured');
                return Promise.reject('No endpoint');
            }

            // Marcar como generando
            if (type === 'title') isGeneratingTitle = true;
            if (type === 'description') isGeneratingDescription = true;

            // Mostrar spinner usando función global
            showSpinner(spinnerId);

            // Preparar el body de la petición
            let bodyContent;
            if (type === 'title') {
                bodyContent = {
                    prompt: `Generate a concise SEO-friendly meta title (max 60 characters) for an article titled "${contentTitle.trim()}"${contentDescription ? ` with focus on: ${stripHtml(contentDescription).substring(0, 200)}` : ''}`
                };
            } else {
                bodyContent = {
                    prompt: `Generate an SEO-friendly meta description (max 160 characters) for an article titled "${contentTitle.trim()}"${contentDescription ? ` with content: ${stripHtml(contentDescription).substring(0, 300)}` : ''}`,
                    type: 'meta_description'
                };
            }

            console.log(`Generating ${type}:`, bodyContent);

            return fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(bodyContent)
                })
                .then(response => {
                    console.log(`${type} response status:`, response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(`${type} response data:`, data);
                    if (data.success && data.content) {
                        let content = data.content;

                        // Limpiar comillas si existen
                        if (typeof content === 'string') {
                            content = content.trim();
                            if (content.startsWith('"') && content.endsWith('"')) {
                                content = content.substring(1, content.length - 1);
                            }
                            if (content.startsWith("'") && content.endsWith("'")) {
                                content = content.substring(1, content.length - 1);
                            }
                        }

                        // Validar longitud
                        if (type === 'title' && content.length > 60) {
                            content = content.substring(0, 57) + '...';
                        }
                        if (type === 'description' && content.length > 160) {
                            content = content.substring(0, 157) + '...';
                        }

                        // Insertar en el campo correspondiente
                        const inputElement = document.getElementById(inputId);
                        if (inputElement) {
                            inputElement.value = content;
                            // Trigger change event para cualquier listener
                            inputElement.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                            showAlert('success',
                                `${type === 'title' ? 'Meta title' : 'Meta description'} generated successfully!`
                                );
                        } else {
                            throw new Error(`Input element ${inputId} not found`);
                        }
                    } else {
                        throw new Error(data.message || 'Invalid response format');
                    }
                })
                .catch(error => {
                    console.error(`Error generating ${type}:`, error);
                    showAlert('error',
                        `Error generating ${type === 'title' ? 'meta title' : 'meta description'}: ${error.message}`
                        );
                    throw error;
                })
                .finally(() => {
                    hideSpinner(spinnerId);
                    // Liberar flags
                    if (type === 'title') isGeneratingTitle = false;
                    if (type === 'description') isGeneratingDescription = false;
                });
        }

        // Event Listeners
        elements.generateMetaTitle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const contentTitle = elements.contentTitle?.value || '';
            const contentDescription = getEditorContent();
            generateMetaContent('title', 'meta_title', metaDataRoute, 'titleSpinner', contentTitle,
                contentDescription);
        });

        elements.generateMetaDescription.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const contentTitle = elements.contentTitle?.value || '';
            const contentDescription = getEditorContent();
            generateMetaContent('description', 'meta_description', metaDescripcionRoute, 'descriptionSpinner',
                contentTitle, contentDescription);
        });

        elements.generateAllMeta.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const contentTitle = elements.contentTitle?.value || '';
            const contentDescription = getEditorContent();

            if (!contentTitle || contentTitle.trim() === '') {
                showAlert('warning', 'Please enter a blog title first');
                return;
            }

            // Generar título primero
            generateMetaContent('title', 'meta_title', metaDataRoute, 'titleSpinner', contentTitle,
                    contentDescription)
                .then(() => {
                    // Esperar un poco y luego generar descripción
                    return new Promise(resolve => setTimeout(resolve, 1000));
                })
                .then(() => {
                    return generateMetaContent('description', 'meta_description', metaDescripcionRoute,
                        'descriptionSpinner', contentTitle, contentDescription);
                })
                .catch(error => {
                    console.error('Error in generateAllMeta:', error);
                });
        });

        // Función auxiliar para obtener contenido del editor
        function getEditorContent() {
            try {
                // Intentar diferentes formas de obtener el contenido del editor
                if (typeof editorInstance !== 'undefined' && editorInstance) {
                    return editorInstance.getData();
                }
                // Fallback: buscar en elementos comunes del editor
                const editorElement = document.querySelector('.ck-content') ||
                    document.querySelector('[data-editor]') ||
                    document.getElementById('content');
                if (editorElement) {
                    return editorElement.innerHTML || editorElement.value || '';
                }
                return '';
            } catch (error) {
                console.warn('Error getting editor content:', error);
                return '';
            }
        }

        // Función auxiliar para limpiar HTML
        function stripHtml(html) {
            if (!html) return '';
            try {
                const tmp = document.createElement('div');
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || '';
            } catch (error) {
                console.warn('Error stripping HTML:', error);
                return html.replace(/<[^>]*>/g, '');
            }
        }

        console.log('Metadata generation setup completed');
    }

    // Schedule date handling
    function setupScheduleHandling() {
        const postStatusSelect = document.getElementById('post_status');
        const scheduleDateContainer = document.getElementById('schedule_date_container');
        const scheduleDateInput = document.getElementById('schedule_date');

        if (postStatusSelect && scheduleDateContainer) {
            postStatusSelect.addEventListener('change', function() {
                if (this.value === 'schedule') {
                    scheduleDateContainer.classList.remove('hidden');
                    scheduleDateInput.required = true;

                    // Set minimum date to current date
                    const now = new Date();
                    const minDate = now.toISOString().slice(0, 16);
                    scheduleDateInput.min = minDate;

                    // Set default to 1 hour from now
                    now.setHours(now.getHours() + 1);
                    const defaultDate = now.toISOString().slice(0, 16);
                    scheduleDateInput.value = defaultDate;
                } else {
                    scheduleDateContainer.classList.add('hidden');
                    scheduleDateInput.required = false;
                    scheduleDateInput.value = '';
                }
            });
        }
    }

    // Categories handling
    function setupCategoriesHandling() {
        const categoriesSelect = document.getElementById('categoriesSelect');

        if (categoriesSelect) {
            // Initialize Select2 with dark theme
            $(categoriesSelect).select2({
                placeholder: 'Select categories...',
                allowClear: true,
                multiple: true,
                theme: 'default',
                dropdownCssClass: 'select2-dark',
                selectionCssClass: 'select2-dark'
            });

            // Apply dark theme styles
            $('.select2-container--default .select2-selection--multiple').addClass('form-select-dark');
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').addClass(
                'bg-indigo-500/20 text-indigo-300 border-indigo-500/30');
        }
    }

    // Initialize all metadata functions
    document.addEventListener('DOMContentLoaded', function() {
        setupMetadataGeneration();
        setupScheduleHandling();
        setupCategoriesHandling();
    });
</script>
