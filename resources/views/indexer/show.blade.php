<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Sitemap Indexer'])
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div
                            class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Dashboard Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-5 rounded-lg shadow-sm border border-blue-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 mr-4">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Found Sitemaps</p>
                                    <p class="text-2xl font-bold text-blue-900">{{ count($sitemaps) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 p-5 rounded-lg shadow-sm border border-green-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 mr-4">
                                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-800">Blog URLs</p>
                                    <p class="text-2xl font-bold text-green-900">{{ $total_blog_urls }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-gray-100 mr-4">
                                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Other URLs</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $total_other_urls }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Form -->
                    <form method="POST" action="{{ route('indexer.submit') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="sitemap_url" value="{{ $sitemap_url }}">

                        <div class="bg-gray-50 p-5 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Campaign Settings</h3>
                            <div>
                                <label for="campaign_name" class="block text-sm font-medium text-gray-700 mb-1">Campaign
                                    Name</label>
                                <input type="text" id="campaign_name" name="campaign_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100 cursor-not-allowed"
                                    value="{{ $sitemap_url }} - {{ now()->format('F j, Y') }}" readonly>
                                @error('campaign_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Sitemap list with toggle -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Available URLs</h3>
                                <div class="flex items-center">
                                    <span id="selected-count" class="text-sm font-medium text-blue-700 mr-2">0</span>
                                    <span class="text-sm text-gray-600">URLs selected</span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach ($organized_urls as $sitemap => $urls)
                                    <div class="border rounded-lg overflow-hidden shadow-sm">
                                        <button type="button"
                                            class="toggle-sitemap flex justify-between items-center w-full p-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                                <span class="font-medium text-gray-700">{{ $sitemap }}</span>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="text-sm text-green-600 font-medium flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    {{ count($urls['blog_urls']) }}
                                                </span>
                                                <span class="text-sm text-gray-600 font-medium flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                        </path>
                                                    </svg>
                                                    {{ count($urls['other_urls']) }}
                                                </span>
                                            </div>
                                        </button>

                                        <div class="sitemap-content hidden p-5 border-t">
                                            <!-- Blog URLs Section -->
                                            @if (count($urls['blog_urls']) > 0)
                                                <div class="mb-6">
                                                    <div class="flex justify-between items-center mb-3">
                                                        <h4 class="font-medium text-gray-900">Blog URLs</h4>
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox"
                                                                class="select-all-blogs rounded text-blue-600 border-gray-300 focus:ring-blue-500"
                                                                data-sitemap="{{ md5($sitemap) }}">
                                                            <span class="ml-2 text-sm text-gray-700">
                                                                Select all blog URLs
                                                            </span>
                                                        </label>
                                                    </div>

                                                    <div class="space-y-3 max-h-72 overflow-y-auto pr-2">
                                                        @foreach ($urls['blog_urls'] as $index => $url)
                                                            <div class="flex items-start p-2 rounded hover:bg-gray-50">
                                                                <input type="checkbox" name="selected_urls[]"
                                                                    value="{{ $url['url'] }}"
                                                                    class="url-checkbox blog-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500 mt-1"
                                                                    data-sitemap="{{ md5($sitemap) }}">
                                                                <label class="ml-2 block text-sm text-gray-700">
                                                                    <a href="{{ $url['url'] }}" target="_blank"
                                                                        class="text-blue-600 hover:underline truncate block max-w-lg">
                                                                        {{ $url['url'] }}
                                                                    </a>
                                                                    @if ($url['lastmod'])
                                                                        <span class="text-xs text-gray-500 block">
                                                                            <span class="font-medium">Last
                                                                                modified:</span> {{ $url['lastmod'] }}
                                                                        </span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Other URLs Section -->
                                            @if (count($urls['other_urls']) > 0)
                                                <div>
                                                    <div class="flex justify-between items-center mb-3">
                                                        <h4 class="font-medium text-gray-900">Other URLs</h4>
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox"
                                                                class="select-all-others rounded text-blue-600 border-gray-300 focus:ring-blue-500"
                                                                data-sitemap="{{ md5($sitemap) }}">
                                                            <span class="ml-2 text-sm text-gray-700">
                                                                Select all other URLs
                                                            </span>
                                                        </label>
                                                    </div>

                                                    <div class="space-y-3 max-h-72 overflow-y-auto pr-2">
                                                        @foreach ($urls['other_urls'] as $index => $url)
                                                            <div class="flex items-start p-2 rounded hover:bg-gray-50">
                                                                <input type="checkbox" name="selected_urls[]"
                                                                    value="{{ $url['url'] }}"
                                                                    class="url-checkbox other-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500 mt-1"
                                                                    data-sitemap="{{ md5($sitemap) }}">
                                                                <label class="ml-2 block text-sm text-gray-700">
                                                                    <a href="{{ $url['url'] }}" target="_blank"
                                                                        class="text-blue-600 hover:underline truncate block max-w-lg">
                                                                        {{ $url['url'] }}
                                                                    </a>
                                                                    @if ($url['lastmod'])
                                                                        <span class="text-xs text-gray-500 block">
                                                                            <span class="font-medium">Last
                                                                                modified:</span> {{ $url['lastmod'] }}
                                                                        </span>
                                                                    @endif

                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end items-center pt-4">
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                    </path>
                                </svg>
                                Submit Selected URLs for Indexing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle sitemaps
                document.querySelectorAll('.toggle-sitemap').forEach(button => {
                    button.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('svg');

                        content.classList.toggle('hidden');
                        icon.classList.toggle('rotate-90');
                    });
                });

                // Select all blog URLs in a sitemap
                document.querySelectorAll('.select-all-blogs').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const sitemapHash = this.getAttribute('data-sitemap');
                        const checkboxes = document.querySelectorAll(
                            `.blog-checkbox[data-sitemap="${sitemapHash}"]`
                        );

                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                        });

                        updateSelectedCount();
                    });
                });

                // Select all other URLs in a sitemap
                document.querySelectorAll('.select-all-others').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const sitemapHash = this.getAttribute('data-sitemap');
                        const checkboxes = document.querySelectorAll(
                            `.other-checkbox[data-sitemap="${sitemapHash}"]`
                        );

                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                        });

                        updateSelectedCount();
                    });
                });

                // Update selection counter
                function updateSelectedCount() {
                    const count = document.querySelectorAll('.url-checkbox:checked').length;
                    document.getElementById('selected-count').textContent = count;
                }

                document.querySelectorAll('.url-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });
            });
        </script>
        <style>
            .rotate-90 {
                transform: rotate(90deg);
            }

            /* Scrollbar styling */
            .max-h-72::-webkit-scrollbar {
                width: 6px;
            }

            .max-h-72::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .max-h-72::-webkit-scrollbar-thumb {
                background: #cbd5e0;
                border-radius: 10px;
            }

            .max-h-72::-webkit-scrollbar-thumb:hover {
                background: #a0aec0;
            }
        </style>
    @endpush
</x-app-layout>
