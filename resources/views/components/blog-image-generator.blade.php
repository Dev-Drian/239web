<section class="glass-card shadow-xl rounded-2xl overflow-hidden border border-white/10 animate-slide-up">
    <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-b border-white/10 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-white">Featured Image</h2>
                <p class="text-sm text-slate-400 mt-1">Generate with AI or upload your own image for the blog post</p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <!-- Enhanced Tabs -->
        <div class="border-b border-white/10 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button type="button" id="aiTab" class="tab-button active group py-3 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-400 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Generate with AI</span>
                    </div>
                </button>
                <button type="button" id="uploadTab" class="tab-button group py-3 px-1 border-b-2 border-transparent font-medium text-sm text-slate-400 hover:text-slate-300 hover:border-white/20 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span>Upload Image</span>
                    </div>
                </button>
            </nav>
        </div>

        <!-- AI Generation Tab -->
        <div id="aiTabContent" class="tab-content">
            <form id="imageForm" class="space-y-6">
                <div class="glass-input rounded-xl p-4 border border-white/10">
                    <label for="imgprompt" class="form-label mb-3">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Image Prompt</span>
                        </span>
                    </label>
                    <textarea name="imgprompt" id="imgprompt" rows="3"
                         placeholder="Describe the image you want to generate in detail..." required
                        class="form-textarea-dark resize-none">2024 black mercedes benz S 500 in Manhattan</textarea>
                    <p class="text-xs text-slate-500 mt-2">Be specific and descriptive for better results</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="ai_type" class="form-label">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <span>AI Model</span>
                            </span>
                        </label>
                        <select id="ai_type" name="ai_type" class="form-select-dark">
                            <option value="sd3">SD3 (Standard)</option>
                            <option value="core">Core (Enhanced)</option>
                            <option value="ultra">Ultra (Premium)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="output_format" class="form-label">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Format</span>
                            </span>
                        </label>
                        <select id="output_format" name="output_format" class="form-select-dark">
                            <option value="jpeg">JPEG (Standard)</option>
                            <option value="png">PNG (Lossless)</option>
                            <option value="webp">WebP (Optimized)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="image_ratio" class="form-label">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                                <span>Aspect Ratio</span>
                            </span>
                        </label>
                        <select id="image_ratio" name="image_ratio" class="form-select-dark">
                            <option value="16:9">16:9 (Landscape)</option>
                            <option value="1:1">1:1 (Square)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="button" id="generateImageBtn"
                        class="w-full py-4 px-6 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl transition-all duration-300 flex items-center justify-center font-medium text-base shadow-lg hover:shadow-xl hover:shadow-purple-500/25 transform hover:-translate-y-0.5">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                        <span id="generateBtnText">Generate Featured Image</span>
                        <span id="imageSpinner" class="hidden ml-2">
                            <div class="loading-spinner"></div>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Enhanced Upload Image Tab -->
        <div id="uploadTabContent" class="tab-content hidden">
            <form id="uploadForm" class="space-y-6">
                <!-- Drag & Drop Area -->
                <div class="relative">
                    <div id="dropZone" class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center hover:border-indigo-400/50 transition-all duration-300 glass-input hover:bg-white/10 group cursor-pointer">
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-indigo-500/20 rounded-full flex items-center justify-center group-hover:bg-indigo-500/30 transition-colors duration-300">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-white mb-2">Upload your image</h3>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="imageFile" class="btn-primary cursor-pointer">
                                        Choose File
                                        <input id="imageFile" name="imageFile" type="file" class="sr-only" accept="image/*" />
                                    </label>
                                    <p class="text-sm text-slate-400">or drag and drop your image here</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center space-x-4 text-xs text-slate-500">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>PNG, JPG, WebP</span>
                                </span>
                                <span>•</span>
                                <span>Max 5MB</span>
                                <span>•</span>
                                <span>Min 800x600px</span>
                            </div>
                        </div>
                    </div>

                    <!-- File Preview -->
                    <div id="filePreview" class="hidden mt-4 p-4 glass-input rounded-xl border border-white/10">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <img id="previewImage" class="w-16 h-16 object-cover rounded-lg border border-white/20" src="/placeholder.svg" alt="Preview">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p id="fileName" class="text-sm font-medium text-white truncate"></p>
                                <p id="fileSize" class="text-sm text-slate-400"></p>
                            </div>
                            <button type="button" id="removeFile" class="flex-shrink-0 text-red-400 hover:text-red-300 p-2 hover:bg-red-500/10 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- URL Input Alternative -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 glass-input text-slate-400">or</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="imageUrl" class="form-label">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <span>Image URL</span>
                        </span>
                    </label>
                    <input type="url" id="imageUrl" name="imageUrl"
                         placeholder="https://example.com/image.jpg"
                        class="form-input-dark">
                    <p class="text-xs text-slate-500">Enter a direct URL to an image</p>
                </div>

                <!-- Upload Button -->
                <div class="pt-4 space-y-3">
                    <button type="button" id="uploadImageBtn"
                        class="w-full py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-300 flex items-center justify-center font-medium text-base shadow-lg hover:shadow-xl hover:shadow-green-500/25 transform hover:-translate-y-0.5">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span id="uploadBtnText">Process Image</span>
                        <span id="uploadSpinner" class="hidden ml-2">
                            <div class="loading-spinner"></div>
                        </span>
                    </button>

                    <button type="button" id="resetImageBtn"
                         class="hidden w-full py-3 px-4 btn-ghost">
                        <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Reset Image
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Progress Bar -->
    <div id="progressBar" class="hidden">
        <div class="glass-input rounded-full h-2 mx-6 mb-4 border border-white/10">
            <div id="progressFill" class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>
</section>
