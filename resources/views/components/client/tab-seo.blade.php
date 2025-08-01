<div id="seo-tab" class="tab-content hidden">

    <!-- Content -->
    <div class="p-6 space-y-6">
        <!-- SEO Email -->
        <div class="bg-gray-50 rounded-lg p-4">
            <label for="seo_email" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                SEO Contact Email
            </label>
            <input type="email" id="seo_email" name="seo[seo_email]" value="{{ $client->clientSeo->seo_email ?? '' }}"
                placeholder="Enter SEO contact email address"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
        </div>

        <!-- Keywords -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <label for="keywords" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    Target Keywords
                </label>
                <div class="flex items-center gap-2">
                    <button type="button" id="generateKeywordsButton" data-target="keywords"
                        class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Content
                    </button>
                    <div id="loaderKeywords" class="hidden">
                        <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <textarea id="keywords" name="seo[keywords]" rows="3" placeholder="Enter target keywords separated by commas..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ $client->clientSeo->keywords ?? '' }}</textarea>
            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Separate keywords with commas for better organization
            </p>
        </div>

        <!-- Short Description -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <label for="short_description" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Meta Description
                </label>
                <div class="flex items-center gap-2">
                    <button type="button" id="generateShortContentButton" data-target="short_description"
                        class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Content
                    </button>
                    <div id="loaderShortContent" class="hidden">
                        <svg class="animate-spin h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <textarea id="short_description" name="seo[description_short]" rows="3"
                placeholder="Write a compelling meta description that appears in search results..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ $client->clientSeo->description_short ?? '' }}</textarea>
            <div class="flex items-center justify-between mt-2">
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Optimal length: 150-160 characters
                </p>
                <span class="text-xs text-gray-400" id="short-char-count">0 characters</span>
            </div>
        </div>

        <!-- Long Description -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <label for="long_description" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Detailed Description
                </label>
                <div class="flex items-center gap-2">
                    <button type="button" id="generateLongContentButton" data-target="long_description"
                        class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Content
                    </button>
                    <div id="loaderLongContent" class="hidden">
                        <svg class="animate-spin h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <textarea id="long_description" name="seo[description_long]" rows="5"
                placeholder="Provide a comprehensive description for better SEO coverage..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ $client->clientSeo->description_long ?? '' }}</textarea>
        </div>

        <!-- Blog Post -->
        <div class="bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 rounded-lg p-4">
            <label for="blog_post" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
                Blog Post Content
            </label>
            <textarea id="blog_post" name="seo[blog_post]" rows="8"
                placeholder="Create engaging blog content that incorporates your target keywords naturally..."
                class="w-full px-4 py-3 border border-orange-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 resize-none bg-white">{{ $client->clientSeo->blog_post ?? '' }}</textarea>
        </div>

        <!-- Spun Description -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <label for="spun_description" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Alternative Description
                </label>
                <div class="flex items-center gap-2">
                    <button type="button" id="generateSpunContentButton" data-target="spun_description"
                        class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Content
                    </button>
                    <div id="loaderSpunContent" class="hidden">
                        <svg class="animate-spin h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <textarea id="spun_description" name="seo[spun_description]" rows="5"
                placeholder="Create variations of your content for different platforms and uses..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ $client->clientSeo->spun_description ?? '' }}</textarea>
        </div>
    </div>


</div>

<script>
    // Character counter for short description
    document.addEventListener('DOMContentLoaded', function() {
        const shortDesc = document.getElementById('short_description');
        const charCount = document.getElementById('short-char-count');

        function updateCharCount() {
            const count = shortDesc.value.length;
            charCount.textContent = count + ' characters';

            if (count >= 150 && count <= 160) {
                charCount.className = 'text-xs text-green-600 font-medium';
            } else if (count > 160) {
                charCount.className = 'text-xs text-red-600 font-medium';
            } else {
                charCount.className = 'text-xs text-gray-400';
            }
        }

        shortDesc.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count
    });
</script>
