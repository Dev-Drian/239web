<script>
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

            // Mostrar spinner
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
                    // CORREGIDO: Usar metaDescripcionRoute en lugar de imageGeneratorRoute
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

        // Función auxiliar para obtener CSRF token
        function getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.querySelector('input[name="_token"]')?.value;

            if (!token) {
                console.error('CSRF token not found');
            }

            return token;
        }

        // Funciones auxiliares para spinners y alertas (si no existen globalmente)
        function showSpinner(spinnerId) {
            const spinner = document.getElementById(spinnerId);
            if (spinner) {
                spinner.classList.remove('hidden');
            }
        }

        function hideSpinner(spinnerId) {
            const spinner = document.getElementById(spinnerId);
            if (spinner) {
                spinner.classList.add('hidden');
            }
        }

        function showAlert(type, message) {
            // Si existe una función global showAlert, usarla
            if (typeof window.showAlert === 'function') {
                window.showAlert(type, message);
                return;
            }

            // Fallback simple
            console.log(`${type.toUpperCase()}: ${message}`);

            // Crear alerta visual simple si no existe
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50`;
            alertDiv.style.cssText = `
            background-color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#f59e0b'};
            color: white;
            max-width: 300px;
        `;
            alertDiv.textContent = message;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        console.log('Metadata generation setup completed');
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(setupMetadataGeneration, 100);
    });

    // También inicializar si el DOM ya está cargado
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupMetadataGeneration);
    } else {
        setupMetadataGeneration();
    }
</script>
