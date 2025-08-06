<section class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-6">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Featured Image</h2>
                <p class="text-sm text-gray-600 mt-1">Generate with AI or upload your own image for the blog post</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <!-- Enhanced Tabs -->
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button type="button" id="aiTab" class="tab-button active group py-3 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 transition-all duration-200">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Generate with AI</span>
                    </div>
                </button>
                <button type="button" id="uploadTab" class="tab-button group py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200">
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
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="imgprompt" class="block text-sm font-medium text-gray-700 mb-3">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Image Prompt</span>
                        </span>
                    </label>
                    <textarea name="imgprompt" id="imgprompt" rows="3" 
                        placeholder="Describe the image you want to generate in detail..." required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-all duration-200">2024 black mercedes benz S 500 in Manhattan</textarea>
                    <p class="text-xs text-gray-500 mt-2">Be specific and descriptive for better results</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="ai_type" class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <span>AI Model</span>
                            </span>
                        </label>
                        <select id="ai_type" name="ai_type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="sd3">SD3 (Standard)</option>
                            <option value="core">Core (Enhanced)</option>
                            <option value="ultra">Ultra (Premium)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="output_format" class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Format</span>
                            </span>
                        </label>
                        <select id="output_format" name="output_format"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="jpeg">JPEG (Standard)</option>
                            <option value="png">PNG (Lossless)</option>
                            <option value="webp">WebP (Optimized)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="image_ratio" class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                                <span>Aspect Ratio</span>
                            </span>
                        </label>
                        <select id="image_ratio" name="image_ratio"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="16:9">16:9 (Landscape)</option>
                            <option value="1:1">1:1 (Square)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="button" id="generateImageBtn"
                        class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-200 flex items-center justify-center font-medium text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                        <span id="generateBtnText">Generate Featured Image</span>
                        <span id="imageSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
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
                    <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-all duration-300 bg-gray-50 hover:bg-blue-50 group cursor-pointer">
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-300">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Upload your image</h3>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="imageFile" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                                        Choose File
                                        <input id="imageFile" name="imageFile" type="file" class="sr-only" accept="image/*" />
                                    </label>
                                    <p class="text-sm text-gray-500">or drag and drop your image here</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
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
                    <div id="filePreview" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <img id="previewImage" class="w-16 h-16 object-cover rounded-lg" src="/placeholder.svg" alt="Preview">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p id="fileName" class="text-sm font-medium text-gray-900 truncate"></p>
                                <p id="fileSize" class="text-sm text-gray-500"></p>
                            </div>
                            <button type="button" id="removeFile" class="flex-shrink-0 text-red-600 hover:text-red-800">
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
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="imageUrl" class="block text-sm font-medium text-gray-700">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <span>Image URL</span>
                        </span>
                    </label>
                    <input type="url" id="imageUrl" name="imageUrl" 
                        placeholder="https://example.com/image.jpg"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <p class="text-xs text-gray-500">Enter a direct URL to an image</p>
                </div>

                <!-- Upload Button -->
                <div class="pt-4 space-y-3">
                    <button type="button" id="uploadImageBtn"
                        class="w-full py-4 px-6 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition-all duration-200 flex items-center justify-center font-medium text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span id="uploadBtnText">Process Image</span>
                        <span id="uploadSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    
                    <button type="button" id="resetImageBtn" 
                        class="hidden w-full py-3 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 flex items-center justify-center font-medium text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
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
        <div class="bg-gray-200 rounded-full h-2 mx-6 mb-4">
            <div id="progressFill" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>
</section>
