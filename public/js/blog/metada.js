function setupMetadataGeneration() {
    const generateMetaTitle = document.getElementById('generateMetaTitle');
    const generateMetaDescription = document.getElementById('generateMetaDescription');
    const generateAllMeta = document.getElementById('generateAllMeta');
    
    // Setup character counters
    setupCharacterCounter('meta_title', 'titleCharCount', 60);
    setupCharacterCounter('meta_description', 'descriptionCharCount', 170);

    function setupCharacterCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        if (input && counter) {
            input.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = length;
                
                // Change color based on length
                if (length > maxLength * 0.9) {
                    counter.classList.add('text-red-400');
                    counter.classList.remove('text-yellow-400', 'text-slate-400');
                } else if (length > maxLength * 0.7) {
                    counter.classList.add('text-yellow-400');
                    counter.classList.remove('text-red-400', 'text-slate-400');
                } else {
                    counter.classList.add('text-slate-400');
                    counter.classList.remove('text-red-400', 'text-yellow-400');
                }
            });
        }
    }

    function showGeneratingLoader(buttonId, spinnerId, iconId, textId, originalText = 'Generate') {
        const button = document.getElementById(buttonId);
        const spinner = document.getElementById(spinnerId);
        const icon = document.getElementById(iconId);
        const text = document.getElementById(textId);
        
        if (button) button.disabled = true;
        if (spinner) spinner.classList.remove('hidden');
        if (icon) icon.classList.add('hidden');
        if (text) text.textContent = 'Generating...';
    }

    function hideGeneratingLoader(buttonId, spinnerId, iconId, textId, originalText = 'Generate') {
        const button = document.getElementById(buttonId);
        const spinner = document.getElementById(spinnerId);
        const icon = document.getElementById(iconId);
        const text = document.getElementById(textId);
        
        if (button) button.disabled = false;
        if (spinner) spinner.classList.add('hidden');
        if (icon) icon.classList.remove('hidden');
        if (text) text.textContent = originalText;
    }

    function generateMetaContent(inputId, endpoint, spinnerId, contentTitle, contentDescription = '') {
        const inputSpinner = document.getElementById(spinnerId);
        const buttonSpinnerId = inputId === 'meta_title' ? 'titleGenerateSpinner' : 
                                inputId === 'meta_description' ? 'descriptionGenerateSpinner' : 'extraBlockGenerateSpinner';
        const iconId = inputId === 'meta_title' ? 'titleGenerateIcon' : 
                      inputId === 'meta_description' ? 'descriptionGenerateIcon' : 'extraBlockGenerateIcon';
        const textId = inputId === 'meta_title' ? 'titleGenerateText' : 
                      inputId === 'meta_description' ? 'descriptionGenerateText' : 'extraBlockGenerateText';
        const buttonId = inputId === 'meta_title' ? 'generateMetaTitle' : 
                         inputId === 'meta_description' ? 'generateMetaDescription' : 'generateExtraBlock';

        // Show both spinners
        if (inputSpinner) inputSpinner.classList.remove('hidden');
        showGeneratingLoader(buttonId, buttonSpinnerId, iconId, textId);

        const bodyContent = inputId === 'meta_title' ? {
            prompt: `Generate a concise SEO-friendly meta title for an article titled "${contentTitle}" with a focus on ${contentDescription || 'group transportation in Manhattan'}`
        } : {
            prompt: contentTitle,
            type: 'meta_description'
        };

        fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify(bodyContent)
            })
            .then(response => response.json())
            .then(data => {
                // Hide both spinners
                if (inputSpinner) inputSpinner.classList.add('hidden');
                hideGeneratingLoader(buttonId, buttonSpinnerId, iconId, textId);
                
                if (data.success && data.content) {
                    let content = data.content;
                    if (typeof content === 'string' && content.startsWith('"') && content.endsWith('"')) {
                        content = content.substring(1, content.length - 1);
                    }
                    const input = document.getElementById(inputId);
                    input.value = content;
                    
                    // Trigger character counter update
                    input.dispatchEvent(new Event('input'));
                    
                    showAlert('success',
                        `${inputId === 'meta_title' ? 'Meta title' : 'Meta description'} generated successfully!`
                    );
                } else {
                    showAlert('error', 'Error generating content');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Hide both spinners
                if (inputSpinner) inputSpinner.classList.add('hidden');
                hideGeneratingLoader(buttonId, buttonSpinnerId, iconId, textId);
                showAlert('error', 'An error occurred while generating content');
            });
    }

    generateMetaTitle.addEventListener('click', () => {
        const contentTitle = document.getElementById('title').value;
        const contentDescription = editorInstance.getData();
        generateMetaContent('meta_title', metaDataRoute, 'titleSpinner', contentTitle, contentDescription);
    });

    generateMetaDescription.addEventListener('click', () => {
        const contentTitle = document.getElementById('title').value;
        generateMetaContent('meta_description', metaDescripcionRoute, 'descriptionSpinner', contentTitle);
    });

    generateAllMeta.addEventListener('click', () => {
        const contentTitle = document.getElementById('title').value;
        const contentDescription = editorInstance.getData();
        
        // Disable the generate all button during generation
        const button = document.getElementById('generateAllMeta');
        button.disabled = true;
        button.innerHTML = `
            <div class="w-4 h-4 border-2 border-purple-400 border-t-transparent rounded-full animate-spin mr-2"></div>
            Generating All...
        `;
        
        generateMetaContent('meta_title', metaDataRoute, 'titleSpinner', contentTitle, contentDescription);
        setTimeout(() => {
            generateMetaContent('meta_description', imageGeneratorRoute, 'descriptionSpinner', contentTitle);
            
            // Reset button after both generations
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Generate All SEO
                `;
            }, 3000);
        }, 500);
    });
}