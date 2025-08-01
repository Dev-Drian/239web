<div class="mb-6">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    <input type="hidden" name="generated_ads" id="generated-ads-input">

    <!-- Ad Generation Container -->
    <div class="mb-5 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button id="generate-ads-btn" type="button"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors font-medium flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Generate 2 AI Ads
                </button>

                <div class="text-sm text-gray-500 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Will use your location and keywords to create ads
                </div>
            </div>
        </div>

        <!-- Status Messages -->
        <div id="status-container" class="hidden">
            <!-- Loading State -->
            <div id="ads-loading" class=" p-8 flex flex-col items-center justify-center">
                <div class="flex items-center justify-center mb-3">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
                <p class="text-base text-gray-600">Generating your ads...</p>
                <p class="text-sm text-gray-500 mt-1">This may take a few moments</p>
            </div>

            <!-- Error State -->
            <div id="ads-error" class="hidden p-6 bg-red-50 text-center"></div>

            <!-- Success Message -->
            <div id="ads-success" class="hidden p-4 bg-green-50 text-center text-green-600 border-b border-green-100">
            </div>
        </div>

        <!-- Results Grid -->
        <div id="ads-results-wrapper" class="hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800">Generated Ads</h3>
                <p class="text-sm text-gray-500 mt-1">Click on any ad to edit it</p>
            </div>
            <div id="ads-results" class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-100 min-h-fit"></div>
        </div>
    </div>

    <!-- Ad Editor Panel -->
    <div id="ad-editor" class="hidden mb-5 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <!-- Editor content will be inserted here -->
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const generateBtn = document.getElementById('generate-ads-btn');
            const statusContainer = document.getElementById('status-container');
            const loadingElement = document.getElementById('ads-loading');
            const errorElement = document.getElementById('ads-error');
            const successElement = document.getElementById('ads-success');
            const resultsWrapper = document.getElementById('ads-results-wrapper');
            const resultsElement = document.getElementById('ads-results');
            const editorElement = document.getElementById('ad-editor');
            const generatedAdsInput = document.getElementById('generated-ads-input');
            const final_url = @json($client->website);




            // State management
            let currentAds = [];
            let currentlyEditingIndex = null;
            let isGenerating = false;

            // Event listeners
            generateBtn.addEventListener('click', generateAds);

            // Generate ads function
            async function generateAds() {
                if (isGenerating) return;
                isGenerating = true;

                try {
                    const selectedLocation = $('#location').select2('data')[0];
                    const selectedKeywords = getSelectedKeywords();

                    // Validate inputs
                    if (!selectedLocation) {
                        showError('Please select a location');
                        return;
                    }

                    if (!selectedKeywords || selectedKeywords.length === 0) {
                        showError('Please select at least one keyword');
                        return;
                    }

                    // Reset and show loading state
                    resetUI();
                    showLoading();

                    // Make API request
                    const response = await fetch('{{ route('generate.ads') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            city: selectedLocation.city,
                            state: selectedLocation.state,
                            base_title: document.querySelector('[name="campaign_template"]')
                                .value,
                            base_content: document.querySelector('[name="campaign_template"]')
                                .value,
                            keywords: selectedKeywords,
                            count: 2,
                            service_type: document.querySelector('[name="campaign_template"]')
                                .value,
                            final_url: final_url
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.error || 'Error generating ads');
                    }

                    // Validate we got exactly 2 ads
                    if (!Array.isArray(data.ads) || data.ads.length !== 2) {
                        throw new Error('Exactly 2 ads were expected');
                    }

                    // Process ads with validation
                    currentAds = data.ads.map((ad, index) => {
                        // Validate structure
                        if (!ad.headlines || ad.headlines.length < 3 || ad.headlines.length > 15) {
                            throw new Error(`Ad ${index + 1} must have between 3–15 headlines`);
                        }

                        if (!ad.descriptions || ad.descriptions.length < 2 || ad.descriptions.length >
                            4) {
                            throw new Error(`Ad ${index + 1} must have between 2–4 descriptions`);
                        }

                        // Validate pinned fields
                        const pinnedHeadlines = ad.headlines.filter(h => h.pinned_field ===
                            'HEADLINE_1');
                        if (pinnedHeadlines.length !== 1) {
                            throw new Error(
                                `Ad ${index + 1} must have exactly 1 pinned headline as HEADLINE_1`);
                        }

                        const pinnedDescriptions = ad.descriptions.filter(d => d.pinned_field ===
                            'DESCRIPTION_1');
                        if (pinnedDescriptions.length !== 1) {
                            throw new Error(
                                `Ad ${index + 1} must have exactly 1 pinned description as DESCRIPTION_1`
                            );
                        }

                        return {
                            headlines: ad.headlines,
                            descriptions: ad.descriptions,
                            path1: ad.path1 || 'service',
                            path2: ad.path2 || 'executive',
                            final_url: ad.final_url || generateFinalUrl(selectedLocation.city)
                        };
                    });

                    saveAdsToForm();
                    displayAds();
                    showSuccess(`2 ads were successfully generated for ${selectedLocation.city}`);

                } catch (error) {
                    console.error('Error:', error);
                    showError(`Error generating ads: ${error.message}`);
                } finally {
                    hideLoading();
                    isGenerating = false;
                }
            }

            // Display generated ads
            // Display generated ads
            function displayAds() {
                resultsElement.innerHTML = '';
                resultsWrapper.classList.remove('hidden');

                currentAds.forEach((ad, index) => {
                    const mainHeadline = ad.headlines.find(h => h.pinned_field === 'HEADLINE_1')?.text || ad
                        .headlines[0].text;
                    const mainDescription = ad.descriptions.find(d => d.pinned_field === 'DESCRIPTION_1')
                        ?.text || ad.descriptions[0].text;
                    const secondDescription = ad.descriptions.length > 1 ? ad.descriptions.find(d => !d
                        .pinned_field)?.text || '' : '';

                    const adCard = document.createElement('div');
                    adCard.className =
                        'bg-white rounded-xl shadow-md border border-gray-200 transition hover:shadow-lg';
                    adCard.dataset.index = index;

                    adCard.innerHTML = `
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-semibold text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full">Ad #${index + 1}</span>
                    <button type="button" class="text-gray-500 hover:text-indigo-600 p-2 edit-ad" data-index="${index}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 
                                112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>

                <div class="ad-preview">
                    <div class="text-sm text-green-600">
                        ${ad.final_url.replace(/^https?:\/\//, '')}
                    </div>
                    <div class="text-sm text-green-600 mb-2">
                        ${ad.path1} › ${ad.path2}
                    </div>
                    
                    <h3 class="text-lg font-semibold text-blue-700 hover:underline cursor-pointer mb-1">
                        ${mainHeadline}
                    </h3>

                    <p class="text-sm text-gray-700">
                        ${mainDescription} ${secondDescription}
                    </p>
                </div>
            </div>

            <div class="p-4 bg-gray-50">
                <p class="text-xs font-semibold text-gray-500 mb-2">Additional Titles:</p>
                <ul class="space-y-1 text-sm text-gray-600">
                    ${ad.headlines.slice(1, 4).map(h => `<li>${h.text}</li>`).join('')}
                    ${ad.headlines.length > 4 ? `<li class="text-blue-600">+${ad.headlines.length - 4} more</li>` : ''}
                </ul>
            </div>
        `;

                    adCard.addEventListener('click', (e) => {
                        if (!e.target.closest('.edit-ad')) {
                            editAd(index);
                        }
                    });

                    const editBtn = adCard.querySelector('.edit-ad');
                    if (editBtn) {
                        editBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            editAd(index);
                        });
                    }

                    resultsElement.appendChild(adCard);
                });
            }



            // Edit ad function
            function editAd(index) {
                currentlyEditingIndex = index;
                const ad = currentAds[index];

                editorElement.classList.remove('hidden');
                editorElement.innerHTML = `
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-medium text-gray-800">Edit Ad #${index + 1}</h3>
                <button type="button" id="close-editor-btn" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Preview</h4>
                <div id="live-preview" class="ad-preview"></div>
            </div>
            
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="mr-2">
                        <button type="button" class="editor-tab active inline-block p-4 border-b-2 border-blue-600 text-blue-600" 
                            data-tab="headlines">Headlines</button>
                    </li>
                    <li class="mr-2">
                        <button type="button" class="editor-tab inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" 
                            data-tab="descriptions">Descriptions</button>
                    </li>
                    <li>
                        <button type="button" class="editor-tab inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" 
                            data-tab="urls">URLs</button>
                    </li>
                </ul>
            </div>
            
            <div class="tab-content" id="headlines-tab">
                <div class="mb-4 flex justify-between items-center">
                    <h4 class="text-sm font-medium text-gray-700">Headlines (${ad.headlines.length}/15)</h4>
                    <button type="button" id="add-headline-btn" class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1.5 rounded hover:bg-blue-100 flex items-center">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Headline
                    </button>
                </div>
                <div class="space-y-3" id="headlines-editor">
                    ${ad.headlines.map((headline, i) => `
                                <div class="flex items-center gap-2 headline-item group">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <span class="text-xs font-medium text-gray-500 mr-2">Headline ${i + 1}</span>
                                            ${headline.pinned_field === 'HEADLINE_1' ? 
                                                `<span class="text-xs bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded">Primary</span>` : ''}
                                        </div>
                                        <div class="flex">
                                            <input type="text" 
                                                value="${headline.text}"
                                                class="flex-1 p-2 border rounded-l-md text-sm headline-input" 
                                                maxlength="30"
                                                data-index="${i}"
                                                placeholder="Headline text">
                                            <div class="flex items-center">
                                                <select class="text-sm border-t border-b border-r border-l-0 p-2 headline-pin" data-index="${i}">
                                                    <option value="">Not pinned</option>
                                                    <option value="HEADLINE_1" ${headline.pinned_field === 'HEADLINE_1' ? 'selected' : ''}>
                                                        Primary headline
                                                    </option>
                                                </select>
                                                <button type="button" class="delete-headline p-2 border-t border-b border-r rounded-r-md text-gray-400 hover:text-red-500 ${ad.headlines.length <= 3 ? 'opacity-50 cursor-not-allowed' : ''}" 
                                                    data-index="${i}" ${ad.headlines.length <= 3 ? 'disabled' : ''}>
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-1">
                                            <span class="text-xs text-gray-500 headline-counter">${headline.text.length}/30</span>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                </div>
            </div>
            
            <div class="tab-content hidden" id="descriptions-tab">
                <div class="mb-4 flex justify-between items-center">
                    <h4 class="text-sm font-medium text-gray-700">Descriptions (${ad.descriptions.length}/4)</h4>
                    <button type="button" id="add-description-btn" class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1.5 rounded hover:bg-blue-100 flex items-center">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Description
                    </button>
                </div>
                <div class="space-y-3" id="descriptions-editor">
                    ${ad.descriptions.map((desc, i) => `
                                <div class="flex items-center gap-2 description-item group">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <span class="text-xs font-medium text-gray-500 mr-2">Description ${i + 1}</span>
                                            ${desc.pinned_field === 'DESCRIPTION_1' ? 
                                                `<span class="text-xs bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded">Primary</span>` : ''}
                                        </div>
                                        <div class="flex">
                                            <input type="text" 
                                                value="${desc.text}"
                                                class="flex-1 p-2 border rounded-l-md text-sm description-input" 
                                                maxlength="90"
                                                data-index="${i}"
                                                placeholder="Description text">
                                            <div class="flex items-center">
                                                <select class="text-sm border-t border-b border-r border-l-0 p-2 description-pin" data-index="${i}">
                                                    <option value="">Not pinned</option>
                                                    <option value="DESCRIPTION_1" ${desc.pinned_field === 'DESCRIPTION_1' ? 'selected' : ''}>
                                                        Primary description
                                                    </option>
                                                </select>
                                                <button type="button" class="delete-description p-2 border-t border-b border-r rounded-r-md text-gray-400 hover:text-red-500 ${ad.descriptions.length <= 2 ? 'opacity-50 cursor-not-allowed' : ''}" 
                                                    data-index="${i}" ${ad.descriptions.length <= 2 ? 'disabled' : ''}>
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-1">
                                            <span class="text-xs text-gray-500 description-counter">${desc.text.length}/90</span>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                </div>
            </div>
            
            <div class="tab-content hidden" id="urls-tab">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Paths</label>
                    <p class="text-xs text-gray-500 mb-3">Appears in the ad but is not part of the actual URL</p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Path 1</label>
                            <input type="text" 
                                value="${ad.path1}" 
                                id="edit-path1" 
                                class="w-full p-2 border rounded-md text-sm" 
                                maxlength="15">
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Max. 15 characters</span>
                                <span class="text-xs text-gray-500 path1-counter">${ad.path1.length}/15</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Path 2</label>
                            <input type="text" 
                                value="${ad.path2}" 
                                id="edit-path2" 
                                class="w-full p-2 border rounded-md text-sm" 
                                maxlength="15">
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Max. 15 characters</span>
                                <span class="text-xs text-gray-500 path2-counter">${ad.path2.length}/15</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Final URL</label>
                        <input type="url" 
                            value="${ad.final_url}" 
                            id="edit-url" 
                            class="w-full p-2 border rounded-md text-sm">
                        <p class="text-xs text-gray-500 mt-1">Where customers will go when they click</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" id="cancel-edit-btn"
                    class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="save-edit-btn"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    Save Changes
                </button>
            </div>
        </div>
    `;

                setupEditorEvents();
                updateLivePreview();
                scrollToEditor();
            }

            // Setup editor event listeners
            function setupEditorEvents() {
                // Tab switching
                editorElement.querySelectorAll('.editor-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        editorElement.querySelectorAll('.editor-tab').forEach(t => {
                            t.classList.remove('active', 'border-blue-600',
                                'text-blue-600');
                            t.classList.add('border-transparent');
                        });

                        this.classList.add('active', 'border-blue-600', 'text-blue-600');
                        this.classList.remove('border-transparent');

                        editorElement.querySelectorAll('.tab-content').forEach(content => {
                            content.classList.add('hidden');
                        });

                        const tabId = this.getAttribute('data-tab');
                        document.getElementById(`${tabId}-tab`).classList.remove('hidden');
                    });
                });

                // Input character counters
                editorElement.querySelectorAll('.headline-input').forEach(input => {
                    input.addEventListener('input', function() {
                        const counter = this.closest('.headline-item').querySelector(
                            '.headline-counter');
                        counter.textContent = `${this.value.length}/30`;
                        counter.classList.toggle('text-red-500', this.value.length > 30);
                        updateLivePreview();
                    });
                });

                editorElement.querySelectorAll('.description-input').forEach(input => {
                    input.addEventListener('input', function() {
                        const counter = this.closest('.description-item').querySelector(
                            '.description-counter');
                        counter.textContent = `${this.value.length}/90`;
                        counter.classList.toggle('text-red-500', this.value.length > 90);
                        updateLivePreview();
                    });
                });

                // Path input counters
                const path1Input = document.getElementById('edit-path1');
                const path2Input = document.getElementById('edit-path2');
                const path1Counter = editorElement.querySelector('.path1-counter');
                const path2Counter = editorElement.querySelector('.path2-counter');

                path1Input.addEventListener('input', function() {
                    path1Counter.textContent = `${this.value.length}/15`;
                    path1Counter.classList.toggle('text-red-500', this.value.length > 15);
                    updateLivePreview();
                });

                path2Input.addEventListener('input', function() {
                    path2Counter.textContent = `${this.value.length}/15`;
                    path2Counter.classList.toggle('text-red-500', this.value.length > 15);
                    updateLivePreview();
                });

                // Pin field changes
                editorElement.querySelectorAll('.headline-pin, .description-pin').forEach(select => {
                    select.addEventListener('change', function() {
                        // Ensure only one headline is pinned as HEADLINE_1
                        if (this.value === 'HEADLINE_1') {
                            editorElement.querySelectorAll('.headline-pin').forEach(otherSelect => {
                                if (otherSelect !== this && otherSelect.value ===
                                    'HEADLINE_1') {
                                    otherSelect.value = '';
                                }
                            });
                        }
                        // Ensure only one description is pinned as DESCRIPTION_1
                        if (this.value === 'DESCRIPTION_1') {
                            editorElement.querySelectorAll('.description-pin').forEach(
                                otherSelect => {
                                    if (otherSelect !== this && otherSelect.value ===
                                        'DESCRIPTION_1') {
                                        otherSelect.value = '';
                                    }
                                });
                        }
                        updateLivePreview();
                    });
                });

                // Add headline button
                document.getElementById('add-headline-btn')?.addEventListener('click', () => {
                    const headlinesContainer = document.getElementById('headlines-editor');
                    if (headlinesContainer.children.length >= 15) {
                        showError('Maximum 15 headlines allowed');
                        return;
                    }

                    const newHeadline = document.createElement('div');
                    newHeadline.className = 'flex items-center gap-2 headline-item group';
                    newHeadline.innerHTML = `
            <div class="flex-1">
                <div class="flex items-center mb-1">
                    <span class="text-xs font-medium text-gray-500 mr-2">Headline ${headlinesContainer.children.length + 1}</span>
                </div>
                <div class="flex">
                    <input type="text" 
                        value=""
                        class="flex-1 p-2 border rounded-l-md text-sm headline-input" 
                        maxlength="30"
                        data-index="${headlinesContainer.children.length}"
                        placeholder="Headline text">
                    <div class="flex items-center">
                        <select class="text-sm border-t border-b border-r border-l-0 p-2 headline-pin" data-index="${headlinesContainer.children.length}">
                            <option value="">Not pinned</option>
                            <option value="HEADLINE_1">Primary headline</option>
                        </select>
                        <button type="button" class="delete-headline p-2 border-t border-b border-r rounded-r-md text-gray-400 hover:text-red-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-end mt-1">
                    <span class="text-xs text-gray-500 headline-counter">0/30</span>
                </div>
            </div>
        `;

                    headlinesContainer.appendChild(newHeadline);
                    setupHeadlineEvents(newHeadline);
                });

                // Add description button
                document.getElementById('add-description-btn')?.addEventListener('click', () => {
                    const descriptionsContainer = document.getElementById('descriptions-editor');
                    if (descriptionsContainer.children.length >= 4) {
                        showError('Maximum 4 descriptions allowed');
                        return;
                    }

                    const newDescription = document.createElement('div');
                    newDescription.className = 'flex items-center gap-2 description-item group';
                    newDescription.innerHTML = `
            <div class="flex-1">
                <div class="flex items-center mb-1">
                    <span class="text-xs font-medium text-gray-500 mr-2">Description ${descriptionsContainer.children.length + 1}</span>
                </div>
                <div class="flex">
                    <input type="text" 
                        value=""
                        class="flex-1 p-2 border rounded-l-md text-sm description-input" 
                        maxlength="90"
                        data-index="${descriptionsContainer.children.length}"
                        placeholder="Description text">
                    <div class="flex items-center">
                        <select class="text-sm border-t border-b border-r border-l-0 p-2 description-pin" data-index="${descriptionsContainer.children.length}">
                            <option value="">Not pinned</option>
                            <option value="DESCRIPTION_1">Primary description</option>
                        </select>
                        <button type="button" class="delete-description p-2 border-t border-b border-r rounded-r-md text-gray-400 hover:text-red-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-end mt-1">
                    <span class="text-xs text-gray-500 description-counter">0/90</span>
                </div>
            </div>
        `;

                    descriptionsContainer.appendChild(newDescription);
                    setupDescriptionEvents(newDescription);
                });

                // Delete headline button
                editorElement.querySelectorAll('.delete-headline').forEach(btn => {
                    if (!btn.disabled) {
                        btn.addEventListener('click', function() {
                            const headlinesContainer = document.getElementById('headlines-editor');
                            if (headlinesContainer.children.length > 3) {
                                this.closest('.headline-item').remove();
                                updateHeadlineNumbers();
                                updateLivePreview();
                            }
                        });
                    }
                });

                // Delete description button
                editorElement.querySelectorAll('.delete-description').forEach(btn => {
                    if (!btn.disabled) {
                        btn.addEventListener('click', function() {
                            const descriptionsContainer = document.getElementById(
                                'descriptions-editor');
                            if (descriptionsContainer.children.length > 2) {
                                this.closest('.description-item').remove();
                                updateDescriptionNumbers();
                                updateLivePreview();
                            }
                        });
                    }
                });

                // Save and cancel buttons
                document.getElementById('save-edit-btn').addEventListener('click', saveEditedAd);
                document.getElementById('cancel-edit-btn').addEventListener('click', cancelEditing);
                document.getElementById('close-editor-btn').addEventListener('click', cancelEditing);
            }

            // Setup events for dynamically added headlines
            function setupHeadlineEvents(headlineElement) {
                const input = headlineElement.querySelector('.headline-input');
                const counter = headlineElement.querySelector('.headline-counter');
                const deleteBtn = headlineElement.querySelector('.delete-headline');
                const pinSelect = headlineElement.querySelector('.headline-pin');

                input.addEventListener('input', function() {
                    counter.textContent = `${this.value.length}/30`;
                    counter.classList.toggle('text-red-500', this.value.length > 30);
                    updateLivePreview();
                });

                deleteBtn.addEventListener('click', function() {
                    const headlinesContainer = document.getElementById('headlines-editor');
                    if (headlinesContainer.children.length > 3) {
                        headlineElement.remove();
                        updateHeadlineNumbers();
                        updateLivePreview();
                    }
                });

                pinSelect.addEventListener('change', function() {
                    if (this.value === 'HEADLINE_1') {
                        document.querySelectorAll('.headline-pin').forEach(select => {
                            if (select !== this && select.value === 'HEADLINE_1') {
                                select.value = '';
                            }
                        });
                    }
                    updateLivePreview();
                });
            }
            // Setup events for dynamically added descriptions
            function setupDescriptionEvents(descriptionElement) {
                const input = descriptionElement.querySelector('.description-input');
                const counter = descriptionElement.querySelector('.description-counter');
                const deleteBtn = descriptionElement.querySelector('.delete-description');
                const pinSelect = descriptionElement.querySelector('.description-pin');

                input.addEventListener('input', function() {
                    counter.textContent = `${this.value.length}/90`;
                    counter.classList.toggle('text-red-500', this.value.length > 90);
                    updateLivePreview();
                });

                deleteBtn.addEventListener('click', function() {
                    const descriptionsContainer = document.getElementById('descriptions-editor');
                    if (descriptionsContainer.children.length > 2) {
                        descriptionElement.remove();
                        updateDescriptionNumbers();
                        updateLivePreview();
                    }
                });

                pinSelect.addEventListener('change', function() {
                    if (this.value === 'DESCRIPTION_1') {
                        document.querySelectorAll('.description-pin').forEach(select => {
                            if (select !== this && select.value === 'DESCRIPTION_1') {
                                select.value = '';
                            }
                        });
                    }
                    updateLivePreview();
                });
            }

            // Update headline numbers after deletion
            function updateHeadlineNumbers() {
                const headlines = document.querySelectorAll('.headline-item');
                headlines.forEach((headline, index) => {
                    const label = headline.querySelector('.text-xs.font-medium.text-gray-500');
                    if (label) {
                        label.textContent = `Headline ${index + 1}`;
                    }
                    const input = headline.querySelector('.headline-input');
                    if (input) {
                        input.setAttribute('data-index', index);
                    }
                    const select = headline.querySelector('.headline-pin');
                    if (select) {
                        select.setAttribute('data-index', index);
                    }
                });
            }

            // Update description numbers after deletion
            function updateDescriptionNumbers() {
                const descriptions = document.querySelectorAll('.description-item');
                descriptions.forEach((description, index) => {
                    const label = description.querySelector('.text-xs.font-medium.text-gray-500');
                    if (label) {
                        label.textContent = `Description ${index + 1}`;
                    }
                    const input = description.querySelector('.description-input');
                    if (input) {
                        input.setAttribute('data-index', index);
                    }
                    const select = description.querySelector('.description-pin');
                    if (select) {
                        select.setAttribute('data-index', index);
                    }
                });
            }

            // Update live preview
            function updateLivePreview() {
                const previewElement = document.getElementById('live-preview');
                if (!previewElement) return;

                const headlines = Array.from(document.querySelectorAll('.headline-input')).map((input, i) => ({
                    text: input.value,
                    pinned_field: document.querySelectorAll('.headline-pin')[i].value
                }));

                const descriptions = Array.from(document.querySelectorAll('.description-input')).map((input, i) =>
                    ({
                        text: input.value,
                        pinned_field: document.querySelectorAll('.description-pin')[i].value
                    }));

                const path1 = document.getElementById('edit-path1').value;
                const path2 = document.getElementById('edit-path2').value;
                const finalUrl = document.getElementById('edit-url').value;

                const mainHeadline = headlines.find(h => h.pinned_field === 'HEADLINE_1')?.text || headlines[0]
                    ?.text || '';
                const mainDescription = descriptions.find(d => d.pinned_field === 'DESCRIPTION_1')?.text ||
                    descriptions[0]?.text || '';
                const secondDescription = descriptions.find(d => !d.pinned_field)?.text || '';

                previewElement.innerHTML = `
        <div class="text-xs text-green-700 mb-1">
            ${finalUrl.replace(/^https?:\/\//, '')}
        </div>
        <div class="text-xs text-green-700 mb-2">
            ${path1} › ${path2}
        </div>
        <h4 class="text-[#1a0dab] text-base font-medium mb-1 hover:underline cursor-pointer">
            ${mainHeadline}
        </h4>
        <p class="text-sm text-gray-600 leading-snug">
            ${mainDescription} ${secondDescription}
        </p>
    `;
            }

            // Save edited ad
            function saveEditedAd() {
                if (currentlyEditingIndex === null || currentlyEditingIndex === undefined) {
                    console.error('No ad selected for editing');
                    showError('No ad selected for editing');
                    return;
                }

                try {
                    // Get all headlines
                    const headlineInputs = Array.from(document.querySelectorAll('.headline-input'));
                    const headlinePins = Array.from(document.querySelectorAll('.headline-pin'));

                    const headlines = headlineInputs.map((input, i) => ({
                        text: input.value.trim(),
                        pinned_field: headlinePins[i].value
                    }));

                    // Get all descriptions
                    const descriptionInputs = Array.from(document.querySelectorAll('.description-input'));
                    const descriptionPins = Array.from(document.querySelectorAll('.description-pin'));

                    const descriptions = descriptionInputs.map((input, i) => ({
                        text: input.value.trim(),
                        pinned_field: descriptionPins[i].value
                    }));

                    // Validations
                    const pinnedHeadlines = headlines.filter(h => h.pinned_field === 'HEADLINE_1');
                    if (pinnedHeadlines.length !== 1) {
                        throw new Error('There must be exactly 1 headline marked as primary');
                    }

                    const pinnedDescriptions = descriptions.filter(d => d.pinned_field === 'DESCRIPTION_1');
                    if (pinnedDescriptions.length !== 1) {
                        throw new Error('There must be exactly 1 description marked as primary');
                    }

                    // Get paths and URL
                    const path1 = document.getElementById('edit-path1').value.trim();
                    const path2 = document.getElementById('edit-path2').value.trim();
                    const finalUrl = document.getElementById('edit-url').value.trim();

                    if (!path1 || !path2) {
                        throw new Error('Both paths are required');
                    }

                    if (path1.length > 15 || path2.length > 15) {
                        throw new Error('Paths cannot exceed 15 characters');
                    }

                    if (!finalUrl || !isValidUrl(finalUrl)) {
                        throw new Error('Invalid final URL');
                    }

                    // Update the ad
                    currentAds[currentlyEditingIndex] = {
                        headlines,
                        descriptions,
                        path1,
                        path2,
                        final_url: finalUrl
                    };

                    // Save and update view
                    saveAdsToForm();
                    displayAds();
                    cancelEditing();
                    showSuccess('Ad updated successfully');

                } catch (error) {
                    console.error('Error saving:', error);
                    showError(error.message);
                }
            }

            // Helper function to validate URLs
            function isValidUrl(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }

            // Helper functions
            function resetUI() {
                errorElement.classList.add('hidden');
                successElement.classList.add('hidden');
                resultsWrapper.classList.add('hidden');
                editorElement.classList.add('hidden');
                resultsElement.innerHTML = '';
            }

            function showLoading() {
                statusContainer.classList.remove('hidden');
                loadingElement.classList.remove('hidden');
            }

            function hideLoading() {
                loadingElement.classList.add('hidden');
            }

            function showError(message) {
                errorElement.innerHTML = `
        <div class="flex items-center justify-center mb-2">
            <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <p class="text-base font-medium">${message}</p>
    `;
                errorElement.classList.remove('hidden');
                statusContainer.classList.remove('hidden');
            }

            function showSuccess(message) {
                successElement.textContent = message;
                successElement.classList.remove('hidden');
                statusContainer.classList.remove('hidden');

                setTimeout(() => {
                    successElement.classList.add('hidden');
                }, 3000);
            }

            function scrollToEditor() {
                editorElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            function cancelEditing() {
                currentlyEditingIndex = null;
                editorElement.classList.add('hidden');
                errorElement.classList.add('hidden');
            }

            function saveAdsToForm() {
                if (generatedAdsInput) {
                    generatedAdsInput.value = JSON.stringify(currentAds);
                    window.generatedAds = currentAds;
                }
            }

            function generateFinalUrl(city, path1 = 'service', path2 = 'executive') {
                const base = 'https://yourdomain.com'; // Change this to your real domain
                const citySlug = city.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                const path1Slug = path1.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                const path2Slug = path2.toLowerCase().replace(/[^a-z0-9]+/g, '-');

                return `${base}/${path1Slug}/${path2Slug}/${citySlug}`;
            }

            // Initialize
            window.getSelectedKeywords = window.getSelectedKeywords || function() {
                console.warn('getSelectedKeywords function not properly defined');
                return [];
            };
        });
    </script>
@endpush
