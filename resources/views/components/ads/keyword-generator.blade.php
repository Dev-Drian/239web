<div class="border border-gray-200 rounded-lg overflow-hidden mt-4">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />

    <!-- Empty state -->
    <div id="kw-waiting" class="py-4 px-4 bg-gray-50 flex items-center justify-center">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 mb-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-sm text-gray-500">Select a location to generate targeted keywords</p>
        </div>
    </div>

    <!-- Loader -->
    <div id="kw-loading" class="hidden py-4 px-4 bg-white">
        <div class="flex items-center justify-center">
            <div class="inline-block animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-blue-600 mr-2">
            </div>
            <p class="text-sm text-gray-600">Generating keywords...</p>
        </div>
    </div>

    <!-- Results container - will be filled dynamically -->
    <div id="kw-results" class="hidden p-3 bg-white"></div>

    <!-- Error message -->
    <div id="kw-error" class="hidden p-3 bg-red-50 text-red-600 text-sm border-l-4 border-red-500 rounded-r"></div>

    <!-- Custom keyword input section -->
    <div id="custom-keyword-section" class="p-3 bg-white border-t border-gray-200">
        <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Add Custom Keywords</h4>
        <div class="flex space-x-2">
            <div class="flex-1">
                <input type="text" id="custom-keyword-input" placeholder="Enter a custom keyword"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <select id="match-type"
                    class="px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="exact">Exact Match [...]</option>
                    <option value="phrase">Phrase Match "..."</option>
                </select>
            </div>
            <button type="button" id="add-custom-keyword"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Add
            </button>
        </div>

        <!-- Custom keywords display -->
        <div id="custom-keywords-container" class="hidden mt-3">
            <div id="custom-keywords-list" class="space-y-2">
                <!-- Custom keywords will appear here -->
            </div>
        </div>
    </div>

    <!-- Generate Keywords Button -->
    <div class="p-3 bg-gray-50 border-t border-gray-200">
        <button id="generate-keywords-btn" type="button"
            class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium disabled:bg-gray-400"
            disabled>
            Generate Keywords
        </button>
    </div>
</div>

<!-- Tip section -->
<div class="mt-2 flex items-start">
    <div class="text-blue-500 mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <p class="text-xs text-gray-500">Select keywords to target in your ad campaign. You can use our suggestions or add
        your own custom keywords. We recommend choosing a mix of exact match [keyword] and phrase match "keyword" types.
    </p>
</div>

