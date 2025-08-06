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
            // rutas para cuando escale
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
            .ck-content, .prose {
                background: transparent !important;
                color: #f1f5f9 !important;
            }
            .ck-content h1, .ck-content h2, .ck-content h3, .ck-content h4, .ck-content h5, .ck-content h6,
            .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
                color: #fff !important;
            }
            .ck-content a, .prose a {
                color: #818cf8 !important;
            }
            .ck-content a:hover, .prose a:hover {
                color: #a5b4fc !important;
            }
            .ck-content blockquote, .prose blockquote {
                border-left: 4px solid #6366f1 !important;
                background: #312e81 !important;
                color: #c7d2fe !important;
            }
            .ck-content ul, .ck-content ol, .prose ul, .prose ol {
                color: #e0e7ef !important;
            }
            .ck-content li, .prose li {
                color: #e0e7ef !important;
            }
        </style>
    @endpush
    <footer class="w-full text-center py-6 text-slate-400 text-sm border-t border-white/15 mt-8">
        <p>
            This site is protected by U.S. data protection laws. <br>
            <a href="{{ route('privacy.policy') }}" class="text-indigo-400 hover:underline">Privacy Policy</a> |
            <a href="{{ route('terms.service') }}" class="text-indigo-400 hover:underline">Terms of Service</a>
        </p>
    </footer>
</x-guest-layout>
