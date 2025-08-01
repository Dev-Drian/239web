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
                .ck-content h1, .ck-content h2, .ck-content h3, .ck-content h4, .ck-content h5, .ck-content h6 {
                    color: #1f2937;
                    font-weight: 600;
                    margin-top: 1em;
                    margin-bottom: 0.5em;
                }
                .ck-content h1 { font-size: 2rem; }
                .ck-content h2 { font-size: 1.5rem; }
                .ck-content h3 { font-size: 1.25rem; }
                .ck-content p {
                    margin-bottom: 1em;
                    line-height: 1.6;
                    color: #374151;
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
                    margin: 1em 0;
                    font-style: italic;
                    color: #6b7280;
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

        // Build preview content with improved styles
        const previewHTML = `
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">${title}</h1>
            ${imageUrl ? `<img src="${imageUrl}" alt="Preview Image" class="w-full h-auto mb-6 rounded-lg shadow-md">` : ''}
            <div class="prose prose-lg max-w-none">
                ${content}
            </div>
        </div>
    `;

        // Show preview in modal
        previewContent.innerHTML = previewHTML;
        previewModal.classList.remove('hidden');
        
        // Add CSS styles to improve HTML content presentation
        const styleElement = document.createElement('style');
        styleElement.textContent = `
            .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
                color: #1f2937;
                font-weight: 600;
                margin-top: 1.5em;
                margin-bottom: 0.5em;
            }
            .prose h1 { font-size: 2.25rem; }
            .prose h2 { font-size: 1.875rem; }
            .prose h3 { font-size: 1.5rem; }
            .prose p {
                margin-bottom: 1em;
                line-height: 1.75;
                color: #374151;
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
        `;
        document.head.appendChild(styleElement);
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