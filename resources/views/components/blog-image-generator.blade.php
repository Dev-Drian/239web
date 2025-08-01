<section class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="border-b border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800">Featured Image Generator</h2>
        <p class="text-sm text-gray-500 mt-1">Create high-quality images for your blog post</p>
    </div>

    <div class="p-6">
        <form id="imageForm" class="space-y-6">
            <div>
                <label for="imgprompt" class="block text-sm font-medium text-gray-700 mb-2">Image Prompt:</label>
                <textarea name="imgprompt" id="imgprompt" rows="2" placeholder="Describe the image you want to generate" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 2024 black mercedes benz S 500 in Manhattan</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="ai_type" class="block text-sm font-medium text-gray-700 mb-2">AI Model:</label>
                    <select id="ai_type" name="ai_type"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="sd3">SD3 (Standard)</option>
                        <option value="core">Core (Enhanced)</option>
                        <option value="ultra">Ultra (Premium)</option>
                    </select>
                </div>

                <div>
                    <label for="output_format" class="block text-sm font-medium text-gray-700 mb-2">Output
                        Format:</label>
                    <select id="output_format" name="output_format"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="jpeg">JPEG (Standard)</option>
                        <option value="png">PNG (Lossless)</option>
                        <option value="webp">WebP (Optimized)</option>
                    </select>
                </div>

                <div>
                    <label for="image_ratio" class="block text-sm font-medium text-gray-700 mb-2">Aspect Ratio:</label>
                    <select id="image_ratio" name="image_ratio"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="16:9">16:9 (Landscape)</option>
                        <option value="1:1">1:1 (Square)</option>
                    </select>
                </div>
            </div>


            <div class="pt-2">
                <button type="button" id="generateImageBtn"
                    class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200 flex items-center justify-center font-medium text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                            clip-rule="evenodd" />
                    </svg>
                    Generate Featured Image
                    <span id="imageSpinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>
</section>
