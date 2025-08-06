<section class="glass-card shadow-xl rounded-2xl overflow-hidden border border-white/10 animate-slide-up sticky top-4">
    <div class="bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border-b border-white/10 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-white">Image Preview</h2>
                <p class="text-sm text-slate-400 mt-1">Generated or uploaded image will appear here</p>
            </div>
        </div>
    </div>
    
    <div class="p-6 max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-dark">
        <!-- Image Container -->
        <div id="generatedImageContainer" class="mb-6 min-h-[200px] glass-input rounded-xl border border-white/10 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                <svg class="h-16 w-16 mb-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-center font-medium text-slate-300">No image generated yet</p>
                <p class="text-sm text-slate-500 mt-1">Generate with AI or upload your own</p>
            </div>
        </div>

        <!-- Download Button -->
        <button id="downloadBtn" disabled 
            class="w-full mb-6 py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 disabled:from-slate-600 disabled:to-slate-700 disabled:cursor-not-allowed text-white rounded-xl transition-all duration-300 flex items-center justify-center font-medium text-sm shadow-lg hover:shadow-xl disabled:shadow-none transform hover:-translate-y-0.5 disabled:transform-none">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            Download Image
        </button>

        <!-- Internal Links Section -->
        <div class="glass-input p-4 rounded-xl border border-white/10">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Internal Links
            </h3>
            <div id="select-container" class="space-y-2">
                <div class="text-sm text-slate-400 mb-3 font-medium">
                    Select text in the editor and click on a page to create a link:
                </div>
                <div class="pages-container glass-input border border-white/10 rounded-lg overflow-auto p-4 max-h-48 scrollbar-dark">
                    <div class="text-center text-slate-500 py-4">
                        <svg class="w-8 h-8 mx-auto mb-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        Loading pages...
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
