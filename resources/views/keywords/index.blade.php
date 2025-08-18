<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="font-bold text-2xl text-slate-800">{{ __('Keyword Tracking') }}</h2>
        </div>
    </x-slot>
{{ Auth::user()->client}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Card with Gradient Background -->
            <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 shadow-xl sm:rounded-2xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Campaign Configuration
                    </h3>
                </div>

                <!-- Setup Form -->
                <form id="keywordForm" class="p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label for="searchUrl" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                Website URL
                            </label>
                            <input id="searchUrl" name="searchUrl" type="url" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-blue-100 bg-white shadow-sm focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-blue-200"
                                placeholder="https://example.com">
                        </div>

                        <div class="space-y-2">
                            <label for="location" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                City
                            </label>
                            <div class="relative">
                                <select id="location" name="location" required
                                    class="w-full px-4 py-3 pl-10 rounded-xl border-2 border-blue-100 bg-white shadow-sm focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-blue-200 appearance-none">
                                    <option value="" selected disabled>Search for a city...</option>
                                    <!-- Options will be loaded dynamically -->
                                </select>
                                <!-- Search Icon -->
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none z-10">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="device" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Device
                            </label>
                            <select id="device" name="device"
                                class="w-full px-4 py-3 rounded-xl border-2 border-blue-100 bg-white shadow-sm focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-blue-200">
                                <option value="desktop" selected>Desktop</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label for="keywordsInput" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Keywords (one per line)
                        </label>
                        <textarea id="keywordsInput" name="keywords" rows="4"
                            class="w-full px-4 py-3 rounded-xl border-2 border-blue-100 bg-white shadow-sm focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-blue-200 resize-none"
                            placeholder="limo near me&#10;wedding limo atlanta&#10;luxury car service"></textarea>

                        <div class="flex items-center gap-3 flex-wrap">
                            <button type="submit" id="startTracking"
                                class="px-6 py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Set Campaign
                            </button>

                            <button type="button" id="topKeywordsCity"
                                class="px-6 py-3 rounded-xl text-purple-700 font-semibold bg-purple-50 hover:bg-purple-100 border-2 border-purple-200 hover:border-purple-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Top Keywords + City
                            </button>

                            <button type="button" id="topKeywords"
                                class="px-6 py-3 rounded-xl text-blue-700 font-semibold bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 hover:border-blue-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                Top Keywords
                            </button>

                            <button type="button" id="uploadCsvBtn"
                                class="px-6 py-3 rounded-xl text-emerald-700 font-semibold bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                                </svg>
                                Upload CSV
                            </button>
                            <input type="file" id="uploadCsvInput" accept=".csv,text/csv" class="hidden" />
                        </div>
                    </div>
                </form>

                <!-- Summary Cards -->
                <div class="px-6 pb-6">
                    <h4 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Rankings Summary
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-emerald-50 to-green-100 border-2 border-emerald-200 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-emerald-700 mb-1">Page 1 (1–10)</p>
                                    <p id="summaryPage1" class="text-3xl font-bold text-emerald-800">0</p>
                                </div>
                                <div class="p-3 bg-emerald-500 rounded-xl">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-amber-50 to-yellow-100 border-2 border-amber-200 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-amber-700 mb-1">Page 2 (11–20)</p>
                                    <p id="summaryPage2" class="text-3xl font-bold text-amber-800">0</p>
                                </div>
                                <div class="p-3 bg-amber-500 rounded-xl">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-rose-50 to-pink-100 border-2 border-rose-200 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-rose-700 mb-1">Pages 3–10 (21–100)</p>
                                    <p id="summaryPage3To10" class="text-3xl font-bold text-rose-800">0</p>
                                </div>
                                <div class="p-3 bg-rose-500 rounded-xl">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="px-6 pb-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200">
                            <h4 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Tracking Results
                            </h4>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-blue-600 to-indigo-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Keyword</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Last Position
                                            <span id="lastDateHeader" class="text-blue-200 normal-case font-normal"></span>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Previous Position
                                            <span id="prevDateHeader" class="text-blue-200 normal-case font-normal"></span>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Accumulated</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Searches</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">URL</th>
                                    </tr>
                                </thead>
                                <tbody id="resultsBody" class="bg-white divide-y divide-slate-100">
                                    <!-- rows injected by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- API Response Viewer (DataForSEO) -->


                <!-- Rejected Keywords Section -->
                <div id="rejectedKeywordsSection" class="hidden px-6 pb-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-red-200">
                            <h4 class="text-lg font-semibold text-red-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Keywords Not Added
                            </h4>
                            <p class="text-sm text-red-600 mt-1">These keywords were rejected due to special characters or invalid format</p>
                        </div>

                        <div class="p-6">
                            <div id="rejectedKeywordsList" class="space-y-3">
                                <!-- Rejected keywords will be listed here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loader -->
                <div id="loader" class="hidden px-6 pb-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="relative">
                                <div class="w-10 h-10 border-4 border-blue-200 rounded-full animate-spin border-t-blue-600"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-4 h-4 bg-blue-600 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-blue-800">Updating rankings…</p>
                                <p class="text-sm text-blue-600">
                                    <span id="processedCountLoader">0</span>/<span id="totalCountLoader">0</span> keywords processed
                                </p>
                            </div>
                        </div>

                        <div class="w-full bg-blue-100 rounded-full h-3 shadow-inner">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 shadow-sm"
                                 style="width:0%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Select2 for location dropdown
            initializeLocationSelect2();

            function initializeLocationSelect2() {
                $('#location').select2({
                    placeholder: "Search for a city...",
                    allowClear: true,
                    width: '100%',
                    dropdownCssClass: "select2-dropdown-custom",
                    minimumInputLength: 2,
                    theme: "classic",
                    ajax: {
                        url: "https://portal.crm.limo/api/pruebas", // Same API as service areas
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            console.log("API Response:", data);

                            if (!data || !data.data || !data.data.locations) {
                                console.error("Invalid API response structure");
                                return {
                                    results: [],
                                    pagination: { more: false }
                                };
                            }

                            return {
                                results: data.data.locations.map(function(location) {
                                    return {
                                        id: location.name + ', ' + location.state_code, // Use full text as ID
                                        text: `${location.name}, ${location.state_code}`, // Display format
                                        locationCode: '1015254' // All cities have the same location code
                                    };
                                }),
                                pagination: {
                                    more: (data.data.info.total_locations > (params.page || 1) * 30)
                                }
                            };
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                        },
                        cache: false
                    },
                    language: {
                        searching: function() {
                            return "Searching cities...";
                        },
                        noResults: function() {
                            return "No cities found";
                        },
                        inputTooShort: function() {
                            return "Please enter 2 or more characters";
                        }
                    },
                    templateResult: function(item) {
                        if (!item.id) return item.text;
                        return $(`<div class="flex items-center py-1">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            <span>${item.text}</span>
                        </div>`);
                    },
                    templateSelection: function(item) {
                        return item.text || item.id;
                    }
                });

                // Style the Select2 to match the existing design
                styleSelect2();

                // Handle selection
                $('#location').on('select2:select', function(e) {
                    console.log("Selected city:", e.params.data);
                    const selectedCity = e.params.data.text;
                    console.log("City selected for keywords:", selectedCity);
                });
            }

            function styleSelect2() {
                // Most styles are now handled by CSS, just ensure the arrow is hidden
                setTimeout(function() {
                    $('.select2-container--classic .select2-selection--single .select2-selection__arrow').hide();
                }, 100);
            }
            // Add CSS for loading states
            const style = document.createElement('style');
            style.textContent = `
                .field-loading {
                    transition: all 0.3s ease;
                }

                .field-loaded {
                    opacity: 1;
                }

                .field-loading[data-field="searches"] .text-blue-600 {
                    color: #059669;
                }
            `;
            document.head.appendChild(style);

            const form = document.getElementById('keywordForm');
            const textarea = document.getElementById('keywordsInput');
            const resultsBody = document.getElementById('resultsBody');
            const lastDateHeader = document.getElementById('lastDateHeader');
            const prevDateHeader = document.getElementById('prevDateHeader');
            const topKeywordsCityBtn = document.getElementById('topKeywordsCity');
            const topKeywordsBtn = document.getElementById('topKeywords');
            const uploadCsvBtn = document.getElementById('uploadCsvBtn');
            const uploadCsvInput = document.getElementById('uploadCsvInput');
			const apiResponseEl = document.getElementById('apiResponse');
			const csrfToken = (document.querySelector('#keywordForm input[name="_token"]')?.value) || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
			const dataForSeoRoute = '{{ route('dataforseo.search_volume', 'yWFG48Re1sqVp67SQxsG') }}';
			const serpPositionsRoute = '{{ route('dataforseo.serp_positions', 'yWFG48Re1sqVp67SQxsG') }}';
			const keywordHistoryRoute = '{{ route('keyword.history', 'yWFG48Re1sqVp67SQxsG') }}';
			const keywordTrackerGetRoute = '{{ route('keyword.tracker.get') }}';
			const keywordTrackerSaveRoute = '{{ route('keyword.tracker.save') }}';
			let preloadedItemsByKw = new Map();
			let prevHeaderDate = null;

            function cleanKeyword(keyword) {
                // Remove special characters that could cause issues
                return keyword
                    .replace(/[^\w\s\-]/g, '') // Remove special characters except letters, numbers, spaces, and hyphens
                    .replace(/\s+/g, ' ') // Replace multiple spaces with single space
                    .trim();
            }

            function isValidKeyword(keyword) {
                // Check if keyword has maximum 4 words
                const wordCount = keyword.split(/\s+/).filter(word => word.length > 0).length;
                return wordCount <= 4;
            }

            function splitKeywords(text) {
                const allKeywords = text
                    .split(/\r?\n|,|;+/)
                    .map(k => k.trim())
                    .filter(Boolean);

                const validKeywords = [];
                const rejectedKeywords = [];

                allKeywords.forEach(keyword => {
                    const cleaned = cleanKeyword(keyword);
                    if (cleaned && isValidKeyword(cleaned)) {
                        validKeywords.push(cleaned);
                    } else {
                        rejectedKeywords.push({
                            original: keyword,
                            reason: getRejectionReason(keyword)
                        });
                    }
                });

                return { validKeywords, rejectedKeywords };
            }

            function getRejectionReason(keyword) {
                const cleaned = cleanKeyword(keyword);
                if (!cleaned) {
                    return "Contains special characters";
                }

                const wordCount = keyword.split(/\s+/).filter(word => word.length > 0).length;
                if (wordCount > 4) {
                    return `Too many words (${wordCount} words, maximum 4 allowed)`;
                }

                return "Invalid format";
            }

            function showRejectedKeywords(rejectedKeywords) {
                const rejectedSection = document.getElementById('rejectedKeywordsSection');
                const rejectedList = document.getElementById('rejectedKeywordsList');

                if (rejectedKeywords.length === 0) {
                    rejectedSection.classList.add('hidden');
                    return;
                }

                rejectedSection.classList.remove('hidden');
                rejectedList.innerHTML = '';

                rejectedKeywords.forEach(item => {
                    const keywordDiv = document.createElement('div');
                    keywordDiv.className = 'flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200';
                    keywordDiv.innerHTML = `
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-red-800">${item.original}</span>
                                <p class="text-sm text-red-600">${item.reason}</p>
                            </div>
                        </div>
                    `;
                    rejectedList.appendChild(keywordDiv);
                });
            }

            function generateTopKeywords() {
                const topKeywords = [
                    'airport limo service',
                    'airport limousine service',
                    'airport chauffeur service',
                    'airport car service',
                    'airport black car service',
                    'black car service',
                    'executive car service',
                    'luxury airport transportation',
                    'private airport car service',
                    'airport transfer service',
                    'airport shuttle limo',
                    'airport pick up limo',
                    'limo to airport',
                    'limo from airport',
                    'corporate airport transportation',
                    'luxury black car service',
                    'private SUV airport service',
                    'airport sedan service',
                    'door to door airport car',
                    'professional airport transportation',
                    'airport town car service',
                    'meet and greet airport limo',
                    'best airport limo service',
                    'affordable airport limousine',
                    'non-stop airport car service',
                    'long distance airport transfer',
                    '24/7 airport limousine',
                    'airport executive transfer',
                    'reliable airport car service',
                    'airport luxury chauffeur',
                    'airport minivan limo',
                    'first class airport service',
                    'business airport limo',
                    'on time airport car',
                    'family airport limo',
                    'group airport transfer service',
                    'stretch limo airport',
                    'airport sprinter van service',
                    'airport premium transportation',
                    'personalized airport pickup',
                    'city to airport limo',
                    'airport ride service',
                    'late model limo airport',
                    'luxury shuttle to airport'
                ];

                const filtered = Array.from(new Set(
                    topKeywords
                        .map(k => cleanKeyword(k))
                        .filter(k => k && isValidKeyword(k))
                ));

                // Only fill the textarea. Actual rendering and requests will happen on "Set Campaign"
                textarea.value = filtered.join('\n');
            }

            function generateTopKeywordsWithCity() {
                const selectedData = $('#location').select2('data');

                if (!selectedData || selectedData.length === 0 || !selectedData[0].id) {
                    showNotification('Please select a city first!', 'error');
                    return;
                }

                // Use only the leading part of the visible city text (before the first comma)
                const locationName = selectedData[0].text.split(',')[0].trim();
                const templates = [
                    '{city} limo service',
                    'limo service {city}',
                    '{city} limousine service',
                    'limousine service {city}',
                    '{city} black car service',
                    'black car service {city}',
                    '{city} airport limo service',
                    'airport limo service {city}',
                    '{city} airport limousine',
                    'airport limousine {city}',
                    '{city} executive car service',
                    'executive car service {city}',
                    '{city} car service',
                    'car service {city}',
                    '{city} chauffeur service',
                    'chauffeur service {city}',
                    '{city} luxury car service',
                    'luxury car service {city}',
                    '{city} SUV limo service',
                    'SUV limo service {city}',
                    '{city} sedan service',
                    'sedan service {city}',
                    '{city} party bus service',
                    'party bus service {city}',
                    '{city} group transportation',
                    'group transportation {city}',
                    '{city} wedding limo',
                    'wedding limo {city}',
                    '{city} wine tour limo',
                    'wine tour limo {city}',
                    '{city} prom limo service',
                    'prom limo service {city}',
                    '{city} bachelor party limo',
                    'bachelor party limo {city}',
                    '{city} corporate limo service',
                    'corporate limo service {city}',
                    '{city} concert limo service',
                    'concert limo service {city}',
                    '{city} event limousine',
                    'event limousine {city}',
                    '{city} hourly limo service',
                    'hourly limo service {city}',
                    'per hour limo service {city}',
                    '{city} airport pick up limo',
                    'airport pick up limo {city}',
                    '{city} airport black car service',
                    'airport black car service {city}',
                    '{city} airport transfer service',
                    'airport transfer service {city}',
                    '{city} airport shuttle limo',
                    'airport shuttle limo {city}',
                    '{city} meet and greet limo',
                    'meet and greet limo {city}'
                ];

                const keywordsRaw = templates.map(t => t.replaceAll('{city}', locationName));
                const filtered = Array.from(new Set(
                    keywordsRaw
                        .map(k => cleanKeyword(k))
                        .filter(k => k && isValidKeyword(k))
                ));

                // Only fill the textarea. Actual rendering and requests will happen on "Set Campaign"
                textarea.value = filtered.join('\n');
            }

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;

                // Set colors based on type
                if (type === 'success') {
                    notification.className += ' bg-green-500 text-white';
                } else if (type === 'error') {
                    notification.className += ' bg-red-500 text-white';
                } else {
                    notification.className += ' bg-blue-500 text-white';
                }

                notification.textContent = message;
                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            function formatToday() {
                const d = new Date();
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }

            function renderTable(keywords) {
                resultsBody.innerHTML = '';
                const today = formatToday();
                if (lastDateHeader) lastDateHeader.textContent = `(${today})`;
                if (prevDateHeader) prevDateHeader.textContent = prevHeaderDate ? `(${prevHeaderDate})` : `(—)`;

                // Update summary counts
                updateSummaryCounts(keywords.length);

                if (keywords.length === 0) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-lg font-medium">No valid keywords to display</p>
                                <p class="text-sm">Add some keywords above to get started</p>
                            </div>
                        </td>
                    `;
                    resultsBody.appendChild(tr);
                    return;
                }

                keywords.forEach((kw, index) => {
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white hover:bg-blue-50' : 'bg-slate-50 hover:bg-blue-50';

                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">${kw}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loading" data-field="position">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                                    <span class="text-blue-600 text-xs">Loading position...</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loaded" data-field="previous">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loading" data-field="accumulated">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                                    <span class="text-blue-600 text-xs">Calculating...</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loading" data-field="searches">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                                    <span class="text-blue-600 text-xs">Loading searches...</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="field-loading" data-field="url">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                                    <span class="text-blue-600 text-xs">Loading URL...</span>
                                </div>
                            </div>
                        </td>
                    `;
                    resultsBody.appendChild(tr);
                });
            }

            // Ensure rows exist for given keywords without resetting existing cell contents
            function ensureTableRows(keywords) {
                const today = formatToday();
                if (lastDateHeader) lastDateHeader.textContent = `(${today})`;
                if (prevDateHeader) prevDateHeader.textContent = prevHeaderDate ? `(${prevHeaderDate})` : `(—)`;

                const list = Array.isArray(keywords) ? keywords : [];
                const wanted = new Set(list.map(k => String(k).trim().toLowerCase()));

                // Remove rows that are no longer needed
                Array.from(resultsBody.querySelectorAll('tr')).forEach(row => {
                    const el = row.querySelector('td:first-child span.text-sm.font-semibold');
                    if (!el) return;
                    const key = el.textContent.trim().toLowerCase();
                    if (!wanted.has(key)) row.remove();
                });

                // Add rows for missing keywords (neutral placeholders, no spinners)
                list.forEach(kw => {
                    const key = String(kw).trim().toLowerCase();
                    const exists = Array.from(resultsBody.querySelectorAll('tr')).some(r => {
                        const el = r.querySelector('td:first-child span.text-sm.font-semibold');
                        return el && el.textContent.trim().toLowerCase() === key;
                    });
                    if (exists) return;

                    const index = resultsBody.querySelectorAll('tr').length;
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white hover:bg-blue-50' : 'bg-slate-50 hover:bg-blue-50';
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">${kw}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loaded" data-field="position">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loaded" data-field="previous">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loaded" data-field="accumulated">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div class="field-loaded" data-field="searches">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="field-loaded" data-field="url">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs">-</span>
                            </div>
                        </td>
                    `;
                    resultsBody.appendChild(tr);
                });

                updateSummaryCounts(list.length);
            }

            // Toggle loading UI for a keyword/field when starting or finishing requests
            function setFieldLoading(keyword, field, isLoading) {
                const rows = resultsBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const keywordEl = row.querySelector('td:first-child span.text-sm.font-semibold');
                    if (!keywordEl || keywordEl.textContent.trim().toLowerCase() !== String(keyword).trim().toLowerCase()) return;
                    const container = row.querySelector(`[data-field="${field}"]`);
                    if (!container) return;
                    if (isLoading) {
                        container.classList.add('field-loading');
                        container.classList.remove('field-loaded');
                        if (field === 'searches') {
                            container.innerHTML = `<div class="flex items-center gap-2"><div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div><span class="text-blue-600 text-xs">Loading searches...</span></div>`;
                        } else if (field === 'position') {
                            container.innerHTML = `<div class="flex items-center gap-2"><div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div><span class="text-blue-600 text-xs">Loading position...</span></div>`;
                        } else if (field === 'url') {
                            container.innerHTML = `<div class="flex items-center gap-2"><div class="w-4 h-4 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div><span class="text-blue-600 text-xs">Loading URL...</span></div>`;
                        }
                    } else {
                        container.classList.remove('field-loading');
                        container.classList.add('field-loaded');
                    }
                });
            }

            async function loadTracker() {
                try {
                    const resp = await fetch(keywordTrackerGetRoute, { headers: { 'Accept': 'application/json' } });
                    const json = await resp.json();
                    if (!json || !json.success || !json.data) return;

                    const data = json.data;
                    // Prefill inputs
                    const searchUrlInput = document.getElementById('searchUrl');
                    const deviceSelect = document.getElementById('device');
                    if (searchUrlInput && data.url) searchUrlInput.value = data.url;
                    if (deviceSelect && data.device) deviceSelect.value = data.device;
                    if (data.city) setSelect2City(data.city);

                    const kws = Array.isArray(data.keywords) ? data.keywords : (Array.isArray(data.items) ? data.items.map(i => i.keyword) : []);
                    const uniqueKws = Array.from(new Set((kws || []).filter(Boolean).map(k => String(k).trim())));
                    if (uniqueKws.length) {
                        textarea.value = uniqueKws.join('\n');
                        ensureTableRows(uniqueKws);

                        // Fill rows with saved item details
                        const byKw = new Map();
                        (data.items || []).forEach(item => { if (item && item.keyword) byKw.set(String(item.keyword).trim().toLowerCase(), item); });
                        preloadedItemsByKw = byKw;
                        uniqueKws.forEach(kw => {
                            const key = kw.trim().toLowerCase();
                            const item = byKw.get(key);
                            if (!item) return;

                            if (item.searches != null) {
                                updateFieldLoading(kw, 'searches', Number(item.searches).toLocaleString());
                            }
                            if (item.url) {
                                updateFieldLoading(kw, 'url', `<a href="${item.url}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium" target="_blank" rel="noopener">${item.url}</a>`);
                            }

                            // Previous position and accumulated
                            const rows = resultsBody.querySelectorAll('tr');
                            rows.forEach(row => {
                                const el = row.querySelector('td:first-child span.text-sm.font-semibold');
                                if (!el || el.textContent.trim().toLowerCase() !== key) return;
                                const cells = row.querySelectorAll('td');
                                if (cells && cells.length >= 6) {
                                    // Mostrar last_position como PREVIOUS al precargar
                                    if (item.last_position && item.last_position !== 'no_ranked') {
                                        cells[2].innerHTML = `<span class=\"px-3 py-1 bg-slate-100 rounded-full text-xs\">${item.last_position}</span>`;
                                    } else if (item.last_position === 'no_ranked') {
                                        cells[2].innerHTML = `<span class=\"px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs\">Not found</span>`;
                                    } else {
                                        cells[2].innerHTML = `<span class=\"px-3 py-1 bg-slate-100 rounded-full text-xs\">-</span>`;
                                    }

                                    // Si existen previous_position y last_position guardados, calcular accumulated
                                    const lastNum = parseInt(item.last_position, 10);
                                    const prevNum = parseInt(item.previous_position, 10);
                                    if (Number.isFinite(lastNum) && Number.isFinite(prevNum)) {
                                        renderAccumulatedPill(cells, lastNum, prevNum);
                                    }
                                }
                            });
                        });

                        // Set previous header date from the newest item's last_tracked_at if available
                        const firstItem = (data.items || []).find(Boolean);
                        if (firstItem && firstItem.last_tracked_at) {
                            try {
                                const d = new Date(firstItem.last_tracked_at);
                                const yyyy = d.getFullYear();
                                const mm = String(d.getMonth() + 1).padStart(2, '0');
                                const dd = String(d.getDate()).padStart(2, '0');
                                prevHeaderDate = `${yyyy}-${mm}-${dd}`;
                                if (prevDateHeader) prevDateHeader.textContent = `(${prevHeaderDate})`;
                            } catch (e) {}
                        }
                    }
                } catch (e) {
                    // ignore preload errors silently
                }
            }

            function setSelect2City(cityText) {
                const $select = $('#location');
                if (!$select.length) return;
                const option = new Option(cityText, cityText, true, true);
                $select.append(option).trigger('change');
            }

            async function saveTrackerConfig(keywords) {
                try {
                    const searchUrlInput = document.getElementById('searchUrl');
                    const deviceSelect = document.getElementById('device');
                    const selectedData = $('#location').select2('data');
                    const city = (selectedData && selectedData.length > 0) ? (selectedData[0].text || selectedData[0].id) : null;
                    await fetch(keywordTrackerSaveRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            url: searchUrlInput?.value || '',
                            city: city || null,
                            device: deviceSelect?.value || 'desktop',
                            keywords: keywords
                        })
                    });
                } catch (e) {
                    // ignore save errors silently
                }
            }

            function collectItemsFromTable() {
                const items = [];
                const rows = resultsBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (!cells || cells.length < 6) return;
                    const kwEl = cells[0].querySelector('span.text-sm.font-semibold');
                    if (!kwEl) return;
                    const keyword = kwEl.textContent.trim();
                    const lastText = cells[1].textContent.trim();
                    const prevText = cells[2].textContent.trim();
                    const accText = cells[3].textContent.trim();
                    const searchesText = cells[4].textContent.trim();
                    const urlAnchor = cells[5].querySelector('a');
                    const item = {
                        keyword,
                        last_position: (/\n?\d+/.test(lastText) ? lastText.match(/\d+/)[0] : (lastText.toLowerCase().includes('not') ? 'no_ranked' : null)),
                        previous_position: (/\d+/.test(prevText) ? prevText.match(/\d+/)[0] : null),
                        accumulated: accText || null,
                        searches: (/\d/.test(searchesText) ? parseInt(searchesText.replace(/[^\d]/g, ''), 10) : null),
                        url: urlAnchor ? urlAnchor.getAttribute('href') : null,
                    };
                    items.push(item);
                });
                return items;
            }

            async function saveTrackerItemsFromTable() {
                try {
                    const searchUrlInput = document.getElementById('searchUrl');
                    const deviceSelect = document.getElementById('device');
                    const selectedData = $('#location').select2('data');
                    const city = (selectedData && selectedData.length > 0) ? (selectedData[0].text || selectedData[0].id) : null;
                    const items = collectItemsFromTable();
                    await fetch(keywordTrackerSaveRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            url: searchUrlInput?.value || '',
                            city: city || null,
                            device: deviceSelect?.value || 'desktop',
                            items: items,
                            keywords: items.map(i => i.keyword)
                        })
                    });
                } catch (e) {
                    // ignore save errors silently
                }
            }

            function updateSummaryCounts(totalKeywords) {
                // Reset all counts to 0 for now
                document.getElementById('summaryPage1').textContent = '0';
                document.getElementById('summaryPage2').textContent = '0';
                document.getElementById('summaryPage3To10').textContent = '0';

                // You can implement actual ranking logic here later
                // For now, just show the total count
                if (totalKeywords > 0) {
                    document.getElementById('summaryPage1').textContent = totalKeywords;
                }
            }

            function updateTableWithDataForSeo(apiData) {
                console.log('updateTableWithDataForSeo called with:', apiData);

                if (!Array.isArray(apiData) || apiData.length === 0) {
                    console.log('No valid API data received');
                    return;
                }

                // Build map keyword -> data
                const keywordToData = new Map();
                apiData.forEach(item => {
                    if (!item || !item.keyword) return;
                    keywordToData.set(String(item.keyword).trim().toLowerCase(), item);
                });

                console.log('Keyword to data map:', keywordToData);

                const rows = resultsBody.querySelectorAll('tr');
                console.log('Found rows:', rows.length);

                rows.forEach((row, index) => {
                    const keywordEl = row.querySelector('td:first-child span.text-sm.font-semibold');
                    if (!keywordEl) {
                        console.log(`Row ${index}: No keyword element found`);
                        return;
                    }

                    const kw = keywordEl.textContent.trim().toLowerCase();
                    const data = keywordToData.get(kw);

                    console.log(`Row ${index}: Keyword "${kw}", found data:`, data);

                    if (!data) {
                        console.log(`Row ${index}: No data found for keyword "${kw}"`);
                        updateFieldLoading(kw, 'searches', 'No data', 'not_found');
                        return;
                    }

                    // Update Searches field
                    if (data.search_volume !== null && data.search_volume !== undefined && data.search_volume > 0) {
                        const volume = typeof data.search_volume === 'number' ? data.search_volume : (parseInt(data.search_volume, 10) || 0);
                        console.log(`Row ${index}: Setting search volume to ${volume} for keyword "${kw}"`);
                        updateFieldLoading(kw, 'searches', volume.toLocaleString());
                    } else if (data.found === false) {
                        // Keyword was requested but no data found in API
                        updateFieldLoading(kw, 'searches', 'No data available', 'warning');
                    } else {
                        // Keyword has data but search_volume is 0 or null
                        updateFieldLoading(kw, 'searches', '0', 'success');
                    }
                });
            }

            // Event listeners
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const { validKeywords, rejectedKeywords } = splitKeywords(textarea.value);

                    if (validKeywords.length === 0) {
                        showNotification('No valid keywords found. Keywords must have maximum 4 words and contain only letters, numbers, spaces, and hyphens.', 'error');
                        showRejectedKeywords(rejectedKeywords);
                        return;
                    }

                    ensureTableRows(validKeywords);
                    showRejectedKeywords(rejectedKeywords);

                    // Update button label to persist as "Save & Update Campaign"
                    const button = document.getElementById('startTracking');
                    button.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save & Update Campaign
                    `;

					showNotification(`Campaign set successfully with ${validKeywords.length} valid keywords!`, 'success');

					// Persist base tracker config + keywords
					saveTrackerConfig(validKeywords);

					// Trigger DataForSEO request and show response (Searches)
					sendDataForSeo(validKeywords);
					// Trigger SERP positions (Last Position + URL)
					sendSerpPositions(validKeywords);
					// Fetch history for Previous Position and compute Accumulated
					fetchPreviousPositions();
                });
            }

            // Top Keywords button
            if (topKeywordsCityBtn) {
                topKeywordsCityBtn.addEventListener('click', generateTopKeywordsWithCity);
            }

            if (topKeywordsBtn) {
                topKeywordsBtn.addEventListener('click', generateTopKeywords);
            }

            if (uploadCsvBtn && uploadCsvInput) {
                uploadCsvBtn.addEventListener('click', () => uploadCsvInput.click());
                uploadCsvInput.addEventListener('change', async (e) => {
                    try {
                        const file = e.target.files && e.target.files[0];
                        if (!file) return;

                        const text = await file.text();
                        const { validKeywords } = splitKeywords(text);
                        const deduped = Array.from(new Set(validKeywords));
                        textarea.value = deduped.join('\n');
                        showNotification(`CSV loaded: ${deduped.length} valid keywords added to the input`, 'success');
                    } catch (err) {
                        showNotification('Error reading CSV file', 'error');
                    } finally {
                        // reset input so same file can be selected again
                        e.target.value = '';
                    }
                });
            }

            // Add input validation on textarea
            if (textarea) {
                textarea.addEventListener('input', () => {
                    const lines = textarea.value.split('\n');
                    const validLines = lines.filter(line => {
                        const cleaned = cleanKeyword(line.trim());
                        return cleaned && isValidKeyword(cleaned);
                    });

                    // Show validation feedback
                    const totalLines = lines.filter(line => line.trim()).length;
                    const validCount = validLines.length;

                    if (totalLines > 0) {
                        const feedback = document.getElementById('validationFeedback') || createValidationFeedback();

                        if (validCount === totalLines) {
                            feedback.innerHTML = `<span class="text-green-600">✓ All ${validCount} keywords are valid (maximum 4 words, no special characters)</span>`;
                            feedback.className = 'text-green-600 text-sm mt-2 font-medium';
                        } else {
                            const rejectedCount = totalLines - validCount;

                            // Get rejected keywords for display
                            const rejectedKeywords = [];
                            lines.forEach((line, index) => {
                                if (line.trim()) {
                                    const cleaned = cleanKeyword(line.trim());
                                    if (!cleaned || !isValidKeyword(cleaned)) {
                                        rejectedKeywords.push({
                                            original: line.trim(),
                                            reason: getRejectionReason(line.trim()),
                                            lineNumber: index + 1
                                        });
                                    }
                                }
                            });

                            // Create rejected keywords text
                            const rejectedText = rejectedKeywords.map(item =>
                                `"${item.original}" (Line ${item.lineNumber}: ${item.reason})`
                            ).join(', ');

                            feedback.innerHTML = `
                                <div class="text-amber-600">
                                    <div>⚠ ${validCount}/${totalLines} keywords are valid. ${rejectedCount} will be rejected.</div>
                                    <div class="text-red-600 text-sm mt-1 max-h-20 overflow-y-auto border border-red-200 rounded p-2 bg-red-50">
                                        <div class="font-medium mb-1 flex items-center gap-2">
                                            Rejected keywords:
                                            <div class="relative inline-block" onmouseenter="showTooltip(this)" onmouseleave="hideTooltip(this)">
                                                <svg class="w-4 h-4 text-red-500 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <div class="tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 invisible transition-all duration-200 pointer-events-none whitespace-nowrap z-50">
                                                    Keywords with special characters or more than 4 words will not be processed
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>
                                        ${rejectedKeywords.map(item =>
                                            `<div class="text-xs">• "${item.original}" - ${item.reason}</div>`
                                        ).join('')}
                                    </div>
                                </div>
                            `;
                            feedback.className = 'text-amber-600 text-sm mt-2 font-medium';
                        }
                    } else {
                        // Clear feedback if no input
                        const feedback = document.getElementById('validationFeedback');
                        if (feedback) {
                            feedback.remove();
                        }
                    }
                });
            }

            function createValidationFeedback() {
                const feedback = document.createElement('div');
                feedback.id = 'validationFeedback';
                feedback.className = 'text-sm mt-2';
                textarea.parentNode.appendChild(feedback);
                return feedback;
            }

            function showTooltip(element) {
                const tooltip = element.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.classList.remove('invisible', 'opacity-0');
                    tooltip.classList.add('visible', 'opacity-100');
                }
            }

            function hideTooltip(element) {
                const tooltip = element.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.classList.remove('visible', 'opacity-100');
                    tooltip.classList.add('invisible', 'opacity-0');
                }
            }

            async function sendDataForSeo(validKeywords) {
                try {
                    const selectedData = $('#location').select2('data');
                    if (!selectedData || selectedData.length === 0 || !selectedData[0].id) {
                        showNotification('Please select a city first!', 'error');
                        return;
                    }

                    const locationCode = 2840;

                    // Set loading on Searches only while the request is in-flight
                    (validKeywords || []).forEach(kw => setFieldLoading(kw, 'searches', true));

                    // Show loader
                    const loader = document.getElementById('loader');
                    const processedCountLoader = document.getElementById('processedCountLoader');
                    const totalCountLoader = document.getElementById('totalCountLoader');
                    const progressBar = document.getElementById('progressBar');
                    if (loader) loader.classList.remove('hidden');
                    if (totalCountLoader) totalCountLoader.textContent = String(validKeywords.length);
                    if (processedCountLoader) processedCountLoader.textContent = '0';
                    if (progressBar) progressBar.style.width = '0%';

                    const resp = await fetch(dataForSeoRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            keywords: validKeywords,
                            location_code: locationCode,
                            lenguaje_name: 'en'
                        })
                    });

                    const json = await resp.json().catch(() => ({ error: true, message: 'Invalid JSON response' }));

                    if (apiResponseEl) {
                        apiResponseEl.textContent = JSON.stringify(json, null, 2);
                    }

                    if (!resp.ok || json.success === false || json.error) {
                        showNotification(json.message || 'Error from DataForSEO endpoint', 'error');
                    } else {
                        showNotification('DataForSEO response received', 'success');
                        updateTableWithDataForSeo(json.data);
                    }

                    // Finish loader
                    if (processedCountLoader) processedCountLoader.textContent = String(validKeywords.length);
                    if (progressBar) progressBar.style.width = '100%';
                } catch (err) {
                    if (apiResponseEl) {
                        apiResponseEl.textContent = JSON.stringify({ error: true, message: String(err) }, null, 2);
                    }
                    showNotification('Unexpected error requesting DataForSEO', 'error');
                } finally {
                    // Stop loading state on searches fields
                    (validKeywords || []).forEach(kw => setFieldLoading(kw, 'searches', false));

                    const loader = document.getElementById('loader');
                    if (loader) setTimeout(() => loader.classList.add('hidden'), 300);
                }
            }

            async function sendSerpPositions(validKeywords) {
                try {
                    const selectedData = $('#location').select2('data');
                    const deviceSelect = document.getElementById('device');
                    const searchUrlInput = document.getElementById('searchUrl');

                    if (!selectedData || selectedData.length === 0 || !selectedData[0].id) {
                        showNotification('Please select a city first!', 'error');
                        return;
                    }
                    if (!searchUrlInput || !searchUrlInput.value) {
                        showNotification('Please provide Website URL to match domain in SERP', 'error');
                        return;
                    }

                    const locationCode = parseInt(selectedData[0].locationCode || '2840', 10);
                    const device = deviceSelect?.value || 'desktop';
                    const domain = searchUrlInput.value;

                    // Set loading for position and URL while the request is in-flight
                    (validKeywords || []).forEach(kw => {
                        setFieldLoading(kw, 'position', true);
                        setFieldLoading(kw, 'url', true);
                    });

                    // Show loader
                    const loader = document.getElementById('loader');
                    const processedCountLoader = document.getElementById('processedCountLoader');
                    const totalCountLoader = document.getElementById('totalCountLoader');
                    const progressBar = document.getElementById('progressBar');
                    if (loader) loader.classList.remove('hidden');
                    if (totalCountLoader) totalCountLoader.textContent = String(validKeywords.length);
                    if (processedCountLoader) processedCountLoader.textContent = '0';
                    if (progressBar) progressBar.style.width = '0%';

                    // Process keywords one by one
                    let processedCount = 0;
                    const results = [];

                    for (let i = 0; i < validKeywords.length; i++) {
                        const keyword = validKeywords[i];

                        try {
                            // Update progress
                            if (processedCountLoader) processedCountLoader.textContent = String(processedCount);
                            if (progressBar) progressBar.style.width = `${((i + 1) / validKeywords.length) * 100}%`;

                            // Make individual API call for each keyword
                            const resp = await fetch(serpPositionsRoute, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    keywords: [keyword], // Send only one keyword at a time
                                    location_code: locationCode,
                                    language_code: 'en',
                                    device: device,
                                    domain: domain
                                })
                            });

                            const json = await resp.json().catch(() => ({ error: true, message: 'Invalid JSON response' }));

                            if (!resp.ok || json.success === false || json.error) {
                                console.error(`Error for keyword "${keyword}":`, json.message || 'Unknown error');
                                // Add null result for failed keyword
                                results.push({
                                    keyword: keyword,
                                    position: null,
                                    url: null,
                                    target_found: false,
                                    target_position: null,
                                    target_url: null,
                                    first_organic_position: null,
                                    first_organic_url: null,
                                });
                            } else {
                                console.log(`Success for keyword "${keyword}":`, json.data);
                                // Add the result
                                if (json.data && json.data.length > 0) {
                                    results.push(json.data[0]);
                                } else {
                                    results.push({
                                        keyword: keyword,
                                        position: null,
                                        url: null,
                                        target_found: false,
                                        target_position: null,
                                        target_url: null,
                                        first_organic_position: null,
                                        first_organic_url: null,
                                    });
                                }
                            }

                            processedCount++;

                            // Update the table with current results
                            updateTableWithSerp(results);

                            // Small delay to avoid overwhelming the API
                            await new Promise(resolve => setTimeout(resolve, 500));

                        } catch (err) {
                            console.error(`Error processing keyword "${keyword}":`, err);
                            // Add null result for failed keyword
                            results.push({
                                keyword: keyword,
                                position: null,
                                url: null,
                                target_found: false,
                                target_position: null,
                                target_url: null,
                                first_organic_position: null,
                                first_organic_url: null,
                            });
                            processedCount++;
                        }
                    }

                    // Final update
                    if (processedCountLoader) processedCountLoader.textContent = String(processedCount);
                    if (progressBar) progressBar.style.width = '100%';

                    // Show final results in API response viewer
                    if (apiResponseEl) {
                        apiResponseEl.textContent = JSON.stringify({
                            success: true,
                            data: results,
                            total_processed: processedCount
                        }, null, 2);
                    }

                    showNotification(`SERP positions processed for ${processedCount} keywords`, 'success');

                    // Persist final items snapshot from table
                    saveTrackerItemsFromTable();

                } catch (err) {
                    if (apiResponseEl) {
                        apiResponseEl.textContent = JSON.stringify({ error: true, message: String(err) }, null, 2);
                    }
                    showNotification('Unexpected error requesting SERP positions', 'error');
                } finally {
                    // Stop loading state for position and url fields
                    (validKeywords || []).forEach(kw => {
                        setFieldLoading(kw, 'position', false);
                        setFieldLoading(kw, 'url', false);
                    });

                    const loader = document.getElementById('loader');
                    if (loader) setTimeout(() => loader.classList.add('hidden'), 300);
                }
            }

            function updateFieldLoading(keyword, field, content, type = 'success') {
                const rows = resultsBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const keywordEl = row.querySelector('td:first-child span.text-sm.font-semibold');
                    if (!keywordEl || keywordEl.textContent.trim().toLowerCase() !== keyword.toLowerCase()) return;

                    const fieldLoading = row.querySelector(`[data-field="${field}"]`);
                    if (!fieldLoading) return;

                    // Remove loading state
                    fieldLoading.classList.remove('field-loading');
                    fieldLoading.classList.add('field-loaded');

                    // Update content based on type
                    if (type === 'error' || type === 'not_found') {
                        fieldLoading.innerHTML = `<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">${content}</span>`;
                    } else if (type === 'warning') {
                        fieldLoading.innerHTML = `<span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">${content}</span>`;
                    } else {
                        fieldLoading.innerHTML = content;
                    }
                });
            }

            function updateTableWithSerp(apiData) {
                console.log('updateTableWithSerp called with:', apiData);

                if (!Array.isArray(apiData) || apiData.length === 0) {
                    console.log('No valid SERP API data received');
                    return;
                }

                const map = new Map();
                apiData.forEach(item => {
                    if (!item || !item.keyword) return;
                    map.set(String(item.keyword).trim().toLowerCase(), item);
                });

                console.log('SERP keyword to data map:', map);

                const rows = resultsBody.querySelectorAll('tr');
                console.log('Found rows for SERP update:', rows.length);

                // Reset summary counts
                let page1Count = 0;
                let page2Count = 0;
                let page3To10Count = 0;

                rows.forEach((row, index) => {
                    const keywordEl = row.querySelector('td:first-child span.text-sm.font-semibold');
                    if (!keywordEl) {
                        console.log(`SERP Row ${index}: No keyword element found`);
                        return;
                    }

                    const kw = keywordEl.textContent.trim().toLowerCase();
                    const data = map.get(kw);

                    console.log(`SERP Row ${index}: Keyword "${kw}", found data:`, data);

                    if (!data) {
                        console.log(`SERP Row ${index}: No data found for keyword "${kw}"`);
                        return;
                    }

                    // Keep preloaded Previous as-is (do not reset it to loading). If empty, only then derive from current Last
                    const cells = row.querySelectorAll('td');
                    if (cells && cells.length >= 6) {
                        const prevHasValue = cells[2].textContent.trim().length > 0 && !cells[2].textContent.trim().toLowerCase().includes('loading');
                        if (!prevHasValue) {
                            const currentLastText = cells[1].textContent.trim();
                            const isNumericLast = /\d+/.test(currentLastText);
                            const isNotFoundLast = currentLastText.toLowerCase().includes('not');
                            if (isNumericLast) {
                                const prevVal = currentLastText.match(/\d+/)[0];
                                cells[2].innerHTML = `<span class=\"px-3 py-1 bg-slate-100 rounded-full text-xs\">${prevVal}</span>`;
                            } else if (isNotFoundLast) {
                                cells[2].innerHTML = `<span class=\"px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs\">Not found</span>`;
                            }
                        }
                    }

                    // Update Last Position field with fresh SERP
                    if (data.best_position !== 'no_ranked') {
                        const pos = String(data.best_position);
                        updateFieldLoading(kw, 'position', `<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">${pos}</span>`);

                        // Update summary counts
                        const position = parseInt(data.best_position);
                        if (position >= 1 && position <= 10) {
                            page1Count++;
                        } else if (position >= 11 && position <= 20) {
                            page2Count++;
                        } else if (position >= 21 && position <= 100) {
                            page3To10Count++;
                        }
                    } else {
                        updateFieldLoading(kw, 'position', 'Not found', 'not_found');
                    }

                    // Recalculate accumulated after last is updated (using existing Previous)
                    if (cells && cells.length >= 6) {
                        updateAccumulatedForRow(cells);
                    }

                    // Update URL field
                    if (data.best_url) {
                        updateFieldLoading(kw, 'url', `<a href="${data.best_url}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium" target="_blank" rel="noopener">${data.best_url}</a>`);
                    } else {
                        updateFieldLoading(kw, 'url', 'No URL', 'not_found');
                    }
                });

                // Update summary counts in the UI
                document.getElementById('summaryPage1').textContent = page1Count;
                document.getElementById('summaryPage2').textContent = page2Count;
                document.getElementById('summaryPage3To10').textContent = page3To10Count;

                console.log('SERP update completed. Summary counts:', { page1Count, page2Count, page3To10Count });
            }

			async function fetchPreviousPositions() {
				try {
					const resp = await fetch(keywordHistoryRoute, { method: 'GET', headers: { 'Accept': 'application/json' } });
					const json = await resp.json();
					if (json && json.success && Array.isArray(json.data)) {
						const map = new Map();
						json.data.forEach(item => {
							if (!item || !item.keyword) return;
							map.set(String(item.keyword).trim().toLowerCase(), item);
						});
						updateTableWithPrevious(map);
					}
				} catch (e) {
					// ignore
				}
			}

			function updateTableWithPrevious(previousMap) {
				const rows = resultsBody.querySelectorAll('tr');
				rows.forEach(row => {
					const keywordEl = row.querySelector('td:first-child span.text-sm.font-semibold');
					if (!keywordEl) return;
					const kw = keywordEl.textContent.trim().toLowerCase();
					const prevItem = previousMap.get(kw);
					if (!prevItem) return;
					const prevPos = typeof prevItem.position === 'number' ? prevItem.position : parseInt(prevItem.position, 10);
					const cells = row.querySelectorAll('td');
					if (cells && cells.length >= 6) {
						const prevText = Number.isFinite(prevPos) ? String(prevPos) : '-';
						cells[2].innerHTML = `<span class="px-3 py-1 bg-slate-100 rounded-full text-xs">${prevText}</span>`;
						updateAccumulatedForRow(cells);
					}
				});
			}

			function updateAccumulatedForRow(cells) {
				if (!cells || cells.length < 6) return;
				const lastStrRaw = cells[1].textContent.trim().toLowerCase();
				const prevStrRaw = cells[2].textContent.trim().toLowerCase();
				if (lastStrRaw.includes('not')) {
					cells[3].innerHTML = `<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">No ranking</span>`;
					return;
				}
				const last = parseInt(lastStrRaw, 10);
				const prev = parseInt(prevStrRaw, 10);
				if (Number.isFinite(last) && Number.isFinite(prev)) {
					renderAccumulatedPill(cells, last, prev);
				}
			}

			function renderAccumulatedPill(cells, last, prev) {
				const diff = prev - last; // positivo => subió
				if (diff > 0) {
					cells[3].innerHTML = `<span class=\"inline-flex items-center px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs\"><svg class=\"w-3 h-3 mr-1\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M5 10l5-5 5 5H5z\"></path></svg>Went up ${diff}</span>`;
				} else if (diff < 0) {
					const down = Math.abs(diff);
					cells[3].innerHTML = `<span class=\"inline-flex items-center px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs\"><svg class=\"w-3 h-3 mr-1\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M5 10l5 5 5-5H5z\"></path></svg>Went down ${down}</span>`;
				} else {
					cells[3].innerHTML = `<span class=\"px-2 py-1 rounded-full bg-slate-100 text-slate-700 text-xs\">No change</span>`;
				}
			}

			// Preload tracker data on page load
			loadTracker();
        });
    </script>

    <!-- Custom CSS for Select2 integration -->
    <style>
        /* Main Select2 container styling to match other inputs */
        .select2-container--classic {
            width: 100% !important;
        }

        .select2-container--classic .select2-selection--single {
            height: 50px !important;
            min-height: 50px !important;
            border: 2px solid #dbeafe !important;
            border-radius: 12px !important;
            background-color: white !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
            transition: all 0.2s ease !important;
            padding: 12px 16px !important;
            box-sizing: border-box !important;
        }

        /* Text rendering inside the input */
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            padding-left: 24px !important;
            padding-right: 0px !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            line-height: 26px !important;
            color: #1f2937 !important;
            font-size: 16px !important;
            height: 26px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Placeholder styling */
        .select2-container--classic .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
            font-size: 16px !important;
            line-height: 26px !important;
            height: 26px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hide the default arrow */
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            display: none !important;
        }

        /* Hover effects */
        .select2-container--classic .select2-selection--single:hover {
            border-color: #93c5fd !important;
        }

        /* Focus effects */
        .select2-container--classic.select2-container--open .select2-selection--single,
        .select2-container--classic .select2-selection--single:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.1) !important;
        }

        /* Custom dropdown styling */
        .select2-dropdown-custom {
            border: 2px solid #dbeafe !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            margin-top: 4px !important;
        }

        /* Search input in dropdown */
        .select2-container--classic .select2-search--dropdown {
            padding: 8px !important;
        }

        .select2-container--classic .select2-search--dropdown .select2-search__field {
            border: 2px solid #dbeafe !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 14px !important;
        }

        .select2-container--classic .select2-search--dropdown .select2-search__field:focus {
            border-color: #60a5fa !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1) !important;
        }

        /* Dropdown results */
        .select2-container--classic .select2-results__option {
            padding: 12px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
            color: #374151 !important;
        }

        .select2-container--classic .select2-results__option:last-child {
            border-bottom: none !important;
        }

        .select2-container--classic .select2-results__option--highlighted[aria-selected] {
            background-color: #eff6ff !important;
            color: #1e40af !important;
        }

        .select2-container--classic .select2-results__option[aria-selected="true"] {
            background-color: #2563eb !important;
            color: white !important;
        }

        /* Loading and no results states */
        .select2-container--classic .select2-results__option[aria-live="polite"],
        .select2-container--classic .select2-results__option[aria-live="assertive"] {
            text-align: center !important;
            padding: 20px !important;
            color: #6b7280 !important;
            font-style: italic !important;
        }

        /* Custom scrollbar for dropdown */
        .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }

        .select2-results__options::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .select2-results__options::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Remove any outline from container */
        .select2-container:focus {
            outline: none !important;
        }

        /* Ensure proper positioning for the search icon */
        .select2-container--classic .select2-selection--single + .absolute {
            pointer-events: none;
            z-index: 10;
        }
    </style>

    {{--
    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const keywordPositionRoute = '{{ route('keyword.position', "adsaas") }}';
            const dataForSeoRoute = '{{ route('dataforseo.search-volume') }}';
            const saveResultsRoute = '{{ route('keyword.save') }}';
            const keywordHistoryRoute = '{{ route('keyword.history') }}';
            const logoUrl = '{{ asset('img/logo.jpeg') }}';
            let keywords = [];
            let results = [];
            let processedCount = 0;
            let intervalId;
        </script>
        <script src="{{ asset('js/keyword/util.js') }}"></script>
        <script src="{{ asset('js/keyword/main.js') }}"></script>
        <script src="{{ asset('js/keyword/jeyword.js') }}"></script>
        <script src="{{ asset('js/keyword/result.js') }}"></script>
    @endpush
    --}}
</x-app-layout>
