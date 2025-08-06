<section class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="border-b border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800">Create New Blog Post</h2>
        <p class="text-sm text-gray-500 mt-1">Fill in the details below to create your blog post</p>
    </div>

    <div class="p-6">
        <form id="contentForm">
            @csrf
            <!-- Title Field -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter a compelling title"
                    value="{{ $topic['title'] ?? '' }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Content Editor -->
            <div class="mb-8">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content:</label>
                <textarea name="content" id="editor" placeholder="Write your blog content here"
                    class="min-h-[300px] w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ $generatedContent ?? '' }}
                </textarea>
            </div>
            <!-- Publication Options -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Publishing Options</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="post_status" class="block text-sm font-medium text-gray-700 mb-2">Post
                            Status:</label>
                        <select name="post_status" id="post_status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                            <option value="schedule">Schedule</option>
                        </select>
                    </div>

                    <div>
                        <label for="categoriesSelect"
                            class="block text-sm font-medium text-gray-700 mb-2">Categories:</label>
                        <select id="categoriesSelect"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                        </select>
                    </div>


                </div>

                <!-- Schedule Date (Hidden by default) -->
                <div id="schedule_date_container" class="mt-6 hidden">
                    <label for="schedule_date" class="block text-sm font-medium text-gray-700 mb-2">Schedule
                        Publication:</label>
                    <input type="datetime-local" name="schedule_date" id="schedule_date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- SEO Section -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-medium text-gray-800">SEO & Metadata</h3>
                    <button type="button"
                        id="generateAllMeta"class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Generate All
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Meta Title -->
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title:</label>
                            <button type="button" id="generateMetaTitle"
                                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition duration-200 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Generate
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="meta_title" id="meta_title"
                                placeholder="SEO optimized title (max 60 chars)" maxlength="60"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="titleSpinner" class="absolute right-3 top-3 hidden">
                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta
                                Description:</label>
                            <button type="button" id="generateMetaDescription"
                                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition duration-200 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Generate
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="meta_description" id="meta_description"
                                placeholder="SEO optimized description (max 170 chars)" maxlength="170"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="descriptionSpinner" class="absolute right-3 top-3 hidden">
                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Extra Block -->
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="extra_block" class="block text-sm font-medium text-gray-700">Extra Content
                                Block:</label>
                            <button type="button" id="generateExtraBlock"
                                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition duration-200 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Generate
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="extra_block" id="extra_block"
                                placeholder="Additional content suggestion"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="extraBlockSpinner" class="absolute right-3 top-3 hidden">
                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <!-- Botón "Generar Vista Previa" -->
                <button id="generatePreviewBtn" type="button"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Generate Preview
                </button>

                <!-- Botón "Submit Blog Post" -->
                <button type="submit"
                    class="py-3 px-8 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition duration-200 inline-flex items-center justify-center text-base">
                    <div id="submitSpinner" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Submit Blog Post
                </button>
            </div>
        </form>
    </div>
</section>
