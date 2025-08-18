<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-white">
                    {{ __('Blog Management') }}
                </h2>
                <span class="text-sm text-slate-400">Content Publishing System</span>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <x-stat-card iconColor="indigo" title="Total Posts" value="0" id="totalPosts" />
            <x-stat-card iconColor="green" title="Indexed" value="0" id="indexedPosts" />
            <x-stat-card iconColor="yellow" title="Pending" value="0" id="pendingPosts" />
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="flex justify-center my-8">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
        </div>

        <!-- Blog Posts Table -->
        <div x-data="{ open: false }"
            class="glass-dark shadow-xl sm:rounded-xl mb-6 transition-all duration-300 hover:shadow-2xl overflow-hidden border border-white/15">
            <button @click="open = !open"
                class="w-full text-left px-6 py-4 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-white font-semibold uppercase tracking-wider focus:outline-none flex items-center justify-between hover:from-indigo-500/30 hover:to-purple-500/30 transition-all duration-300">
                <span>Show/Hide Blog Table</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-500 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="overflow-x-auto p-4 glass-dark rounded-b-xl shadow-inner">
                    <table class="min-w-full divide-y divide-white/15">
                        <thead class="glass-dark">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                    Posts Indexed</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                    PR</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                    Date Created</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="postsTable" class="glass-dark divide-y divide-white/15"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Blog Topic Suggestions Component -->
        <div class="glass-dark rounded-xl shadow-xl w-full h-full overflow-hidden border border-white/15">
            <!-- Header Section -->
            <div
                class="px-6 py-4 flex justify-between items-center bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border-b border-white/15">
                <div>
                    <h3 class="text-lg font-medium text-white">Blog Topic Suggestions</h3>
                    <p class="text-sm text-slate-300">Generate and manage blog topics</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- AI Type Toggle Buttons -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-300">AI Type:</span>
                        <div class="flex rounded-lg overflow-hidden border border-white/20">
                            <button id="gptButton"
                                class="px-3 py-1.5 bg-indigo-500 text-white font-medium text-sm hover:bg-indigo-600 transition-colors ai-type-button active">
                                GPT
                            </button>
                            <button id="perplexityButton"
                                class="px-3 py-1.5 glass-dark text-slate-300 font-medium text-sm hover:bg-white/10 transition-colors ai-type-button">
                                Perplexity
                            </button>
                        </div>
                    </div>
                    <!-- Generate Suggestions Button -->
                    <button id="getSuggestions"
                        class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center"
                        onclick="contentGenerate()">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Give Topic Suggestions
                    </button>
                    <button id="singleArticleBtn"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center space-x-2"
                        onclick="openSingleArticleModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Single Article</span>
                    </button>
                </div>
            </div>
            <!-- Content Section -->
            <div class="p-6 overflow-y-auto h-[calc(100%-120px)] glass-dark rounded-b-xl">
                <!-- Spinner de carga -->
                <div id="suggestionsSpinner" class="hidden flex flex-col items-center justify-center py-12 space-y-3">
                    <div class="flex space-x-2">
                        <div class="h-4 w-4 bg-indigo-500 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                        <div class="h-4 w-4 bg-indigo-400 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                        <div class="h-4 w-4 bg-indigo-300 rounded-full animate-bounce"></div>
                    </div>
                    <span class="text-slate-300 text-lg font-medium">Generating suggestions...</span>
                </div>
                <!-- Área de sugerencias -->
                <div id="suggestionsArea" class="space-y-4 divide-y divide-white/15"></div>
            </div>
        </div>

        <!-- Modal para enviar a index mejorado -->
        <div id="submitToIndexModal"
            class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
            <div class="relative top-20 mx-auto p-8 w-96 shadow-2xl rounded-2xl bg-gray-800/90 backdrop-blur-lg border border-gray-600/50">
                <!-- Modal Header -->
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Submit to Index</h3>
                    <p class="text-sm text-gray-400 mt-2">Enter the campaign name to submit the post for indexing.</p>
                </div>
                <!-- Modal Body -->
                <div class="mb-6">
                    <label for="campaignName" class="block text-sm font-semibold text-gray-300 mb-2">Campaign
                        Name</label>
                    <input type="text" id="campaignName" placeholder="Enter Campaign Name"
                        class="w-full p-4 bg-gray-700/50 border-2 border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-white placeholder-gray-400"
                        aria-label="Campaign Name">
                </div>
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()"
                        class="px-6 py-3 bg-gray-600/60 text-gray-300 font-semibold rounded-xl shadow-sm hover:bg-gray-600/80 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                        Cancel
                    </button>
                    <button id="submitIndexBtn"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="singleArticleModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div
            class="relative top-10 mx-auto p-8 w-full max-w-2xl shadow-2xl rounded-2xl bg-gray-800/90 backdrop-blur-lg border border-gray-600/50 transform transition-all duration-300 ease-in-out">
            {{-- Modal Header --}}
            <div class="text-center mb-6">
                <div
                    class="w-16 h-16 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Create Single Article</h3>
                <p class="text-sm text-gray-400 mt-2">Enter the article title to generate a professional blog post</p>
            </div>

            {{-- Modal Body --}}
            <div class="mb-6">
                <label for="articleTitle" class="block text-sm font-semibold text-gray-300 mb-2">Article Title</label>
                <input type="text" id="articleTitle" placeholder="Enter the article title..."
                    class="w-full p-4 bg-gray-700/50 border-2 border-gray-600/50 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm text-white placeholder-gray-400"
                    aria-label="Article Title">

                {{-- AI Type Selection --}}
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-300 mb-2">AI Model</label>
                    <div class="flex rounded-xl overflow-hidden border-2 border-gray-600/50 shadow-sm">
                        <button id="singleGptButton"
                            class="flex-1 px-4 py-3 bg-green-600 text-white font-semibold text-sm hover:bg-green-700 transition-all duration-200 ai-type-button active flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>GPT</span>
                        </button>
                        <button id="singlePerplexityButton"
                            class="flex-1 px-4 py-3 bg-gray-700/60 text-gray-300 font-semibold text-sm hover:bg-gray-600/60 transition-all duration-200 ai-type-button flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <span>Perplexity</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Loading State --}}
            <div id="singleArticleLoading" class="hidden mb-6">
                <div class="flex items-center justify-center space-x-3">
                    <div class="w-6 h-6 border-2 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
                    <span class="text-gray-300 font-medium">Generating article...</span>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex justify-end space-x-3">
                <button onclick="closeSingleArticleModal()"
                    class="px-6 py-3 bg-gray-600/60 text-gray-300 font-semibold rounded-xl shadow-sm hover:bg-gray-600/80 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                    Cancel
                </button>
                <button id="generateSingleArticleBtn"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5"
                    onclick="generateSingleArticle()">
                    Generate Article
                </button>
            </div>
        </div>
    </div>

    @include('components.js.blog-scripts')

</x-guest-layout>