<!-- Hidden fields -->
<input type="hidden" name="keywords" id="selected-keywords-input">
<input type="hidden" id="location-data" name="location_data">
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Initialize variables
            let customKeywordCounter = 0;
            let currentLocation = null;
            let currentTemplate = null;
            let keywordTemplates = {};

            // Global function to get selected keywords
            window.getSelectedKeywords = function() {
                const keywords = [];
                
                // Get generated keywords
                $('#kw-results input[type="checkbox"]:checked').each(function() {
                    const text = $(this).next('label').text().trim();
                    if (text) {
                        keywords.push({
                            text: text,
                            type: text.startsWith('[') ? 'exact' : 'phrase'
                        });
                    }
                });

                // Get custom keywords
                $('#custom-keywords-list input[type="checkbox"]:checked').each(function() {
                    const text = $(this).next('label').text().trim();
                    if (text) {
                        keywords.push({
                            text: text,
                            type: text.startsWith('[') ? 'exact' : 'phrase'
                        });
                    }
                });

                return keywords;
            };

            // Load keywords from JSON file
            $.getJSON('/js/keyword-ads.json', function(data) {
                keywordTemplates = data;
                // Get initial value of campaign_template
                currentTemplate = $('select[name="campaign_template"]').val();
                console.log('Initial template:', currentTemplate);
                console.log('Available keywords:', keywordTemplates);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading keywords:', textStatus, errorThrown);
            });

            // Listen for changes in template selector
            $('select[name="campaign_template"]').on('change', function() {
                currentTemplate = $(this).val();
                console.log('Template changed to:', currentTemplate);
            });

            // 2. Location selection handler
            window.handleLocationSelect = function(locationData) {
                currentLocation = locationData;
                document.getElementById('location-data').value = JSON.stringify(locationData);
                document.getElementById('generate-keywords-btn').disabled = false;
                $('#kw-waiting').addClass('hidden');
                $('#kw-results').addClass('hidden').empty();
                $('#kw-error').addClass('hidden');
            };

            // 3. Generate Keywords Button handler
            document.getElementById('generate-keywords-btn').addEventListener('click', function() {
                if (!currentLocation) {
                    showKeywordError("Please select a valid location first");
                    return;
                }
                if (!currentTemplate) {
                    showKeywordError("Please select a campaign template first");
                    return;
                }
                if (!keywordTemplates[currentTemplate] || keywordTemplates[currentTemplate].length === 0) {
                    showKeywordError("No keywords found for the selected template");
                    return;
                }
                fetchKeywords(currentLocation.city, currentLocation.state);
            });

            // 4. Function to fetch keywords based on location
            function fetchKeywords(city, state) {
                resetKeywordUI();

                $.ajax({
                    url: "{{ route('api.normalizeLocation') }}",
                    method: 'POST',
                    data: {
                        city,
                        state
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (!response?.success) {
                            showKeywordError(response.error || "Error processing location");
                            return;
                        }

                        // Generate keyword variations using the selected template's keywords
                        const keywords = generateKeywordVariations(response.normalized);
                        if (keywords.length === 0) {
                            showKeywordError("Could not generate keywords. Please check the selected template.");
                            return;
                        }
                        showKeywords(keywords);
                    },
                    error: function(xhr) {
                        showKeywordError("Error generating keywords. Please try again.");
                        console.error("Keyword API error:", xhr.responseText);
                    }
                });
            }

            // 5. Keyword generation logic
            function generateKeywordVariations(normalized) {
                // Get base keywords from the selected template
                const baseKeywords = keywordTemplates[currentTemplate] || [];
                console.log('Generating keywords for template:', currentTemplate);
                console.log('Base keywords:', baseKeywords);
                
                // Reduce combinations to just 2 city formats
                const formats = [
                    '[{keyword} {city}]',
                    '"{keyword} {city}"'
                ];

                const keywords = [];
                // Take only the first 10-15 keywords from the list
                const limitedKeywords = baseKeywords.slice(0, 15);
                
                limitedKeywords.forEach(kw => {
                    formats.forEach(fmt => {
                        let keyword = fmt
                            .replace('{keyword}', kw)
                            .replace('{city}', normalized.city);
                        keywords.push(keyword);
                    });
                });

                return keywords;
            }

            // 6. Display generated keywords
            function showKeywords(keywords) {
                if (!keywords?.length) {
                    showKeywordError("No keywords generated for this location");
                    return;
                }

                const $container = $('#kw-results').empty();
                $('#kw-loading').addClass('hidden');
                $('#kw-results').removeClass('hidden');

                // Group keywords by type
                const groupedKeywords = {
                    exact: [],
                    phrase: []
                };

                keywords.forEach(keyword => {
                    if (keyword.startsWith('[')) {
                        groupedKeywords.exact.push(keyword);
                    } else {
                        groupedKeywords.phrase.push(keyword);
                    }
                });

                // Create sections for each keyword type
                if (groupedKeywords.exact.length > 0) {
                    $container.append(`
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Exact Match</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                ${groupedKeywords.exact.map(keyword => createKeywordElement(keyword)).join('')}
                            </div>
                        </div>
                    `);
                }

                if (groupedKeywords.phrase.length > 0) {
                    $container.append(`
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Phrase Match</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                ${groupedKeywords.phrase.map(keyword => createKeywordElement(keyword)).join('')}
                            </div>
                        </div>
                    `);
                }

                // Add event to remove keywords
                $('.remove-keyword').on('click', function() {
                    $(this).closest('.keyword-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            }

            function createKeywordElement(keyword) {
                const keywordId = `kw-${customKeywordCounter++}`;
                return `
                    <div id="${keywordId}" class="keyword-item flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                        <div class="flex items-center flex-1">
                            <input type="checkbox" id="check-${keywordId}" checked 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <label for="check-${keywordId}" class="ml-3 text-sm text-gray-700 truncate">${keyword}</label>
                        </div>
                        <button type="button" class="remove-keyword text-gray-400 hover:text-red-500 ml-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
            }

            // 7. Custom keywords functionality
            $('#add-custom-keyword').on('click', addCustomKeyword);
            $('#custom-keyword-input').on('keypress', function(e) {
                if (e.which === 13) addCustomKeyword();
            });

            function addCustomKeyword() {
                const keyword = $('#custom-keyword-input').val().trim();
                const matchType = $('#match-type').val();

                if (!keyword) return;

                const formattedKeyword = matchType === 'exact' ? `[${keyword}]` : `"${keyword}"`;
                const keywordId = `custom-kw-${customKeywordCounter++}`;

                const keywordHTML = `
                    <div id="${keywordId}" class="keyword-item flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                        <div class="flex items-center flex-1">
                            <input type="checkbox" id="check-${keywordId}" checked 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <label for="check-${keywordId}" class="ml-3 text-sm text-gray-700 truncate">${formattedKeyword}</label>
                        </div>
                        <button type="button" class="remove-keyword text-gray-400 hover:text-red-500 ml-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;

                $('#custom-keywords-list').append(keywordHTML);
                $('#custom-keyword-input').val('').focus();
                $('#custom-keywords-container').removeClass('hidden');

                // Add event to remove keyword
                $(`#${keywordId} .remove-keyword`).on('click', function() {
                    $(this).closest('.keyword-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            }

            // 8. Helper functions
            function resetKeywordUI() {
                $('#kw-waiting').addClass('hidden');
                $('#kw-results').addClass('hidden').empty();
                $('#kw-error').addClass('hidden');
                $('#kw-loading').removeClass('hidden');
            }

            function showKeywordError(message) {
                $('#kw-loading').addClass('hidden');
                $('#kw-waiting').addClass('hidden');
                $('#kw-results').addClass('hidden');
                $('#kw-error').html(message).removeClass('hidden');
            }

            // 9. Form submission handler
            document.addEventListener('submit', function(e) {
                const keywordsSaved = saveKeywordsToForm();
                if (!keywordsSaved) {
                    e.preventDefault();
                    showKeywordError("Please select at least one keyword before submitting");
                }
            });

            function saveKeywordsToForm() {
                const selectedKeywords = collectSelectedKeywords();
                if (selectedKeywords.length === 0) return false;

                try {
                    document.getElementById('selected-keywords-input').value = JSON.stringify(selectedKeywords);
                    return true;
                } catch (error) {
                    console.error("Error saving keywords:", error);
                    return false;
                }
            }

            function collectSelectedKeywords() {
                const keywords = [];

                // Collect from suggested keywords
                $('#kw-results input[type="checkbox"]:checked').each(function() {
                    const text = $(this).next('label').text().trim();
                    if (text) {
                        keywords.push({
                            text: text,
                            type: text.startsWith('[') ? 'exact' : 'phrase'
                        });
                    }
                });

                // Collect from custom keywords
                $('#custom-keywords-list input[type="checkbox"]:checked').each(function() {
                    const text = $(this).next('label').text().trim();
                    if (text) {
                        keywords.push({
                            text: text,
                            type: text.startsWith('[') ? 'exact' : 'phrase'
                        });
                    }
                });

                return keywords;
            }
        });
    </script>
@endpush