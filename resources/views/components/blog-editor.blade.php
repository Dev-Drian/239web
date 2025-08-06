<script>
    function initializeEditor() {
        const textarea = document.querySelector('#editor');
        const initialContent = textarea ? textarea.value.trim() : '';
        
        console.log('Initial content from textarea:', initialContent);
        console.log('Textarea element:', textarea);
        
        return ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', 'undo', 'redo'
                    ]
                },
                placeholder: 'Write your blog content here...',
            })
            .then(editor => {
                editorInstance = editor;
                console.log('CKEditor initialized successfully.');
                
                if (initialContent) {
                    editor.setData(initialContent);
                    console.log('Initial content set in editor:', initialContent);
                    console.log('Editor data after setting:', editor.getData());
                } else {
                    console.log('No initial content found');
                }
                
                // Dark theme styles for CKEditor
                const editorStyles = `
                    /* CKEditor Dark Theme Styles */
                    .ck.ck-editor {
                        background: rgba(15, 23, 42, 0.8) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        border-radius: 12px !important;
                        backdrop-filter: blur(12px) !important;
                    }
                    
                    .ck.ck-editor__main > .ck-editor__editable {
                        background: rgba(30, 41, 59, 0.6) !important;
                        color: #f1f5f9 !important;
                        border: none !important;
                        border-radius: 0 0 12px 12px !important;
                        min-height: 400px !important;
                        padding: 24px !important;
                    }
                    
                    .ck.ck-toolbar {
                        background: rgba(15, 23, 42, 0.9) !important;
                        border: none !important;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
                        border-radius: 12px 12px 0 0 !important;
                        padding: 12px !important;
                    }
                    
                    .ck.ck-button {
                        background: transparent !important;
                        color: #cbd5e1 !important;
                        border: none !important;
                        border-radius: 8px !important;
                        transition: all 0.2s ease !important;
                    }
                    
                    .ck.ck-button:hover {
                        background: rgba(99, 102, 241, 0.2) !important;
                        color: #a5b4fc !important;
                    }
                    
                    .ck.ck-button.ck-on {
                        background: rgba(99, 102, 241, 0.3) !important;
                        color: #c7d2fe !important;
                    }
                    
                    .ck.ck-dropdown__panel {
                        background: rgba(15, 23, 42, 0.95) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        border-radius: 12px !important;
                        backdrop-filter: blur(12px) !important;
                    }
                    
                    .ck.ck-list__item {
                        color: #f1f5f9 !important;
                    }
                    
                    .ck.ck-list__item:hover {
                        background: rgba(99, 102, 241, 0.2) !important;
                    }
                    
                    .ck-content h1, .ck-content h2, .ck-content h3, .ck-content h4, .ck-content h5, .ck-content h6 {
                        color: #f1f5f9 !important;
                        font-weight: 600;
                        margin-top: 1.5em;
                        margin-bottom: 0.75em;
                    }
                    
                    .ck-content h1 { 
                        font-size: 2rem; 
                        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
                        padding-bottom: 0.5em;
                    }
                    
                    .ck-content h2 { 
                        font-size: 1.5rem; 
                        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                        padding-bottom: 0.25em;
                    }
                    
                    .ck-content h3 { font-size: 1.25rem; }
                    
                    .ck-content p {
                        margin-bottom: 1em;
                        line-height: 1.75;
                        color: #e2e8f0 !important;
                    }
                    
                    .ck-content a {
                        color: #60a5fa !important;
                        text-decoration: underline;
                    }
                    
                    .ck-content a:hover {
                        color: #93c5fd !important;
                    }
                    
                    .ck-content ul, .ck-content ol {
                        margin-bottom: 1em;
                        padding-left: 1.5em;
                        color: #e2e8f0 !important;
                    }
                    
                    .ck-content li {
                        margin-bottom: 0.5em;
                        color: #e2e8f0 !important;
                    }
                    
                    .ck-content blockquote {
                        border-left: 4px solid rgba(99, 102, 241, 0.5);
                        padding-left: 1em;
                        margin: 1.5em 0;
                        font-style: italic;
                        color: #94a3b8 !important;
                        background: rgba(99, 102, 241, 0.1);
                        padding: 1em;
                        border-radius: 8px;
                    }
                    
                    .ck-content table {
                        border-collapse: collapse;
                        margin: 1em 0;
                        background: rgba(30, 41, 59, 0.5);
                        border-radius: 8px;
                        overflow: hidden;
                    }
                    
                    .ck-content table td, .ck-content table th {
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        padding: 0.5em;
                        color: #e2e8f0 !important;
                    }
                    
                    .ck-content table th {
                        background: rgba(99, 102, 241, 0.2);
                        font-weight: 600;
                    }
                    
                    /* Scrollbar styling */
                    .ck-editor__editable::-webkit-scrollbar {
                        width: 8px;
                    }
                    
                    .ck-editor__editable::-webkit-scrollbar-track {
                        background: rgba(30, 41, 59, 0.3);
                        border-radius: 4px;
                    }
                    
                    .ck-editor__editable::-webkit-scrollbar-thumb {
                        background: rgba(99, 102, 241, 0.5);
                        border-radius: 4px;
                    }
                    
                    .ck-editor__editable::-webkit-scrollbar-thumb:hover {
                        background: rgba(99, 102, 241, 0.7);
                    }
                    
                    /* Focus styles */
                    .ck.ck-editor__editable:focus {
                        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.3) !important;
                        outline: none !important;
                    }
                    
                    /* Placeholder styling */
                    .ck.ck-editor__editable.ck-placeholder::before {
                        color: #64748b !important;
                    }
                `;
                
                const styleElement = document.createElement('style');
                styleElement.innerHTML = editorStyles;
                document.head.appendChild(styleElement);
                
                return editor;
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
                showAlert('error', 'Error initializing editor. Please refresh the page.');
            });
    }
    
    // Additional blog content generation
    function setupExtraBlockGeneration() {
        document.getElementById('generateExtraBlock').addEventListener('click', function() {
            if (!editorInstance) {
                showAlert('error', 'Editor not initialized. Please refresh the page.');
                return;
            }
    
            const content = editorInstance.getData();
            showSpinner('extraBlockSpinner');
    
            const dynamicPrompt = generateDynamicPrompt(content, city);
    
            fetch(extraBlogRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    prompt: dynamicPrompt
                })
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner('extraBlockSpinner');
                if (data.content) {
                    console.log(data.content);
                    const currentContent = editorInstance.getData();
                    editorInstance.setData(currentContent + "\n\n" + data.content);
                    showAlert('success', 'Additional content generated successfully!');
                } else {
                    showAlert('error', 'Error generating extra content');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideSpinner('extraBlockSpinner');
                showAlert('error', 'An error occurred while generating extra content');
            });
        });
    }
    
    // Function to generate dynamic and varied prompts
    function generateDynamicPrompt(content, city) {
        const contentTypes = [
            {
                type: 'landmark_visit',
                prompts: [
                    `Based on the blog content: "${content}", create a section about how our transportation service can take you to visit 2-3 iconic places in ${city}. Include practical information such as visiting hours, tips for the best experience, and links to the official Google Business profiles of these places.`,
                    `Generate additional content related to: "${content}". Focus on unique tourist experiences in ${city} that can be enjoyed with our transportation service. Mention 1-2 specific places with details about what makes them special and links to their official websites.`,
                    `Create a complementary section to the content: "${content}". Describe how our service facilitates access to historical and cultural places in ${city}. Include 2-3 highlighted destinations with information about their historical importance and links to official resources.`
                ]
            },
            {
                type: 'local_experience',
                prompts: [
                    `Based on: "${content}", generate content about authentic local experiences in ${city} that can be enjoyed with our service. Include 1-2 lesser-known but fascinating places, with local tips and links to their official profiles.`,
                    `Create additional content related to: "${content}". Focus on local gastronomy and places of cultural interest in ${city}. Mention 2-3 iconic restaurants or cafes with links to their Google Business profiles.`,
                    `Generate a section about: "${content}". Describe recreational and entertainment activities in ${city} that can be performed with our service. Include 1-2 specific places with information about available activities and official links.`
                ]
            },
            {
                type: 'practical_info',
                prompts: [
                    `Based on the content: "${content}", create a section with practical information about how to plan visits to places of interest in ${city} using our service. Include 2-3 popular destinations with schedules, approximate prices and links to their official websites.`,
                    `Generate complementary content about: "${content}". Focus on travel tips and recommendations for visiting iconic places in ${city}. Mention 1-2 specific places with information about the best time to visit them and links to official resources.`,
                    `Create a section about: "${content}". Describe transportation options and accessibility for visiting tourist places in ${city}. Include 2-3 destinations with information about parking, public transportation and links to their official profiles.`
                ]
            }
        ];
    
        const selectedType = contentTypes[Math.floor(Math.random() * contentTypes.length)];
        const selectedPrompt = selectedType.prompts[Math.floor(Math.random() * selectedType.prompts.length)];
        
        const contentKeywords = extractKeywords(content);
        let finalPrompt = selectedPrompt;
        
        if (contentKeywords.length > 0) {
            const keyword = contentKeywords[Math.floor(Math.random() * contentKeywords.length)];
            finalPrompt += ` Focus especially on aspects related to "${keyword}".`;
        }
        
        return finalPrompt;
    }
    
    // Function to extract keywords from content
    function extractKeywords(content) {
        const commonKeywords = [
            'tourism', 'travel', 'culture', 'history', 'gastronomy', 'art', 'music', 
            'nature', 'adventure', 'relax', 'family', 'romantic', 'business',
            'events', 'festivals', 'museums', 'parks', 'beaches', 'mountains'
        ];
        
        const foundKeywords = [];
        const lowerContent = content.toLowerCase();
        
        commonKeywords.forEach(keyword => {
            if (lowerContent.includes(keyword)) {
                foundKeywords.push(keyword);
            }
        });
        
        return foundKeywords;
    }
    
    // Blog preview
    function setupBlogPreview() {
        const generatePreviewBtn = document.getElementById('generatePreviewBtn');
        const previewModal = document.getElementById('previewModal');
        const previewContent = document.getElementById('previewContent');
        const closePreviewModal = document.getElementById('closePreviewModal');
    
        generatePreviewBtn.addEventListener('click', function() {
            if (!editorInstance) {
                showAlert('error', 'Editor is not ready. Please try again.');
                return;
            }
    
            const title = document.getElementById('title').value;
            const content = editorInstance.getData();
            const imageUrl = document.getElementById('generatedImageContainer')?.querySelector('img')?.src;
    
            if (!title || !content) {
                showAlert('warning', 'Please complete the title and blog content before generating a preview.');
                return;
            }
    
            const previewHTML = `
            <div class="glass-card p-8 rounded-2xl shadow-2xl border border-white/10">
                <h1 class="text-4xl font-bold mb-6 text-white bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">${title}</h1>
                ${imageUrl ? `<img src="${imageUrl}" alt="Preview Image" class="w-full h-auto mb-6 rounded-xl shadow-lg border border-white/10">` : ''}
                <div class="prose prose-lg max-w-none prose-invert">
                    ${content}
                </div>
            </div>
            `;
    
            previewContent.innerHTML = previewHTML;
            previewModal.classList.remove('hidden');
            
            const styleElement = document.createElement('style');
            styleElement.textContent = `
                .prose-invert h1, .prose-invert h2, .prose-invert h3, .prose-invert h4, .prose-invert h5, .prose-invert h6 {
                    color: #f1f5f9;
                    font-weight: 600;
                    margin-top: 1.5em;
                    margin-bottom: 0.75em;
                }
                .prose-invert h1 { 
                    font-size: 2.25rem; 
                    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
                    padding-bottom: 0.5em;
                }
                .prose-invert h2 { 
                    font-size: 1.875rem; 
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                    padding-bottom: 0.25em;
                }
                .prose-invert h3 { font-size: 1.5rem; }
                .prose-invert p {
                    margin-bottom: 1em;
                    line-height: 1.75;
                    color: #e2e8f0;
                }
                .prose-invert a {
                    color: #60a5fa;
                    text-decoration: underline;
                }
                .prose-invert a:hover {
                    color: #93c5fd;
                }
                .prose-invert ul, .prose-invert ol {
                    margin-bottom: 1em;
                    padding-left: 1.5em;
                    color: #e2e8f0;
                }
                .prose-invert li {
                    margin-bottom: 0.5em;
                    color: #e2e8f0;
                }
                .prose-invert blockquote {
                    border-left: 4px solid rgba(99, 102, 241, 0.5);
                    padding-left: 1em;
                    margin: 1.5em 0;
                    font-style: italic;
                    color: #94a3b8;
                    background: rgba(99, 102, 241, 0.1);
                    padding: 1em;
                    border-radius: 8px;
                }
            `;
            document.head.appendChild(styleElement);
        });
    
        closePreviewModal.addEventListener('click', function() {
            previewModal.classList.add('hidden');
        });
    
        previewModal.addEventListener('click', function(event) {
            if (event.target === previewModal) {
                previewModal.classList.add('hidden');
            }
        });
    }
    
    // Form submission handling
    function setupFormSubmission() {
        const contentForm = document.getElementById('contentForm');
        if (!contentForm) return;
    
        contentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!editorInstance) {
                showAlert('error', 'Editor not initialized. Please refresh the page.');
                return;
            }
    
            const content = editorInstance.getData();
            if (!content || content.trim() === '') {
                showAlert('warning', 'Please add some content to your blog post.');
                return;
            }
    
            const title = document.getElementById('title')?.value;
            if (!title || title.trim() === '') {
                showAlert('warning', 'Please add a title to your blog post.');
                return;
            }
    
            const formData = new FormData(contentForm);
            
            formData.append('content', content);
            
            if (window.imageUrl) {
                formData.append('generated_image', window.imageUrl);
            }
            
            formData.append('website', website);
            formData.append('post_status', 'draft');
    
            const submitBtn = contentForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="loading-spinner mr-2"></div> Creating...';
    
            fetch(createBlog, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Blog post created successfully!');
                    setTimeout(() => {
                        window.location.href = showRoute;
                    }, 1500);
                } else {
                    showAlert('error', 'Error creating blog post: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred while creating the blog post.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
    </script>
    