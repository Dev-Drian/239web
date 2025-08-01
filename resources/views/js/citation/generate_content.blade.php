<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parse the services JSON if it's a string
        if (typeof client.services === 'string') {
            try {
                client.services = JSON.parse(client.services);
            } catch (e) {
                console.error('Error parsing services JSON:', e);
                client.services = [];
            }
        }

        // Function to validate required fields before content generation
        function validateRequiredFields() {
            const validationErrors = [];
            const services = Array.isArray(client.services) ? client.services : [];
            const website = client.website;
            const city = client.city;
            
            if (services.length === 0) {
                validationErrors.push("Services");
            }
            if (!website) {
                validationErrors.push("Website");
            }
            if (!city) {
                validationErrors.push("City");
            }

            if (validationErrors.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    html: `The following information is required:<br><br>
                    <span class="font-medium text-red-600">${validationErrors.join('<br>')}</span><br><br>
                    <strong>Please update the information first:</strong>`,
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
                        window.location.href =
                            `{{ route('client.show', ['client' => $client->id]) }}?tab=services`;
                    }
                });
                return false;
            }
            return true;
        }

        // Function to extract service names from JSON
        function getServiceNames() {
            try {
                if (!client.services) return [];
                
                // If services is a string, parse it
                const services = typeof client.services === 'string' ? 
                    JSON.parse(client.services) : 
                    client.services;
                
                // Handle different JSON structures
                if (Array.isArray(services)) {
                    // Case 1: Array of strings
                    if (services.every(item => typeof item === 'string')) {
                        return services;
                    }
                    // Case 2: Array of objects with 'name' property
                    if (services.every(item => typeof item === 'object' && item.name)) {
                        return services.map(service => service.name);
                    }
                    // Case 3: Array of objects with 'title' or 'service_name'
                    return services.map(service => 
                        service.name || service.title || service.service_name || 'Service'
                    );
                } else if (typeof services === 'object' && !Array.isArray(services)) {
                    // Case 4: Object with services as properties
                    return Object.values(services).map(service => 
                        service.name || service.title || service.service_name || 'Service'
                    );
                }
                return [];
            } catch (e) {
                console.error('Error processing services:', e);
                return [];
            }
        }

        // Function to create prompts using client data
        function createPrompt(type) {
            const serviceNames = getServiceNames();
            const servicesList = serviceNames.join(', ');
            
            switch (type) {
                case 'long':
                    return `Create a detailed, professional description for ${client.website}, 
                    a business offering ${servicesList} services in ${client.city}. 
                    The description should be between 275-325 characters, SEO-optimized 
                    with natural keyword placement. Highlight key services and location.`;
                    
                case 'short':
                    return `Create a concise, engaging meta description for ${client.website}, 
                    specializing in ${servicesList} in ${client.city}. 
                    Keep it between 150-256 characters, with a clear call-to-action.`;
                    
                case 'keywords':
                    return `Generate 15-20 SEO keywords for ${client.website} 
                    that offers ${servicesList} in ${client.city}. 
                    Include location-based terms (like "${client.city} [service]"), 
                    service-specific terms, and long-tail keywords. 
                    Format as comma-separated values.`;
                    
                default:
                    return "";
            }
        }

        // Rest of the code remains the same...
        function validateContentLength(content, type) {
            if (type === 'short') {
                if (content.length > 256) {
                    content = content.substring(0, 256);
                    const lastPeriodIndex = content.lastIndexOf('.');
                    if (lastPeriodIndex !== -1) {
                        content = content.substring(0, lastPeriodIndex + 1);
                    }
                }
                if (content.length < 150) {
                    return {
                        valid: false,
                        error: "Error: Generated content is too short (minimum 150 characters required)."
                    };
                }
            } else if (type === 'long') {
                if (content.length > 325) {
                    content = content.substring(0, 325);
                    const lastPeriodIndex = content.lastIndexOf('.');
                    if (lastPeriodIndex !== -1) {
                        content = content.substring(0, lastPeriodIndex + 1);
                    }
                }
                if (content.length < 275) {
                    return {
                        valid: false,
                        error: "Error: Generated content is too short (minimum 275 characters required)."
                    };
                }
            }
            return {
                valid: true,
                content: content
            };
        }

        function generateContent(buttonId, loaderId, targetFieldId, route, promptType) {
            const button = document.getElementById(buttonId);
            const loader = document.getElementById(loaderId);
            const targetField = document.getElementById(targetFieldId);

            if (!button || !loader || !targetField) {
                console.error('Could not find required elements for:', buttonId, loaderId, targetFieldId);
                return;
            }

            button.addEventListener('click', function() {
                if (!validateRequiredFields()) {
                    return;
                }

                button.classList.add('hidden');
                loader.classList.remove('hidden');

                let prompt;
                if (promptType === 'spun') {
                    const longContent = document.getElementById('long_description')?.value;
                    if (!longContent) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please generate a long description first before creating spun content.',
                        });
                        button.classList.remove('hidden');
                        loader.classList.add('hidden');
                        return;
                    }
                    prompt = `Convert this into spintax format with multiple variations: ${longContent}`;
                } else {
                    prompt = createPrompt(promptType);
                }

                fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            prompt: prompt,
                            client_id: client.id,
                            services: client.services // Send original services data
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (!data.content) throw new Error('No content was generated');

                        const validation = validateContentLength(data.content, promptType);
                        if (!validation.valid) throw new Error(validation.error);

                        targetField.value = validation.content;
                        

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Content generated successfully!',
                            timer: 2000
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Generation Failed',
                            text: error.message || 'An error occurred. Please try again.',
                        });
                    })
                    .finally(() => {
                        loader.classList.add('hidden');
                        button.classList.remove('hidden');
                    });
            });
        }

        // Initialize all content generation buttons
        generateContent('generateKeywordsButton', 'loaderKeywords', 'keywords', 
            routeGenerateContentKeywords, 'keywords');
        generateContent('generateShortContentButton', 'loaderShortContent', 'short_description',
            routeGenerateContentShort, 'short');
        generateContent('generateLongContentButton', 'loaderLongContent', 'long_description',
            routeGenerateContentLong, 'long');
        generateContent('generateSpunContentButton', 'loaderSpunContent', 'spun_description',
            routeGenerateContentSpun, 'spun');
    });
</script>