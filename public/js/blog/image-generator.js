function setupImageGeneration() {
    const generateImageBtn = document.getElementById('generateImageBtn');
    const imageForm = document.getElementById('imageForm');
    const generatedImageContainer = document.getElementById('generatedImageContainer');
    const downloadBtn = document.getElementById('downloadBtn');
    const setFeaturedBtn = document.getElementById('setFeaturedBtn');

    generateImageBtn.addEventListener('click', function() {
        if (!imageForm.checkValidity()) {
            showAlert('warning', 'Please fill out all required fields.');
            return;
        }

        const formData = new FormData(imageForm);
        const payload = {
            prompt: formData.get('imgprompt'),
            ai_type: formData.get('ai_type') || 'sd3',
            output_format: formData.get('output_format'),
            aspect_ratio: formData.get('image_ratio'),
            selectionType: 'single'
        };

        showSpinner('imageSpinner');
        generateImageBtn.disabled = true;

        fetch(imageGeneratorRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            })
            .then(response => response.ok ? response.json() : Promise.reject('Network error'))
            .then(data => {
                if (data.success && data.data.success) {
                    generatedImageContainer.innerHTML =
                        `<img src="${data.data.image_url}" alt="Generated Image" class="w-full h-auto rounded-lg">`;

                    imageUrl = data.data.image_url;
                    if (downloadBtn && setFeaturedBtn) {
                        downloadBtn.disabled = false;
                        downloadBtn.onclick = () => window.location.href = data.data.image_url;
                        setFeaturedBtn.onclick = () => showAlert('success', 'Image set as featured!');
                    }
                    showAlert('success', 'Image generated successfully!');
                } else {
                    showAlert('error', 'Error generating image: ' + (data.data.message ||
                        'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred while generating the image. Please try again.');
            })
            .finally(() => {
                hideSpinner('imageSpinner');
                generateImageBtn.disabled = false;
            });
    });
}