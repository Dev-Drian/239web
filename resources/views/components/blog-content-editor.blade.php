<section class="glass-card shadow-xl rounded-2xl overflow-hidden border border-white/10 animate-slide-up">
    <div class="border-b border-white/10 p-6 bg-gradient-to-r from-indigo-500/10 to-purple-500/10">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-white">Create New Blog Post</h2>
                <p class="text-sm text-slate-400 mt-1">Fill in the details below to create your blog post</p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <form id="contentForm">
            @csrf
            <!-- Title Field -->
            <div class="mb-6">
                <label for="title" class="form-label form-label-required">Post Title</label>
                <input type="text" name="title" id="title" placeholder="Enter a compelling title"
                    value="{{ $topic['title'] ?? '' }}"
                    class="form-input-dark">
            </div>

            <!-- Content Editor -->
            <div class="mb-8">
                <label for="content" class="form-label form-label-required">Content</label>
                <textarea name="content" id="editor" placeholder="Write your blog content here"
                    class="min-h-[400px] form-textarea-dark">{{ $generatedContent ?? '' }}</textarea>
            </div>

            <!-- Publication Options -->
            <div class="glass-input p-6 rounded-xl mb-8 border border-white/10">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    Publishing Options
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="post_status" class="form-label">Post Status</label>
                        <select name="post_status" id="post_status" class="form-select-dark">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                            <option value="schedule">Schedule</option>
                        </select>
                    </div>
                    <div>
                        <label for="categoriesSelect" class="form-label">Categories</label>
                        <select id="categoriesSelect" class="form-select-dark">
                            <option value="">All Categories</option>
                        </select>
                    </div>
                </div>
                
                <!-- Schedule Date (Hidden by default) -->
                <div id="schedule_date_container" class="mt-6 hidden">
                    <label for="schedule_date" class="form-label">Schedule Publication</label>
                    <input type="datetime-local" name="schedule_date" id="schedule_date" class="form-input-dark">
                </div>
            </div>

            <!-- SEO Section -->
            <div class="glass-input p-6 rounded-xl mb-8 border border-white/10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        SEO & Metadata
                    </h3>
                    <button type="button" id="generateAllMeta" 
                        class="px-4 py-2 bg-gradient-to-r from-purple-500/20 to-indigo-500/20 hover:from-purple-500/30 hover:to-indigo-500/30 text-purple-400 text-sm rounded-lg transition-all duration-200 flex items-center border border-purple-500/30 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate All SEO
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Meta Title -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <button type="button" id="generateMetaTitle"
                                class="px-3 py-1.5 bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-400 text-xs rounded-lg transition-all duration-200 flex items-center border border-indigo-500/30">
                                <div class="hidden mr-1" id="titleGenerateSpinner">
                                    <div class="w-3 h-3 border border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                                <svg class="h-3 w-3 mr-1" id="titleGenerateIcon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span id="titleGenerateText">Generate</span>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="meta_title" id="meta_title"
                                placeholder="SEO optimized title (max 60 chars)" maxlength="60"
                                class="form-input-dark pr-12">
                            <div id="titleSpinner" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                                <div class="w-5 h-5 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                            <div class="absolute bottom-1 right-3 text-xs text-slate-400">
                                <span id="titleCharCount">0</span>/60
                            </div>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <button type="button" id="generateMetaDescription"
                                class="px-3 py-1.5 bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-400 text-xs rounded-lg transition-all duration-200 flex items-center border border-indigo-500/30">
                                <div class="hidden mr-1" id="descriptionGenerateSpinner">
                                    <div class="w-3 h-3 border border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                                <svg class="h-3 w-3 mr-1" id="descriptionGenerateIcon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span id="descriptionGenerateText">Generate</span>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="meta_description" id="meta_description"
                                placeholder="SEO optimized description (max 170 chars)" maxlength="170"
                                class="form-input-dark pr-12">
                            <div id="descriptionSpinner" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                                <div class="w-5 h-5 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                            <div class="absolute bottom-1 right-3 text-xs text-slate-400">
                                <span id="descriptionCharCount">0</span>/170
                            </div>
                        </div>
                    </div>

                    <!-- Extra Block -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="extra_block" class="form-label">Extra Content Block</label>
                            <button type="button" id="generateExtraBlock"
                                class="px-3 py-1.5 bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-400 text-xs rounded-lg transition-all duration-200 flex items-center border border-indigo-500/30">
                                <div class="hidden mr-1" id="extraBlockGenerateSpinner">
                                    <div class="w-3 h-3 border border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                                <svg class="h-3 w-3 mr-1" id="extraBlockGenerateIcon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span id="extraBlockGenerateText">Generate</span>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="extra_block" id="extra_block"
                                placeholder="Additional content suggestion"
                                class="form-input-dark pr-12">
                            <div id="extraBlockSpinner" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                                <div class="w-5 h-5 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <button id="generatePreviewBtn" type="button" 
                    class="px-6 py-3 bg-gradient-to-r from-slate-600/20 to-slate-500/20 hover:from-slate-600/30 hover:to-slate-500/30 text-slate-300 rounded-lg transition-all duration-200 flex items-center border border-slate-500/30 font-medium">
                    <div class="hidden mr-2" id="previewSpinner">
                        <div class="w-4 h-4 border-2 border-slate-300 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <svg class="w-4 h-4 mr-2" id="previewIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span id="previewText">Generate Preview</span>
                </button>
                
                <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg transition-all duration-200 flex items-center font-medium shadow-lg hover:shadow-xl">
                    <div id="submitSpinner" class="hidden mr-2">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Submit Blog Post
                </button>
            </div>
        </form>
    </div>
</section>
