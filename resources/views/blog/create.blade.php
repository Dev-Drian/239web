<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-10 py-8">
        <!-- Header Component -->
        <x-blog-header />
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content Area (75%) -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Content Editor Component -->
                <x-blog-content-editor :topic="$topic" :generatedContent="$generatedContent" />
                <!-- Image Generator Component -->
                <x-blog-image-generator />
            </div>
            <!-- Sidebar (25%) -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Image Preview Component -->
                <x-blog-image-preview :client="$client" />
            </div>
        </div>
    </div>
    <!-- Modal para la vista previa -->
    <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50">
        <div class="glass-dark rounded-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6 border border-white/15">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Blog Preview</h2>
                <button id="closePreviewModal" class="text-slate-400 hover:text-white">
                    &times;
                </button>
            </div>
            <div id="previewContent" class="prose prose-invert"></div>
        </div>
    </div>
    
    @push('js')
        <script>
            const metaDataRoute = "{{ route('generate-meta-title') }}";
            const metaDescripcionRoute = "{{ route('generate-meta-description') }}";
            const extraBlogRoute = "{{ route('generate-extra-blog') }}";
            const imageGeneratorRoute = "{{ route('image.generate', $client->highlevel_id) }}";
            const website = @json($client->website).replace(/\/$/, '');
            const createBlog = "{{ route('blog.store', $client->highlevel_id) }}";
            const showRoute = "{{ route('blog.show', $client->highlevel_id) }}";
            const city = @json($client->city);
        </script>
        <style>
            /* ===== FORM ELEMENTS ===== */
            select {
                background-color: rgba(255, 255, 255, 0.05) !important;
                color: #e2e8f0 !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
            }
            
            select option {
                background-color: #1e293b !important;
                color: #e2e8f0 !important;
            }
            
            input, textarea, select {
                color: #e2e8f0 !important;
            }
            
            input::placeholder, textarea::placeholder {
                color: #94a3b8 !important;
            }
            
            /* ===== BUTTONS ===== */
            button {
                cursor: pointer !important;
                pointer-events: auto !important;
            }
            
            button:disabled {
                opacity: 0.5;
                cursor: not-allowed !important;
            }
            
            /* ===== CKEDITOR STYLING ===== */
            .ck-editor__editable {
                background: rgba(255, 255, 255, 0.05) !important;
                color: #e2e8f0 !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
            }
            
            .ck-editor__editable p {
                color: #e2e8f0 !important;
            }
            
            .ck-editor__editable h1, .ck-editor__editable h2, .ck-editor__editable h3,
            .ck-editor__editable h4, .ck-editor__editable h5, .ck-editor__editable h6 {
                color: #f1f5f9 !important;
            }
            
            .ck-editor__editable a {
                color: #818cf8 !important;
            }
            
            .ck-editor__editable blockquote {
                border-left: 4px solid #6366f1 !important;
                background: rgba(99, 102, 241, 0.1) !important;
                color: #c7d2fe !important;
            }
            
            .ck-editor__editable ul, .ck-editor__editable ol {
                color: #e0e7ef !important;
            }
            
            .ck-editor__editable li {
                color: #e0e7ef !important;
            }
            
            /* ===== PREVIEW MODAL STYLING ===== */
            #previewContent {
                background: #1e293b !important;
                color: #f1f5f9 !important;
                padding: 2rem !important;
                border-radius: 0.5rem !important;
            }
            
            #previewContent h1, #previewContent h2, #previewContent h3,
            #previewContent h4, #previewContent h5, #previewContent h6 {
                color: #fff !important;
                margin-top: 1.5rem !important;
                margin-bottom: 0.75rem !important;
            }
            
            #previewContent h1 { font-size: 2.25rem !important; }
            #previewContent h2 { font-size: 1.875rem !important; }
            #previewContent h3 { font-size: 1.5rem !important; }
            
            #previewContent p {
                color: #e2e8f0 !important;
                margin-bottom: 1rem !important;
                line-height: 1.75 !important;
            }
            
            #previewContent a {
                color: #818cf8 !important;
                text-decoration: underline !important;
            }
            
            #previewContent a:hover {
                color: #a5b4fc !important;
            }
            
            #previewContent blockquote {
                border-left: 4px solid #6366f1 !important;
                background: rgba(99, 102, 241, 0.1) !important;
                color: #c7d2fe !important;
                padding: 1rem !important;
                margin: 1.5rem 0 !important;
                border-radius: 0.375rem !important;
            }
            
            #previewContent ul, #previewContent ol {
                color: #e0e7ef !important;
                margin-bottom: 1rem !important;
                padding-left: 1.5rem !important;
            }
            
            #previewContent li {
                color: #e0e7ef !important;
                margin-bottom: 0.5rem !important;
            }
            
            /* ===== PAGES CONTAINER ===== */
            .pages-container {
                background: rgba(255, 255, 255, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                color: #e2e8f0 !important;
            }
            
            .page-link {
                color: #818cf8 !important;
            }
            
            .page-link:hover {
                color: #a5b4fc !important;
            }
        </style>

        <script src="{{ asset('js/blog/main.js') }}"></script>
        <script src="{{ asset('js/blog/util.js') }}"></script>
        <script src="{{ asset('js/blog/image-generator.js') }}"></script>
        <script src="{{ asset('js/blog/editor.js') }}"></script>
        <script src="{{ asset('js/blog/metada.js') }}"></script>




        <script>
            function setupWordPressFetching() {
                console.log('Fetching categories from:', website + '/wp-json/limo-blogs/v1/categories');
                $.ajax({
                    url: website + '/wp-json/limo-blogs/v1/categories',
                    type: 'GET',
                    timeout: 10000,
                    success: function(data) {
                        console.log('Categories response:', data);
                        const categoriesSelect = $('#categoriesSelect');
                        if (Array.isArray(data)) {
                            data.forEach(category => {
                                categoriesSelect.append(
                                    `<option value="${category.id}">${category.name}</option>`
                                );
                            });
                        } else {
                            console.error("Unexpected data format:", data);
                            showAlert('warning', 'Unexpected data format when loading categories');
                        }
                        $('#loadingSpinner').addClass('hidden');
                    },
                    error: function(error) {
                        $('#loadingSpinner').addClass('hidden');
                        showAlert('error', 'Error loading blog categories. Please try again later.');
                        console.error("Error fetching categories:", error);
                    }
                });
            }

            function setupFormSubmission() {
                document.getElementById('contentForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (!editorInstance) {
                        showAlert('error', 'Editor not initialized. Please refresh the page.');
                        return;
                    }

                    const formData = new FormData(this);
                    const payload = {
                        content: editorInstance.getData(),
                        website: website,
                        generated_image: imageUrl ?? null,
                        schedule_date: formData.get('schedule_date'),
                        post_status: formData.get('post_status'),
                        categories: formData.getAll('categories'),
                        title: formData.get('title')
                    };

                    const submitSpinner = document.getElementById('submitSpinner');
                    submitSpinner.classList.remove('hidden');

                    fetch(createBlog, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitSpinner.classList.add('hidden');
                        const status = payload.post_status;

                        let alertConfig = {
                            title: '',
                            html: '',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            showCancelButton: false
                        };

                        switch (status) {
                            case 'publish':
                                alertConfig = {
                                    title: 'Blog Published Successfully!',
                                    html: `
                                        <p class="mb-4">Your blog post is now live.</p>
                                        <a href="${data.data.permalink}" target="_blank" 
                                        class="text-blue-600 hover:text-blue-800 underline">
                                        View Blog Post
                                        </a>
                                    `,
                                    icon: 'success',
                                    confirmButtonText: 'Done',
                                    showCancelButton: true,
                                    cancelButtonText: 'View All Posts',
                                    cancelButtonColor: '#3085d6'
                                };
                                break;
                            case 'draft':
                                alertConfig = {
                                    title: 'Draft Saved',
                                    html: 'Your blog post has been saved as a draft',
                                    icon: 'info',
                                    confirmButtonText: 'OK'
                                };
                                break;
                            case 'schedule':
                                alertConfig = {
                                    title: 'Blog Scheduled',
                                    html: `Post scheduled for publication on ${payload.schedule_date}`,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                };
                                break;
                        }

                        Swal.fire(alertConfig).then((result) => {
                            if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = showRoute;
                            }
                        });
                    })
                    .catch(error => {
                        submitSpinner.classList.add('hidden');
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while creating the blog post.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    });
                });
            }
        </script>
        <script>
            const selectedPages = {!! json_encode(json_decode($client->selected_pages)) !!};

            function displaySelectedPages(pages) {
                const $pagesContainer = $('<div>')
                    .addClass('pages-container rounded-lg overflow-auto p-4')
                    .css({
                        'height': '200px',
                        'width': '100%',
                        'max-width': '100%',
                        'margin': '0 auto'
                    });

                const $orderedList = $('<ol>')
                    .addClass('list-decimal list-inside space-y-2');

                pages.forEach(function(page) {
                    const $listItem = $('<li>')
                        .addClass('text-slate-300 hover:text-indigo-300 transition-all')
                        .append(
                            $('<a>')
                            .attr('href', '#')
                            .attr('data-page-url', page.url)
                            .attr('data-page-title', page.title)
                            .addClass('text-md font-medium break-words hover:underline page-link')
                            .text(page.title)
                            .on('click', function(e) {
                                e.preventDefault();
                                applyLinkToSelectedText($(this).attr('data-page-url'), $(this).attr('data-page-title'));
                            })
                        );
                    $orderedList.append($listItem);
                });

                $pagesContainer.append($orderedList);
                $('#select-container').html($pagesContainer);

                $('#select-container').prepend(
                    $('<div>')
                    .addClass('text-sm text-slate-400 mb-2 font-medium')
                    .text('Select text in the editor and click on a page to create a link:')
                );
            }

            function applyLinkToSelectedText(url, pageTitle) {
                if (!editorInstance) {
                    showAlert('error', 'Editor not initialized. Please refresh the page.');
                    return;
                }

                const selection = editorInstance.model.document.selection;
                if (selection.isCollapsed) {
                    showAlert('warning', 'Please select some text in the editor first to create a link.');
                    return;
                }

                editorInstance.execute('link', url, {
                    linkIsExternal: true,
                    linkIsDownloadable: false
                });

                showAlert('success', `Link created to "${pageTitle}"`);
            }


        </script>

        <script>
            function setupStickyElements() {
                const handleScroll = () => {
                    const scrollTop = $(window).scrollTop();
                    const blocksSectionHeight = $('#available-blocks-section').outerHeight();
                    const windowHeight = $(window).height();

                    if (scrollTop + blocksSectionHeight + 20 > windowHeight) {
                        $('#image-preview-section').css('top', Math.max(8, windowHeight - $('#image-preview-section').outerHeight()));
                    } else {
                        $('#image-preview-section').css('top', 'calc(8rem + 170px)');
                    }
                };

                $(window).on('scroll resize', handleScroll);
                handleScroll();
            }

            // Initialize everything when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Blog create page initialized');
                console.log('Website URL:', website);
                
                // Setup WordPress fetching
                setupWordPressFetching();
                
                // Setup form submission
                setupFormSubmission();
                
                // Setup sticky elements
                setupStickyElements();
                
                // Display selected pages
                if (typeof selectedPages !== 'undefined') {
                    displaySelectedPages(selectedPages);
                }
            });
        </script>
    @endpush
    <footer class="w-full text-center py-6 text-slate-400 text-sm border-t border-white/15 mt-8">
        <p>
            This site is protected by U.S. data protection laws. <br>
            <a href="{{ route('privacy.policy') }}" class="text-indigo-400 hover:underline">Privacy Policy</a> |
            <a href="{{ route('terms.service') }}" class="text-indigo-400 hover:underline">Terms of Service</a>
        </p>
    </footer>
</x-guest-layout>
