<div id="available-blocks-section" class="glass-dark shadow-sm rounded-lg overflow-hidden sticky top-8">
    <div class="border-b border-white/15 p-5 pl-0 flex items-center justify-between">
        <h3 class="font-medium text-white">Available Pages</h3>
        <span class="text-xs text-slate-400 glass-dark rounded-full px-2 py-1"
            id="page-counter">{{count(json_decode($client->selected_pages ?? '[]')) }}</span>
    </div>
    <div class="">

        <div id="select-container" class="rounded-lg overflow-auto h-56">
         
        </div>
    </div>
</div>

<!-- Generated Image Section -->
<div id="image-preview-section" class="glass-dark shadow-sm rounded-lg overflow-hidden mt-8 sticky"
    style="top: calc(8rem + 170px);">
    <div class="border-b border-white/15 p-5">
        <h3 class="font-medium text-white">Generated Image</h3>
    </div>
    <div class="p-5 space-y-6">
        <div>
            <div id="generatedImageContainer"
                class="border-2 border-dashed border-white/20 rounded-lg p-6 flex flex-col items-center justify-center min-h-[250px] glass-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-slate-400 mt-3 text-center">No image generated yet</p>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex justify-between pt-2">
            <button type="button" id="useImageBtn"
                class="text-indigo-400 hover:text-indigo-300 px-3 py-2 rounded-md hover:bg-white/10 transition duration-150"
                disabled>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Use Image
                </span>
            </button>
            <button type="button" id="downloadBtn"
                class="text-indigo-400 hover:text-indigo-300 px-3 py-2 rounded-md hover:bg-white/10 transition duration-150"
                disabled>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Download
                </span>
            </button>
        </div>
    </div>
</div>
