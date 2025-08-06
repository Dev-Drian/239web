<script>
    function setupImageGeneration() {
        console.log('🚀 Iniciando setupImageGeneration...');
        
        // Global variables for image management
        window.featuredImageUrl = null;
        window.processedImageUrl = null;
        window.imageUrl = null;
        window.isGeneratingImage = window.isGeneratingImage || false;
        window.isUploadingImage = window.isUploadingImage || false;
    
        // DOM Elements
        const elements = {
            aiTab: document.getElementById('aiTab'),
            uploadTab: document.getElementById('uploadTab'),
            aiTabContent: document.getElementById('aiTabContent'),
            uploadTabContent: document.getElementById('uploadTabContent'),
            generateImageBtn: document.getElementById('generateImageBtn'),
            uploadImageBtn: document.getElementById('uploadImageBtn'),
            resetImageBtn: document.getElementById('resetImageBtn'),
            imageFile: document.getElementById('imageFile'),
            imageUrl: document.getElementById('imageUrl'),
            dropZone: document.getElementById('dropZone'),
            filePreview: document.getElementById('filePreview'),
            previewImage: document.getElementById('previewImage'),
            fileName: document.getElementById('fileName'),
            fileSize: document.getElementById('fileSize'),
            removeFile: document.getElementById('removeFile'),
            progressBar: document.getElementById('progressBar'),
            progressFill: document.getElementById('progressFill'),
            generatedImageContainer: document.getElementById('generatedImageContainer'),
            downloadBtn: document.getElementById('downloadBtn'),
            imageForm: document.getElementById('imageForm'),
            imgPrompt: document.getElementById('imgprompt')
        };
    
        console.log('📋 Elementos encontrados:', {
            generateBtn: !!elements.generateImageBtn,
            uploadBtn: !!elements.uploadImageBtn,
            form: !!elements.imageForm,
            container: !!elements.generatedImageContainer
        });
    
        // Limpiar cualquier listener previo
        cleanupPreviousListeners();
    
        // Initialize the component
        initializeTabs();
        initializeDragAndDrop();
        initializeFileHandling();
        initializeImageGeneration();
        initializeImageUpload();
        initializeReset();
    
        function cleanupPreviousListeners() {
            console.log('🧹 Limpiando listeners previos...');
            if (elements.generateImageBtn) {
                const newBtn = elements.generateImageBtn.cloneNode(true);
                elements.generateImageBtn.parentNode.replaceChild(newBtn, elements.generateImageBtn);
                elements.generateImageBtn = document.getElementById('generateImageBtn');
            }
            if (elements.uploadImageBtn) {
                const newBtn = elements.uploadImageBtn.cloneNode(true);
                elements.uploadImageBtn.parentNode.replaceChild(newBtn, elements.uploadImageBtn);
                elements.uploadImageBtn = document.getElementById('uploadImageBtn');
            }
        }
    
        // Tab switching functionality
        function initializeTabs() {
            if (elements.aiTab && elements.uploadTab) {
                elements.aiTab.addEventListener('click', () => switchTab('ai'));
                elements.uploadTab.addEventListener('click', () => switchTab('upload'));
            }
        }
    
        function switchTab(tab) {
            if (tab === 'ai') {
                elements.aiTab?.classList.add('active', 'text-indigo-400', 'border-indigo-500');
                elements.aiTab?.classList.remove('text-slate-400', 'hover:text-slate-300', 'hover:border-white/20', 'border-transparent');
                elements.aiTabContent?.classList.remove('hidden');
                elements.uploadTab?.classList.remove('active', 'text-indigo-400', 'border-indigo-500');
                elements.uploadTab?.classList.add('text-slate-400', 'hover:text-slate-300', 'hover:border-white/20', 'border-transparent');
                elements.uploadTabContent?.classList.add('hidden');
            } else {
                elements.uploadTab?.classList.add('active', 'text-indigo-400', 'border-indigo-500');
                elements.uploadTab?.classList.remove('text-slate-400', 'hover:text-slate-300', 'hover:border-white/20', 'border-transparent');
                elements.uploadTabContent?.classList.remove('hidden');
                elements.aiTab?.classList.remove('active', 'text-indigo-400', 'border-indigo-500');
                elements.aiTab?.classList.add('text-slate-400', 'hover:text-slate-300', 'hover:border-white/20', 'border-transparent');
                elements.aiTabContent?.classList.add('hidden');
            }
        }
    
        // Drag and Drop functionality
        function initializeDragAndDrop() {
            if (!elements.dropZone) return;
    
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                elements.dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
    
            ['dragenter', 'dragover'].forEach(eventName => {
                elements.dropZone.addEventListener(eventName, highlight, false);
            });
    
            ['dragleave', 'drop'].forEach(eventName => {
                elements.dropZone.addEventListener(eventName, unhighlight, false);
            });
    
            elements.dropZone.addEventListener('drop', handleDrop, false);
            elements.dropZone.addEventListener('click', () => elements.imageFile?.click());
    
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
    
            function highlight() {
                elements.dropZone?.classList.add('border-indigo-400/50', 'bg-white/10');
                elements.dropZone?.classList.remove('border-white/20');
            }
    
            function unhighlight() {
                elements.dropZone?.classList.remove('border-indigo-400/50', 'bg-white/10');
                elements.dropZone?.classList.add('border-white/20');
            }
    
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    elements.imageFile.files = files;
                    handleFileSelect(files[0]);
                }
            }
        }
    
        // File handling
        function initializeFileHandling() {
            if (elements.imageFile) {
                elements.imageFile.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        handleFileSelect(this.files[0]);
                        if (elements.imageUrl) elements.imageUrl.value = '';
                    }
                });
            }
    
            if (elements.imageUrl) {
                elements.imageUrl.addEventListener('input', function() {
                    if (this.value.trim()) {
                        if (elements.imageFile) elements.imageFile.value = '';
                        hideFilePreview();
                    }
                });
            }
    
            if (elements.removeFile) {
                elements.removeFile.addEventListener('click', function() {
                    if (elements.imageFile) elements.imageFile.value = '';
                    hideFilePreview();
                });
            }
        }
    
        function handleFileSelect(file) {
            if (!validateFile(file)) return;
            showFilePreview(file);
        }
    
        function validateFile(file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    
            if (!allowedTypes.includes(file.type)) {
                showAlert('error', 'Please select a valid image file (JPEG, PNG, or WebP).');
                return false;
            }
    
            if (file.size > maxSize) {
                showAlert('error', 'File size must be less than 5MB.');
                return false;
            }
    
            return true;
        }
    
        function showFilePreview(file) {
            if (!elements.filePreview) return;
    
            const reader = new FileReader();
            reader.onload = function(e) {
                if (elements.previewImage) elements.previewImage.src = e.target.result;
                if (elements.fileName) elements.fileName.textContent = file.name;
                if (elements.fileSize) elements.fileSize.textContent = formatFileSize(file.size);
                elements.filePreview.classList.remove('hidden');
                
                if (elements.generatedImageContainer) {
                    elements.generatedImageContainer.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview" 
                             class="w-full h-auto rounded-lg shadow-lg border border-white/10"
                             style="display: block; max-width: 100%; height: auto;">
                    `;
                }
            };
            reader.readAsDataURL(file);
        }
    
        function hideFilePreview() {
            if (elements.filePreview) {
                elements.filePreview.classList.add('hidden');
            }
            if (elements.generatedImageContainer) {
                resetImageContainer();
            }
        }
    
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    
        // AI Image Generation
        function initializeImageGeneration() {
            console.log('🎨 Inicializando generación de imágenes...');
            if (!elements.generateImageBtn) {
                console.error('❌ Botón de generar imagen no encontrado');
                return;
            }
    
            elements.generateImageBtn.addEventListener('click', handleGenerateClick, { once: false });
            console.log('✅ Event listener añadido al botón de generar');
        }
    
        function handleGenerateClick(event) {
            console.log('🖱️ Click en generar imagen detectado');
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
    
            if (window.isGeneratingImage) {
                console.log('⚠️ Ya se está generando una imagen, ignorando click');
                return false;
            }
    
            window.isGeneratingImage = true;
            console.log('🔒 Marcado como generando');
    
            elements.generateImageBtn.disabled = true;
            elements.generateImageBtn.style.pointerEvents = 'none';
    
            const formData = new FormData(elements.imageForm);
            const imgprompt = formData.get('imgprompt') || elements.imgPrompt?.value;
            console.log('📝 Prompt obtenido:', imgprompt);
    
            if (!imgprompt || imgprompt.trim().length < 5) {
                showAlert('warning', 'Please enter a detailed image prompt (at least 5 characters).');
                resetGenerationState();
                return false;
            }
    
            generateImageRequest(imgprompt, formData);
            return false;
        }
    
        function generateImageRequest(prompt, formData) {
            console.log('🚀 Iniciando petición de generación...');
    
            const requestData = new FormData();
            requestData.append('prompt', prompt.trim());
            requestData.append('ai_type', formData.get('ai_type') || 'sd3');
            requestData.append('output_format', formData.get('output_format') || 'jpeg');
            requestData.append('aspect_ratio', formData.get('image_ratio') || '16:9');
    
            if (typeof imageGeneratorRoute === 'undefined') {
                console.error('❌ imageGeneratorRoute no está definida');
                showAlert('error', 'Image generation route not configured');
                resetGenerationState();
                return;
            }
    
            console.log('🌐 Enviando a:', imageGeneratorRoute);
    
            setLoadingState('generate', true);
            showProgress(0);
    
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 8;
                if (progress > 85) progress = 85;
                showProgress(progress);
            }, 1000);
    
            fetch(imageGeneratorRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: requestData,
            })
            .then(response => {
                console.log('📥 Respuesta recibida, status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('📊 Datos de respuesta:', data);
                clearInterval(progressInterval);
                showProgress(100);
                setTimeout(() => {
                    hideProgress();
                    handleImageGenerationResponse(data);
                }, 500);
            })
            .catch(error => {
                console.error('❌ Error en generación:', error);
                clearInterval(progressInterval);
                hideProgress();
                showAlert('error', `Error generating image: ${error.message}`);
            })
            .finally(() => {
                console.log('🏁 Finalizando generación...');
                resetGenerationState();
            });
        }
    
        function handleImageGenerationResponse(data) {
            console.log('🎯 Procesando respuesta de imagen:', data);
            
            if (!data.success) {
                console.error('❌ Respuesta indica fallo:', data.message);
                showAlert('error', 'Error generating image: ' + (data.message || 'Unknown error'));
                return;
            }
    
            if (!data.data || !data.data.image_url) {
                console.error('❌ Estructura de respuesta inválida:', data);
                showAlert('error', 'Invalid response structure from server');
                return;
            }
    
            const imageUrl = data.data.image_url;
            console.log('🖼️ URL de imagen recibida:', imageUrl);
    
            if (!imageUrl || (!imageUrl.startsWith('http://') && !imageUrl.startsWith('https://') && !imageUrl.startsWith('data:'))) {
                console.error('❌ URL de imagen inválida:', imageUrl);
                showAlert('error', 'Invalid image URL received from server');
                return;
            }
    
            testImageLoad(imageUrl)
                .then(() => {
                    console.log('✅ Imagen cargada correctamente');
                    handleImageSuccess(imageUrl, 'generated');
                })
                .catch(error => {
                    console.error('❌ Error cargando imagen:', error);
                    showAlert('error', 'Generated image could not be loaded. Please try again.');
                });
        }
    
        function testImageLoad(url) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = function() {
                    console.log('✅ Imagen test cargada:', {
                        width: this.naturalWidth,
                        height: this.naturalHeight,
                        url: url.substring(0, 100) + '...'
                    });
                    resolve();
                };
                img.onerror = function() {
                    console.error('❌ Error cargando imagen test:', url);
                    reject(new Error('Image failed to load'));
                };
                img.crossOrigin = "anonymous";
                img.src = url;
                setTimeout(() => {
                    reject(new Error('Image load timeout'));
                }, 10000);
            });
        }
    
        function resetGenerationState() {
            console.log('🔓 Reseteando estado de generación...');
            window.isGeneratingImage = false;
            if (elements.generateImageBtn) {
                elements.generateImageBtn.disabled = false;
                elements.generateImageBtn.style.pointerEvents = 'auto';
            }
            setLoadingState('generate', false);
        }
    
        // Image Upload
        function initializeImageUpload() {
            if (!elements.uploadImageBtn) return;
    
            elements.uploadImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
    
                if (window.isUploadingImage) {
                    console.log('Ya se está subiendo una imagen...');
                    return;
                }
    
                if (window.featuredImageUrl) {
                    showAlert('warning', 'An image has already been processed. Please reset the image first to upload a new one.');
                    return;
                }
    
                const file = elements.imageFile?.files[0];
                const url = elements.imageUrl?.value.trim();
    
                if (!file && !url) {
                    showAlert('warning', 'Please select a file or enter an image URL.');
                    return;
                }
    
                if (file && url) {
                    showAlert('warning', 'Please choose either file upload OR URL, not both.');
                    return;
                }
    
                uploadImage(file, url);
            });
        }
    
        function uploadImage(file, url) {
            window.isUploadingImage = true;
            const formData = new FormData();
    
            if (file) {
                formData.append('uploaded_image', file);
            }
            if (url) {
                formData.append('image_url', url);
            }
    
            setLoadingState('upload', true);
            showProgress(0);
    
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 80) progress = 80;
                showProgress(progress);
            }, 400);
    
            fetch(uploadImageRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                clearInterval(progressInterval);
                showProgress(100);
                setTimeout(() => {
                    hideProgress();
                    if (data.success && data.data && data.data.image_url) {
                        const imageUrl = data.data.image_url;
                        if (imageUrl && imageUrl.startsWith('http')) {
                            handleImageSuccess(imageUrl, 'uploaded');
                            setUploadSuccess();
                        } else {
                            showAlert('error', 'Invalid image URL received from server');
                        }
                    } else {
                        showAlert('error', 'Error processing image: ' + (data.message || 'Invalid response from server'));
                    }
                }, 500);
            })
            .catch(error => {
                clearInterval(progressInterval);
                hideProgress();
                showAlert('error', 'An error occurred while uploading the image: ' + error.message);
            })
            .finally(() => {
                setLoadingState('upload', false);
                window.isUploadingImage = false;
            });
        }
    
        // Reset functionality
        function initializeReset() {
            if (!elements.resetImageBtn) return;
    
            elements.resetImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                resetImage();
            });
        }
    
        function resetImage() {
            if (window.processedImageUrl) {
                fetch(deleteImageRoute, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        image_url: window.processedImageUrl
                    }),
                })
                .catch(error => {
                    console.error('Error deleting image:', error);
                });
            }
    
            // Clear all variables
            window.featuredImageUrl = null;
            window.processedImageUrl = null;
            window.imageUrl = null;
            window.isGeneratingImage = false;
            window.isUploadingImage = false;
    
            // Reset UI
            resetImageContainer();
            resetUploadForm();
            hideFilePreview();
            if (elements.resetImageBtn) {
                elements.resetImageBtn.classList.add('hidden');
            }
    
            showAlert('info', 'Image reset. You can now upload a new image.');
        }
    
        // Helper functions
        function handleImageSuccess(imageUrl, type) {
            console.log('🎉 Imagen exitosa:', imageUrl, type);
            window.featuredImageUrl = imageUrl;
            window.processedImageUrl = imageUrl;
            window.imageUrl = imageUrl;
    
            if (elements.generatedImageContainer) {
                elements.generatedImageContainer.innerHTML = `
                    <div class="relative group">
                        <img src="${imageUrl}"
                             alt="Generated Image"
                             class="w-full h-auto rounded-lg shadow-lg border border-white/10 transition-all duration-300 group-hover:shadow-xl"
                             style="display: block; max-width: 100%; height: auto;">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                    </div>
                `;
            }
    
            if (elements.downloadBtn) {
                elements.downloadBtn.disabled = false;
                elements.downloadBtn.onclick = () => window.open(imageUrl, '_blank');
            }
    
            if (elements.resetImageBtn) {
                elements.resetImageBtn.classList.remove('hidden');
            }
    
            showAlert('success', `Image ${type} successfully! Ready to create blog.`);
        }
    
        function setLoadingState(type, loading) {
            const btn = type === 'generate' ? elements.generateImageBtn : elements.uploadImageBtn;
            const spinner = type === 'generate' ? 'imageSpinner' : 'uploadSpinner';
            const textElement = type === 'generate' ? 'generateBtnText' : 'uploadBtnText';
    
            if (btn) {
                btn.disabled = loading;
                if (loading) {
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    const textEl = document.getElementById(textElement);
                    if (textEl) {
                        textEl.textContent = type === 'generate' ? 'Generating...' : 'Processing...';
                    }
                } else {
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    const textEl = document.getElementById(textElement);
                    if (textEl) {
                        textEl.textContent = type === 'generate' ? 'Generate Featured Image' : 'Process Image';
                    }
                }
            }
    
            showSpinner(spinner, loading);
        }
    
        function setUploadSuccess() {
            if (elements.uploadImageBtn) {
                elements.uploadImageBtn.disabled = true;
                elements.uploadImageBtn.classList.add('bg-green-600', 'hover:bg-green-600');
                elements.uploadImageBtn.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Image Ready
                `;
            }
            if (elements.imageFile) elements.imageFile.disabled = true;
            if (elements.imageUrl) elements.imageUrl.disabled = true;
        }
    
        function resetUploadForm() {
            if (elements.uploadImageBtn) {
                elements.uploadImageBtn.disabled = false;
                elements.uploadImageBtn.classList.remove('bg-green-600', 'hover:bg-green-600');
                elements.uploadImageBtn.innerHTML = `
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span id="uploadBtnText">Process Image</span>
                `;
            }
            if (elements.imageFile) {
                elements.imageFile.disabled = false;
                elements.imageFile.value = '';
            }
            if (elements.imageUrl) {
                elements.imageUrl.disabled = false;
                elements.imageUrl.value = '';
            }
        }
    
        function resetImageContainer() {
            if (elements.generatedImageContainer) {
                elements.generatedImageContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <svg class="h-16 w-16 mb-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-center font-medium text-slate-300">No image generated yet</p>
                        <p class="text-sm text-slate-500 mt-1">Generate with AI or upload your own</p>
                    </div>
                `;
            }
        }
    
        function showProgress(percent) {
            if (elements.progressBar && elements.progressFill) {
                elements.progressBar.classList.remove('hidden');
                elements.progressFill.style.width = percent + '%';
            }
        }
    
        function hideProgress() {
            if (elements.progressBar) {
                elements.progressBar.classList.add('hidden');
            }
        }
    
        function showSpinner(spinnerId, show = true) {
            const spinner = document.getElementById(spinnerId);
            if (spinner) {
                if (show) {
                    spinner.classList.remove('hidden');
                } else {
                    spinner.classList.add('hidden');
                }
            }
        }
    
        function getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                         document.querySelector('input[name="_token"]')?.value;
            if (!token) {
                console.error('CSRF token not found');
            }
            return token;
        }
    
        // Initialize on load
        resetImageContainer();
        console.log('✅ setupImageGeneration completado');
    }
    
    // Limpiar cualquier instancia previa
    if (window.setupImageGenerationInitialized) {
        console.log('🔄 Reinicializando setupImageGeneration...');
    }
    window.setupImageGenerationInitialized = true;
    
    // Inicializar una sola vez
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📄 DOM cargado, inicializando...');
        setTimeout(setupImageGeneration, 200);
    });
    
    // También inicializar si el DOM ya está cargado
    if (document.readyState !== 'loading') {
        console.log('📄 DOM ya cargado, inicializando inmediatamente...');
        setTimeout(setupImageGeneration, 100);
    }
    </script>
    