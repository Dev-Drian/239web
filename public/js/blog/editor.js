function initializeEditor() {
    // Obtener el contenido inicial del textarea antes de que CKEditor lo reemplace
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
            
            // Establecer el contenido inicial si existe
            if (initialContent) {
                editor.setData(initialContent);
                console.log('Initial content set in editor:', initialContent);
                console.log('Editor data after setting:', editor.getData());
            } else {
                console.log('No initial content found');
            }
            
            // Agregar estilos CSS para mejorar la presentación del contenido HTML en el editor
            const editorStyles = `
                .ck-editor__editable h1, .ck-editor__editable h2, .ck-editor__editable h3, 
                .ck-editor__editable h4, .ck-editor__editable h5, .ck-editor__editable h6 {
                    color: #f1f5f9 !important;
                    font-weight: 600;
                    margin-top: 1em;
                    margin-bottom: 0.5em;
                }
                .ck-editor__editable h1 { font-size: 2rem; }
                .ck-editor__editable h2 { font-size: 1.5rem; }
                .ck-editor__editable h3 { font-size: 1.25rem; }
                .ck-editor__editable p {
                    margin-bottom: 1em;
                    line-height: 1.6;
                    color: #e2e8f0 !important;
                }
                .ck-editor__editable a {
                    color: #818cf8 !important;
                    text-decoration: underline;
                }
                .ck-editor__editable a:hover {
                    color: #a5b4fc !important;
                }
                .ck-editor__editable ul, .ck-editor__editable ol {
                    margin-bottom: 1em;
                    padding-left: 1.5em;
                    color: #e0e7ef !important;
                }
                .ck-editor__editable li {
                    margin-bottom: 0.5em;
                    color: #e0e7ef !important;
                }
                .ck-editor__editable blockquote {
                    border-left: 4px solid #6366f1 !important;
                    padding-left: 1em;
                    margin: 1em 0;
                    font-style: italic;
                    color: #c7d2fe !important;
                    background: rgba(99, 102, 241, 0.1) !important;
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

        // Generate a dynamic and varied prompt
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
    // Array of different content types that can be generated
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

    // Randomly select a content type
    const selectedType = contentTypes[Math.floor(Math.random() * contentTypes.length)];
    
    // Randomly select a prompt from the selected type
    const selectedPrompt = selectedType.prompts[Math.floor(Math.random() * selectedType.prompts.length)];
    
    // Add additional variations based on existing content
    const contentKeywords = extractKeywords(content);
    let finalPrompt = selectedPrompt;
    
    // If the content has specific keywords, personalize the prompt
    if (contentKeywords.length > 0) {
        const keyword = contentKeywords[Math.floor(Math.random() * contentKeywords.length)];
        finalPrompt += ` Focus especially on aspects related to "${keyword}".`;
    }
    
    return finalPrompt;
}

// Function to extract keywords from content
function extractKeywords(content) {
    // Common words that indicate the content theme
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

    // Handle click on preview button
    generatePreviewBtn.addEventListener('click', function() {
        if (!editorInstance) {
            showAlert('error', 'Editor is not ready. Please try again.');
            return;
        }

        const title = document.getElementById('title').value;
        const content = editorInstance.getData();
        const imageUrl = document.getElementById('generatedImageContainer')?.querySelector('img')?.src;

        if (!title || !content) {
            showAlert('warning',
                'Please complete the title and blog content before generating a preview.');
            return;
        }

        // Build preview content with dark theme styles
        const previewHTML = `
        <div class="bg-slate-800 p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-white">${title}</h1>
            ${imageUrl ? `<img src="${imageUrl}" alt="Preview Image" class="w-full h-auto mb-6 rounded-lg shadow-md">` : ''}
            <div id="previewContent">
                ${content}
            </div>
        </div>
    `;

        // Show preview in modal
        previewContent.innerHTML = previewHTML;
        previewModal.classList.remove('hidden');
        

    });

    // Event handler for close button
    closePreviewModal.addEventListener('click', function() {
        previewModal.classList.add('hidden');
    });

    // Close modal when clicking outside content
    previewModal.addEventListener('click', function(event) {
        if (event.target === previewModal) {
            previewModal.classList.add('hidden');
        }
    });
}