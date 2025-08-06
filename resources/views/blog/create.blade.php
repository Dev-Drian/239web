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
    <div id="previewModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="glass-card w-full max-w-4xl max-h-[90vh] overflow-y-auto p-6 animate-scale-in">
            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                <h2 class="text-2xl font-bold text-white">Blog Preview</h2>
                <button id="closePreviewModal" class="text-slate-400 hover:text-white transition-colors duration-200 p-2 hover:bg-white/10 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="previewContent" class="prose prose-invert max-w-none"></div>
        </div>
    </div>

    @push('js')
        <script>
            // rutas para cuando escale
            const metaDataRoute = "{{ route('generate-meta-title') }}";
            const metaDescripcionRoute = "{{ route('generate-meta-description') }}";
            const extraBlogRoute = "{{ route('generate-extra-blog') }}";
            const imageGeneratorRoute = "{{ route('image.generate', $client->highlevel_id) }}";
            const website = @json($client->website).replace(/\/$/, '');
            const createBlog = "{{ route('blog.store', $client->highlevel_id) }}";
            const uploadImageRoute = "{{ route('blog.upload-image', $client->highlevel_id) }}";
            const deleteImageRoute = "{{ route('blog.delete-image', $client->highlevel_id) }}";
            const showRoute = "{{ route('blog.show', $client->highlevel_id) }}";
            const city = @json($client->primary_city ?? $client->city);
        </script>

        <!-- Dark theme styles for content -->
        <style>
            /* Dark theme editor styles */
            .ck-content {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                line-height: 1.6;
                color: #e2e8f0;
                background: transparent;
            }

            .ck-content h1, .ck-content h2, .ck-content h3, .ck-content h4, .ck-content h5, .ck-content h6 {
                color: #f1f5f9;
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

            .ck-content h3 { 
                font-size: 1.25rem; 
            }

            .ck-content p {
                margin-bottom: 1em;
                line-height: 1.75;
                color: #cbd5e1;
            }

            .ck-content a {
                color: #60a5fa;
                text-decoration: underline;
            }

            .ck-content a:hover {
                color: #93c5fd;
            }

            .ck-content ul, .ck-content ol {
                margin-bottom: 1em;
                padding-left: 1.5em;
            }

            .ck-content li {
                margin-bottom: 0.5em;
                color: #cbd5e1;
            }

            .ck-content blockquote {
                border-left: 4px solid rgba(99, 102, 241, 0.5);
                padding-left: 1em;
                margin: 1.5em 0;
                font-style: italic;
                color: #94a3b8;
                background: rgba(255, 255, 255, 0.05);
                padding: 1em;
                border-radius: 0.75rem;
                backdrop-filter: blur(8px);
            }

            /* Dark theme preview styles */
            .prose-invert {
                color: #e2e8f0;
            }

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

            .prose-invert h3 { 
                font-size: 1.5rem; 
            }

            .prose-invert p {
                margin-bottom: 1em;
                line-height: 1.75;
                color: #cbd5e1;
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
            }

            .prose-invert li {
                margin-bottom: 0.5em;
                color: #cbd5e1;
            }

            .prose-invert blockquote {
                border-left: 4px solid rgba(99, 102, 241, 0.5);
                padding-left: 1em;
                margin: 1.5em 0;
                font-style: italic;
                color: #94a3b8;
                background: rgba(255, 255, 255, 0.05);
                padding: 1em;
                border-radius: 0.75rem;
                backdrop-filter: blur(8px);
            }

            /* Tab styles */
            .tab-button {
                transition: all 0.3s ease-in-out;
            }

            .tab-button.active {
                border-bottom-color: #6366f1;
                color: #6366f1;
            }

            .tab-content {
                transition: opacity 0.3s ease-in-out;
            }
        </style>

        <x-blog-util />
        <x-blog-main />
        <x-blog-image-generator-js />
        <x-blog-editor />
        <x-blog-metadata />

        <script>
            function setupWordPressFetching() {
                $.ajax({
                    url: website + '/wp-json/limo-blogs/v1/categories',
                    type: 'GET',
                    timeout: 10000,
                    success: function(data) {
                        const categoriesSelect = $('#categoriesSelect');
                        if (Array.isArray(data)) {
                            data.forEach(category => {
                                categoriesSelect.append(
                                    `<option value="${category.id}">${category.name}</option>`
                                );
                            });
                        } else {
                            console.error("Unexpected data format:", data);
                            showToast('Unexpected data format when loading categories', 'warning');
                        }
                        $('#loadingSpinner').addClass('hidden');
                    },
                    error: function(error) {
                        $('#loadingSpinner').addClass('hidden');
                        showToast('Error loading blog categories. Please try again later.', 'error');
                        console.error("Error fetching categories:", error);
                    }
                });
            }

            function setupFormSubmission() {
                document.getElementById('contentForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (!editorInstance) {
                        showToast('Editor not initialized. Please refresh the page.', 'error');
                        return;
                    }

                    const formData = new FormData(this);
                    const payload = {
                        content: editorInstance.getData(),
                        website: website,
                        generated_image: window.imageUrl ?? null,
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
                                            <p class="mb-4 text-slate-300">Your blog post is now live.</p>
                                            <a href="${data.data.permalink}" target="_blank"
                                             class="text-indigo-400 hover:text-indigo-300 underline">
                                            View Blog Post
                                            </a>
                                        `,
                                        icon: 'success',
                                        confirmButtonText: 'Done',
                                        showCancelButton: true,
                                        cancelButtonText: 'View All Posts',
                                        cancelButtonColor: '#6366f1'
                                    };
                                    break;
                                case 'draft':
                                    alertConfig = {
                                        title: 'Draft Saved',
                                        html: '<p class="text-slate-300">Your blog post has been saved as a draft</p>',
                                        icon: 'info',
                                        confirmButtonText: 'OK'
                                    };
                                    break;
                                case 'schedule':
                                    alertConfig = {
                                        title: 'Blog Scheduled',
                                        html: `<p class="text-slate-300">Post scheduled for publication on ${payload.schedule_date}</p>`,
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
            // Parse the selected pages from PHP to JavaScript
            const selectedPages = {!! json_encode(json_decode($client->selected_pages)) !!};

            function displaySelectedPages(pages) {
                const $pagesContainer = $('<div>')
                    .addClass('pages-container glass-dark border border-white/20 rounded-xl overflow-auto p-4 scrollbar-dark')
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
                        .addClass('text-slate-300 hover:text-white transition-all duration-200')
                        .append(
                            $('<a>')
                            .attr('href', '#')
                            .attr('data-page-url', page.url)
                            .attr('data-page-title', page.title)
                            .addClass('text-md font-medium break-words hover:underline page-link hover:text-indigo-400')
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
                    .addClass('text-sm text-slate-400 mb-3 font-medium')
                    .text('Select text in the editor and click on a page to create a link:')
                );
            }

            function applyLinkToSelectedText(url, pageTitle) {
                if (!editorInstance) {
                    showToast('Editor not initialized. Please refresh the page.', 'error');
                    return;
                }

                const selection = editorInstance.model.document.selection;
                if (selection.isCollapsed) {
                    showToast('Please select some text in the editor first to create a link.', 'warning');
                    return;
                }

                editorInstance.execute('link', url, {
                    linkIsExternal: true,
                    linkIsDownloadable: false
                });

                showToast(`Link created to "${pageTitle}"`, 'success');
            }

            document.addEventListener('DOMContentLoaded', () => {
                displaySelectedPages(selectedPages);
            });
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
        </script>
    @endpush

    <footer class="w-full text-center py-8 text-slate-400 text-sm border-t border-white/10 mt-12 glass-dark">
        <p class="mb-2">
            This site is protected by U.S. data protection laws.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('privacy.policy') }}" class="text-indigo-400 hover:text-indigo-300 underline transition-colors duration-200">Privacy Policy</a>
            <span class="text-slate-600">|</span>
            <a href="{{ route('terms.service') }}" class="text-indigo-400 hover:text-indigo-300 underline transition-colors duration-200">Terms of Service</a>
        </div>
    </footer>
</x-guest-layout>
