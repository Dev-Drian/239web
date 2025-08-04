<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Sitemap Indexer'])
    </x-slot>

    <div class="min-h-screen main-bg py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enhanced Flash Messages -->
            @if (session('success'))
                <div class="mb-6 glass-dark border border-green-500/30 text-green-300 px-6 py-4 rounded-2xl relative backdrop-blur-xl shadow-2xl animate-slideInDown"
                    role="alert">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500/20 rounded-xl flex items-center justify-center mr-3 ring-2 ring-green-500/30">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="absolute top-4 right-4 text-green-400 hover:text-green-300 transition-colors duration-200"
                        onclick="this.parentElement.style.display='none'">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 glass-dark border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl relative backdrop-blur-xl shadow-2xl animate-slideInDown"
                    role="alert">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-500/20 rounded-xl flex items-center justify-center mr-3 ring-2 ring-red-500/30">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="absolute top-4 right-4 text-red-400 hover:text-red-300 transition-colors duration-200"
                        onclick="this.parentElement.style.display='none'">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Main Content Container -->
            <div class="glass-dark shadow-2xl rounded-2xl border border-white/15 backdrop-blur-xl overflow-hidden">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="mb-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-blue-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Sitemap Analysis Results</h1>
                                <p class="text-slate-400">Review and select URLs for indexing</p>
                            </div>
                        </div>

                        <!-- Enhanced Dashboard Summary -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Found Sitemaps Card -->
                            <div class="glass rounded-2xl p-6 border border-blue-500/30 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 backdrop-blur-xl">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-500/20 rounded-2xl flex items-center justify-center mr-4 ring-2 ring-blue-500/30">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-300">Found Sitemaps</p>
                                        <p class="text-3xl font-bold text-blue-100">{{ count($sitemaps) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Blog URLs Card -->
                            <div class="glass rounded-2xl p-6 border border-green-500/30 bg-gradient-to-br from-green-500/10 to-emerald-500/10 backdrop-blur-xl">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-green-500/20 rounded-2xl flex items-center justify-center mr-4 ring-2 ring-green-500/30">
                                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-green-300">Blog URLs</p>
                                        <p class="text-3xl font-bold text-green-100">{{ number_format($total_blog_urls) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Other URLs Card -->
                            <div class="glass rounded-2xl p-6 border border-purple-500/30 bg-gradient-to-br from-purple-500/10 to-pink-500/10 backdrop-blur-xl">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-500/20 rounded-2xl flex items-center justify-center mr-4 ring-2 ring-purple-500/30">
                                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-purple-300">Other URLs</p>
                                        <p class="text-3xl font-bold text-purple-100">{{ number_format($total_other_urls) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Submission Form -->
                    <form method="POST" action="{{ route('indexer.submit') }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="sitemap_url" value="{{ $sitemap_url }}">

                        <!-- Campaign Settings -->
                        <div class="glass rounded-2xl p-6 border border-white/20 backdrop-blur-xl">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Campaign Settings</h3>
                            </div>
                            <div>
                                <label for="campaign_name" class="block text-sm font-medium text-slate-300 mb-2">Campaign Name</label>
                                <input type="text" id="campaign_name" name="campaign_name"
                                    class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-slate-700/50 text-slate-400 cursor-not-allowed focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition-all duration-300 backdrop-blur-xl"
                                    value="{{ $sitemap_url }} - {{ now()->format('F j, Y') }}" readonly>
                                @error('campaign_name')
                                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- URL Selection Section -->
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-8 bg-gradient-to-b from-cyan-500 to-blue-500 rounded-full"></div>
                                    <h3 class="text-xl font-bold text-white">Available URLs</h3>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="glass px-4 py-2 rounded-xl border border-cyan-500/30 bg-gradient-to-r from-cyan-500/10 to-blue-500/10">
                                        <span id="selected-count" class="text-lg font-bold text-cyan-300">0</span>
                                        <span class="text-sm text-slate-400 ml-1">URLs selected</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sitemaps List -->
                            <div class="space-y-4">
                                @foreach ($organized_urls as $sitemap => $urls)
                                    <div class="glass-dark rounded-2xl border border-white/15 backdrop-blur-xl overflow-hidden shadow-lg">
                                        <!-- Sitemap Header -->
                                        <button type="button" class="toggle-sitemap flex justify-between items-center w-full p-6 hover:bg-white/5 transition-all duration-300">
                                            <div class="flex items-center gap-4">
                                                <svg class="w-5 h-5 text-blue-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                                <div class="text-left">
                                                    <h4 class="font-semibold text-white text-lg">{{ $sitemap }}</h4>
                                                    <p class="text-sm text-slate-400">Click to expand and view URLs</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <!-- Blog URLs Badge -->
                                                <div class="flex items-center gap-2 px-3 py-2 bg-green-500/20 text-green-300 rounded-xl border border-green-500/30">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">{{ count($urls['blog_urls']) }}</span>
                                                </div>
                                                <!-- Other URLs Badge -->
                                                <div class="flex items-center gap-2 px-3 py-2 bg-purple-500/20 text-purple-300 rounded-xl border border-purple-500/30">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    <span class="text-sm font-medium">{{ count($urls['other_urls']) }}</span>
                                                </div>
                                            </div>
                                        </button>

                                        <!-- Sitemap Content -->
                                        <div class="sitemap-content hidden border-t border-white/10">
                                            <div class="p-6 space-y-6">
                                                <!-- Blog URLs Section -->
                                                @if (count($urls['blog_urls']) > 0)
                                                    <div class="glass rounded-xl p-5 border border-green-500/30 bg-gradient-to-br from-green-500/5 to-emerald-500/5">
                                                        <div class="flex justify-between items-center mb-4">
                                                            <h4 class="font-semibold text-green-300 flex items-center gap-2">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                Blog URLs ({{ count($urls['blog_urls']) }})
                                                            </h4>
                                                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                                                <input type="checkbox" class="select-all-blogs w-4 h-4 text-green-500 bg-transparent border-green-500/50 rounded focus:ring-green-500/50" data-sitemap="{{ md5($sitemap) }}">
                                                                <span class="text-sm text-green-300 font-medium">Select all blog URLs</span>
                                                            </label>
                                                        </div>
                                                        <div class="space-y-2 max-h-80 overflow-y-auto custom-scrollbar">
                                                            @foreach ($urls['blog_urls'] as $index => $url)
                                                                <div class="flex items-start gap-3 p-3 glass rounded-lg hover:bg-white/5 transition-all duration-200 border border-white/10">
                                                                    <input type="checkbox" name="selected_urls[]" value="{{ $url['url'] }}"
                                                                        class="url-checkbox blog-checkbox w-4 h-4 text-green-500 bg-transparent border-green-500/50 rounded focus:ring-green-500/50 mt-1"
                                                                        data-sitemap="{{ md5($sitemap) }}">
                                                                    <div class="flex-1 min-w-0">
                                                                        <a href="{{ $url['url'] }}" target="_blank"
                                                                            class="text-green-300 hover:text-green-200 text-sm font-medium truncate block transition-colors duration-200">
                                                                            {{ $url['url'] }}
                                                                        </a>
                                                                        @if ($url['lastmod'])
                                                                            <div class="flex items-center gap-1 mt-1">
                                                                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <span class="text-xs text-slate-500">Last modified: {{ $url['lastmod'] }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Other URLs Section -->
                                                @if (count($urls['other_urls']) > 0)
                                                    <div class="glass rounded-xl p-5 border border-purple-500/30 bg-gradient-to-br from-purple-500/5 to-pink-500/5">
                                                        <div class="flex justify-between items-center mb-4">
                                                            <h4 class="font-semibold text-purple-300 flex items-center gap-2">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                                </svg>
                                                                Other URLs ({{ count($urls['other_urls']) }})
                                                            </h4>
                                                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                                                <input type="checkbox" class="select-all-others w-4 h-4 text-purple-500 bg-transparent border-purple-500/50 rounded focus:ring-purple-500/50" data-sitemap="{{ md5($sitemap) }}">
                                                                <span class="text-sm text-purple-300 font-medium">Select all other URLs</span>
                                                            </label>
                                                        </div>
                                                        <div class="space-y-2 max-h-80 overflow-y-auto custom-scrollbar">
                                                            @foreach ($urls['other_urls'] as $index => $url)
                                                                <div class="flex items-start gap-3 p-3 glass rounded-lg hover:bg-white/5 transition-all duration-200 border border-white/10">
                                                                    <input type="checkbox" name="selected_urls[]" value="{{ $url['url'] }}"
                                                                        class="url-checkbox other-checkbox w-4 h-4 text-purple-500 bg-transparent border-purple-500/50 rounded focus:ring-purple-500/50 mt-1"
                                                                        data-sitemap="{{ md5($sitemap) }}">
                                                                    <div class="flex-1 min-w-0">
                                                                        <a href="{{ $url['url'] }}" target="_blank"
                                                                            class="text-purple-300 hover:text-purple-200 text-sm font-medium truncate block transition-colors duration-200">
                                                                            {{ $url['url'] }}
                                                                        </a>
                                                                        @if ($url['lastmod'])
                                                                            <div class="flex items-center gap-1 mt-1">
                                                                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <span class="text-xs text-slate-500">Last modified: {{ $url['lastmod'] }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end items-center pt-6 border-t border-white/10">
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                <span>Submit Selected URLs for Indexing</span>
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
                // Toggle sitemaps with enhanced animations
                document.querySelectorAll('.toggle-sitemap').forEach(button => {
                    button.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('svg');
                        
                        content.classList.toggle('hidden');
                        icon.classList.toggle('rotate-90');
                        
                        // Add smooth animation
                        if (!content.classList.contains('hidden')) {
                            content.style.animation = 'slideDown 0.3s ease-out';
                        }
                    });
                });

                // Select all blog URLs in a sitemap
                document.querySelectorAll('.select-all-blogs').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const sitemapHash = this.getAttribute('data-sitemap');
                        const checkboxes = document.querySelectorAll(`.blog-checkbox[data-sitemap="${sitemapHash}"]`);
                        
                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                            // Add visual feedback
                            if (this.checked) {
                                cb.closest('.flex').classList.add('bg-green-500/10');
                            } else {
                                cb.closest('.flex').classList.remove('bg-green-500/10');
                            }
                        });
                        
                        updateSelectedCount();
                        showNotification(
                            this.checked ? 
                            `Selected ${checkboxes.length} blog URLs! 📝` : 
                            `Deselected ${checkboxes.length} blog URLs! ❌`, 
                            this.checked ? 'success' : 'info'
                        );
                    });
                });

                // Select all other URLs in a sitemap
                document.querySelectorAll('.select-all-others').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const sitemapHash = this.getAttribute('data-sitemap');
                        const checkboxes = document.querySelectorAll(`.other-checkbox[data-sitemap="${sitemapHash}"]`);
                        
                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                            // Add visual feedback
                            if (this.checked) {
                                cb.closest('.flex').classList.add('bg-purple-500/10');
                            } else {
                                cb.closest('.flex').classList.remove('bg-purple-500/10');
                            }
                        });
                        
                        updateSelectedCount();
                        showNotification(
                            this.checked ? 
                            `Selected ${checkboxes.length} other URLs! 🔗` : 
                            `Deselected ${checkboxes.length} other URLs! ❌`, 
                            this.checked ? 'success' : 'info'
                        );
                    });
                });

                // Update selection counter with animation
                function updateSelectedCount() {
                    const count = document.querySelectorAll('.url-checkbox:checked').length;
                    const countElement = document.getElementById('selected-count');
                    const submitBtn = document.getElementById('submitBtn');
                    
                    // Animate counter
                    countElement.style.transform = 'scale(1.2)';
                    countElement.textContent = count;
                    
                    setTimeout(() => {
                        countElement.style.transform = 'scale(1)';
                    }, 200);
                    
                    // Enable/disable submit button
                    if (count > 0) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                // Individual checkbox handlers
                document.querySelectorAll('.url-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        // Add visual feedback
                        if (this.checked) {
                            if (this.classList.contains('blog-checkbox')) {
                                this.closest('.flex').classList.add('bg-green-500/10');
                            } else {
                                this.closest('.flex').classList.add('bg-purple-500/10');
                            }
                        } else {
                            this.closest('.flex').classList.remove('bg-green-500/10', 'bg-purple-500/10');
                        }
                        
                        updateSelectedCount();
                    });
                });

                // Form submission with loading state
                document.querySelector('form').addEventListener('submit', function(e) {
                    const selectedCount = document.querySelectorAll('.url-checkbox:checked').length;
                    
                    if (selectedCount === 0) {
                        e.preventDefault();
                        showNotification('Please select at least one URL to submit! ⚠️', 'error');
                        return;
                    }
                    
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Submitting ${selectedCount} URLs...</span>
                    `;
                    
                    showNotification(`Submitting ${selectedCount} URLs for indexing! 🚀`, 'info');
                });

                // Initialize
                updateSelectedCount();
            });

            // Enhanced notification function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                const colors = {
                    success: 'from-emerald-500 to-green-600 border-emerald-400',
                    error: 'from-red-500 to-pink-600 border-red-400',
                    info: 'from-blue-500 to-indigo-600 border-blue-400'
                };
                
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm backdrop-blur-xl glass-dark`;
                
                notification.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            ${type === 'success' ?
                                 '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                                type === 'error' ?
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                            }
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white/80 hover:text-white transition-colors duration-200 transform hover:scale-110">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 500);
                }, 4000);
            }
        </script>

        <!-- Enhanced Styles -->
        <style>
            @keyframes slideInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    max-height: 0;
                }
                to {
                    opacity: 1;
                    max-height: 1000px;
                }
            }

            .animate-slideInDown {
                animation: slideInDown 0.5s ease-out;
            }

            .rotate-90 {
                transform: rotate(90deg);
            }

            /* Custom scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            /* Enhanced transitions */
            .url-checkbox:checked + div {
                transition: all 0.3s ease;
            }

            /* Hover effects */
            .hover-lift {
                transition: all 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }
        </style>
    @endpush
</x-app-layout>