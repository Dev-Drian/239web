<div class="glass-dark border border-white/15 rounded-2xl overflow-hidden mt-4 shadow-2xl backdrop-blur-xl">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    
    <!-- Enhanced empty state -->
    <div id="kw-waiting" class="py-8 px-6 glass bg-slate-800/30 flex items-center justify-center">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center ring-2 ring-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-sm text-slate-400">Select a location to generate targeted keywords</p>
        </div>
    </div>
    
    <!-- Enhanced loader -->
    <div id="kw-loading" class="hidden py-8 px-6 glass bg-slate-800/30">
        <div class="flex items-center justify-center">
            <div class="relative">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mr-4"></div>
                <div class="absolute inset-0 rounded-full border-2 border-blue-500/20"></div>
            </div>
            <div>
                <p class="text-sm text-white font-medium">Generating keywords...</p>
                <p class="text-xs text-slate-400">This may take a few seconds</p>
            </div>
        </div>
    </div>
    
    <!-- Enhanced results container -->
    <div id="kw-results" class="hidden p-6 glass bg-slate-800/30"></div>
    
    <!-- Enhanced error message -->
    <div id="kw-error" class="hidden p-6 glass bg-red-500/10 text-red-300 text-sm border-l-4 border-red-500 rounded-r-2xl backdrop-blur-xl"></div>
    
    <!-- Enhanced custom keyword input section -->
    <div id="custom-keyword-section" class="p-6 glass bg-slate-800/30 border-t border-white/10">
        <h4 class="text-sm font-semibold text-slate-300 uppercase mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Custom Keywords
        </h4>
        <div class="flex space-x-3">
            <div class="flex-1">
                <input type="text" id="custom-keyword-input" placeholder="Enter a custom keyword"
                    class="w-full px-4 py-3 text-sm glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 text-white placeholder-slate-400 bg-transparent backdrop-blur-xl transition-all duration-300">
            </div>
            <div>
                <select id="match-type"
                    class="px-4 py-3 text-sm glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 text-white bg-transparent backdrop-blur-xl appearance-none">
                    <option value="exact" class="bg-slate-800 text-white">Exact Match [...]</option>
                    <option value="phrase" class="bg-slate-800 text-white">Phrase Match "..."</option>
                </select>
            </div>
            <button type="button" id="add-custom-keyword"
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl hover:from-purple-600 hover:to-pink-600 text-sm font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Add
            </button>
        </div>
        
        <!-- Enhanced custom keywords display -->
        <div id="custom-keywords-container" class="hidden mt-6">
            <div id="custom-keywords-list" class="space-y-3">
                <!-- Custom keywords will appear here -->
            </div>
        </div>
    </div>
    
    <!-- Enhanced Generate Keywords Button -->
    <div class="p-6 glass bg-slate-800/30 border-t border-white/10">
        <button id="generate-keywords-btn" type="button"
            class="w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-2xl hover:from-emerald-600 hover:to-green-600 text-sm font-semibold disabled:from-gray-600 disabled:to-gray-700 disabled:cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:transform-none flex items-center justify-center"
            disabled>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Generate Keywords
        </button>
    </div>
</div>

<!-- Enhanced tip section -->
<div class="mt-4 flex items-start glass-dark p-4 rounded-2xl border border-blue-500/30 backdrop-blur-xl">
    <div class="text-blue-400 mr-3 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
    </div>
    <div>
        <p class="text-sm font-medium text-blue-300 mb-1">💡 Keyword Strategy Tip</p>
        <p class="text-xs text-slate-400">Select keywords to target in your ad campaign. You can use our suggestions or add your own custom keywords. We recommend choosing a mix of exact match [keyword] and phrase match "keyword" types for optimal performance.</p>
    </div>
</div>

<!-- Hidden fields -->
<input type="hidden" name="keywords" id="selected-keywords-input">
<input type="hidden" id="location-data" name="location_data">

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // All existing JavaScript functionality remains exactly the same
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

            // Location selection handler
            window.handleLocationSelect = function(locationData) {
                currentLocation = locationData;
                document.getElementById('location-data').value = JSON.stringify(locationData);
                document.getElementById('generate-keywords-btn').disabled = false;
                $('#kw-waiting').addClass('hidden');
                $('#kw-results').addClass('hidden').empty();
                $('#kw-error').addClass('hidden');
            };

            // Generate Keywords Button handler
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

            // Function to fetch keywords based on location
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

            // Keyword generation logic
            function generateKeywordVariations(normalized) {
                const baseKeywords = keywordTemplates[currentTemplate] || [];
                console.log('Generating keywords for template:', currentTemplate);
                console.log('Base keywords:', baseKeywords);
                
                const formats = [
                    '[{keyword} {city}]',
                    '"{keyword} {city}"'
                ];
                const keywords = [];
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

            // Display generated keywords with enhanced dark theme styling
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

                // Create sections for each keyword type with enhanced styling
                if (groupedKeywords.exact.length > 0) {
                    $container.append(`
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-blue-300 mb-4 flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                Exact Match Keywords
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                ${groupedKeywords.exact.map(keyword => createKeywordElement(keyword)).join('')}
                            </div>
                        </div>
                    `);
                }

                if (groupedKeywords.phrase.length > 0) {
                    $container.append(`
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-purple-300 mb-4 flex items-center">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                Phrase Match Keywords
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
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
                const isExact = keyword.startsWith('[');
                const colorClass = isExact ? 'border-blue-400/30 hover:border-blue-400/50' : 'border-purple-400/30 hover:border-purple-400/50';
                
                return `
                    <div id="${keywordId}" class="keyword-item flex items-center justify-between glass p-4 rounded-2xl border ${colorClass} hover:shadow-lg transition-all duration-300 backdrop-blur-xl">
                        <div class="flex items-center flex-1">
                            <input type="checkbox" id="check-${keywordId}" checked
                                 class="h-4 w-4 text-${isExact ? 'blue' : 'purple'}-500 focus:ring-${isExact ? 'blue' : 'purple'}-500/50 rounded border-white/20 bg-transparent">
                            <label for="check-${keywordId}" class="ml-3 text-sm text-white truncate font-medium">${keyword}</label>
                        </div>
                        <button type="button" class="remove-keyword text-slate-400 hover:text-red-400 ml-3 transition-colors duration-300 p-1 rounded-full hover:bg-red-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
            }

            // Custom keywords functionality
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
                const isExact = matchType === 'exact';
                const colorClass = isExact ? 'border-blue-400/30 hover:border-blue-400/50' : 'border-purple-400/30 hover:border-purple-400/50';

                const keywordHTML = `
                    <div id="${keywordId}" class="keyword-item flex items-center justify-between glass p-4 rounded-2xl border ${colorClass} hover:shadow-lg transition-all duration-300 backdrop-blur-xl">
                        <div class="flex items-center flex-1">
                            <input type="checkbox" id="check-${keywordId}" checked
                                 class="h-4 w-4 text-${isExact ? 'blue' : 'purple'}-500 focus:ring-${isExact ? 'blue' : 'purple'}-500/50 rounded border-white/20 bg-transparent">
                            <label for="check-${keywordId}" class="ml-3 text-sm text-white truncate font-medium">${formattedKeyword}</label>
                        </div>
                        <button type="button" class="remove-keyword text-slate-400 hover:text-red-400 ml-3 transition-colors duration-300 p-1 rounded-full hover:bg-red-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
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

            // Helper functions
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
                $('#kw-error').html(`
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ${message}
                    </div>
                `).removeClass('hidden');
            }

            // Form submission handler
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
