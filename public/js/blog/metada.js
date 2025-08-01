function setupMetadataGeneration() {
    const generateMetaTitle = document.getElementById('generateMetaTitle');
    const generateMetaDescription = document.getElementById('generateMetaDescription');
    const generateAllMeta = document.getElementById('generateAllMeta');

    function generateMetaContent(inputId, endpoint, spinnerId, contentTitle, contentDescription = '') {
        showSpinner(spinnerId);

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
                hideSpinner(spinnerId);
                if (data.success && data.content) {
                    let content = data.content;
                    if (typeof content === 'string' && content.startsWith('"') && content.endsWith('"')) {
                        content = content.substring(1, content.length - 1);
                    }
                    document.getElementById(inputId).value = content;
                    showAlert('success',
                        `${inputId === 'meta_title' ? 'Meta title' : 'Meta description'} generated successfully!`
                    );
                } else {
                    showAlert('error', 'Error generating content');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideSpinner(spinnerId);
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
        generateMetaContent('meta_title', metaDataRoute, 'titleSpinner', contentTitle, contentDescription);
        setTimeout(() => {
            generateMetaContent('meta_description', imageGeneratorRoute, 'descriptionSpinner',
                contentTitle);
        }, 500); // Pequeño retraso para evitar condiciones de carrera
    });
}