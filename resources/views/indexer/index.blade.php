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
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-blue-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Sitemap Analyzer</h1>
                                <p class="text-slate-400">Extract and analyze URLs from XML sitemaps</p>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Sitemap Form -->
                    <form id="sitemapForm" method="POST" action="{{ route('indexer.extract') }}"
                        class="mb-10 glass rounded-2xl p-6 border border-white/20 backdrop-blur-xl shadow-lg">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="sitemap_url" class="block text-sm font-medium text-slate-300 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    {{ __('Sitemap URL') }}
                                </label>
                                <div class="flex gap-4">
                                    <div class="flex-grow">
                                        <input id="sitemap_url" name="sitemap_url" type="url"
                                            value="{{ old('sitemap_url') }}"
                                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-xl"
                                            placeholder="https://example.com/sitemap.xml" required />
                                        @error('sitemap_url')
                                            <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="self-start">
                                        <button type="submit" id="analyzeBtn"
                                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all duration-300 transform hover:scale-105 hover:-translate-y-0.5 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            <span>{{ __('Analyze Sitemap') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Campaign History Section -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                                <h3 class="text-xl font-bold text-white">Campaign History</h3>
                            </div>
                            @if (isset($campaigns) && count($campaigns) > 0)
                                <div class="flex items-center gap-2 text-sm text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    {{ count($campaigns) }} campaigns found
                                </div>
                            @endif
                        </div>

                        @if (isset($campaigns) && count($campaigns) > 0)
                            <!-- Enhanced Table -->
                            <div class="glass rounded-2xl border border-white/20 backdrop-blur-xl overflow-hidden shadow-lg">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="glass-dark border-b border-white/10">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        Campaign Name
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                        </svg>
                                                        Sitemap URL
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                        </svg>
                                                        URLs Processed
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Date
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        Report
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/10">
                                            @foreach ($campaigns as $campaign)
                                                <tr class="hover:bg-white/5 transition-colors duration-200">
                                                    <td class="px-6 py-4 text-sm font-medium text-white">
                                                        <div class="max-w-xs overflow-hidden">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-lg flex items-center justify-center ring-1 ring-blue-500/30">
                                                                    <span class="text-xs font-bold text-blue-300">{{ substr($campaign->name, 0, 2) }}</span>
                                                                </div>
                                                                <p class="truncate font-medium" title="{{ $campaign->name }}">{{ $campaign->name }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-300">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            <span class="truncate max-w-xs" title="{{ $campaign->sitemap_url }}">{{ $campaign->sitemap_url }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-300">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                                                            <span class="font-medium">{{ number_format($campaign->urls_count) }}</span>
                                                            <span class="text-xs text-slate-500">URLs</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-300">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V11a2 2 0 012-2h4a2 2 0 012 2z" />
                                                            </svg>
                                                            <div>
                                                                <div class="font-medium">{{ $campaign->created_at->format('M d, Y') }}</div>
                                                                <div class="text-xs text-slate-500">{{ $campaign->created_at->format('H:i') }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm">
                                                        @if ($campaign->report_url)
                                                            <a href="{{ $campaign->report_url }}" target="_blank"
                                                                class="inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-300 rounded-lg hover:from-indigo-500/30 hover:to-purple-500/30 transition-all duration-300 border border-indigo-500/30 hover:border-indigo-500/50 transform hover:scale-105"
                                                                title="View Report">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                <span class="text-xs font-medium">View</span>
                                                            </a>
                                                        @else
                                                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-red-500/20 text-red-300 rounded-lg border border-red-500/30">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                                <span class="text-xs font-medium">No Report</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Enhanced Pagination -->
                            @if(method_exists($campaigns, 'links'))
                                <div class="mt-6 flex justify-center">
                                    <div class="glass rounded-xl border border-white/20 backdrop-blur-xl p-2">
                                        {{ $campaigns->links() }}
                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- Enhanced Empty State -->
                            <div class="glass rounded-2xl border border-white/20 backdrop-blur-xl p-12 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-slate-500/20 to-slate-600/20 rounded-2xl flex items-center justify-center mb-6 mx-auto ring-2 ring-slate-500/30">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white mb-2">No Campaign History</h3>
                                <p class="text-slate-400 mb-6 max-w-md mx-auto">Start by analyzing a sitemap to see your campaign history and reports here.</p>
                                <button onclick="document.getElementById('sitemap_url').focus()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 shadow-lg transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="font-medium">Analyze Your First Sitemap</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
        <div class="glass-dark rounded-2xl p-8 border border-white/15 backdrop-blur-xl shadow-2xl text-center max-w-sm mx-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mb-4 mx-auto animate-pulse">
                <svg class="w-8 h-8 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Analyzing Sitemap</h3>
            <p class="text-slate-400 text-sm">Please wait while we process your sitemap...</p>
            <div class="mt-4 w-full bg-slate-700/50 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full animate-pulse" style="width: 60%"></div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sitemapForm');
            const analyzeBtn = document.getElementById('analyzeBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            form.addEventListener('submit', function(e) {
                // Show loading overlay
                loadingOverlay.classList.remove('hidden');
                
                // Update button state
                analyzeBtn.disabled = true;
                analyzeBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Analyzing...</span>
                `;
                
                // Simulate progress (you can replace this with actual progress tracking)
                let progress = 0;
                const progressBar = loadingOverlay.querySelector('.bg-gradient-to-r');
                const interval = setInterval(() => {
                    progress += Math.random() * 10;
                    if (progress > 90) progress = 90;
                    progressBar.style.width = progress + '%';
                }, 500);
                
                // Clean up interval when form actually submits
                setTimeout(() => {
                    clearInterval(interval);
                }, 100);
            });
            
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('[role="alert"]');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.animation = 'slideOutUp 0.5s ease-in-out';
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                }, 5000);
            });
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

    <!-- Enhanced Animations -->
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

        @keyframes slideOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .animate-slideInDown {
            animation: slideInDown 0.5s ease-out;
        }

        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Enhanced hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</x-app-layout>