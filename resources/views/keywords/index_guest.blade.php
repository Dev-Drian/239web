<x-guest-layout>
    <div class="py-6">

        <div id="processingLoader" class="fixed top-0 left-0 w-full bg-gray-900/50 h-1" style="z-index: 1000;">
            <div class="bg-indigo-600 h-full transition-all duration-300" style="width: 0%;" id="progressBar"></div>
        </div>

        <!-- Processing Status Panel -->
        <div id="processingStatus"
            class="hidden fixed top-4 right-4 bg-white rounded-lg shadow-xl p-4 border border-gray-200"
            style="z-index: 1001; max-width: 300px;">
            <div class="flex items-center gap-3 mb-3">
                <div class="animate-spin rounded-full h-4 w-4 border-2 border-indigo-600 border-t-transparent"></div>
                <h3 class="font-medium text-gray-900">Processing Keywords</h3>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Processed:</span>
                    <span id="processedCount">0</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Remaining:</span>
                    <span id="remainingCount">0</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Total:</span>
                    <span id="totalCount">0</span>
                </div>

                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="statusProgressBar" class="h-full bg-indigo-600 transition-all duration-300"
                        style="width: 0%"></div>
                </div>

                <p class="text-xs text-gray-500 mt-2">
                    Estimated time remaining: <span id="estimatedTime">Calculating...</span>
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-4 md:p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Keyword Analysis Dashboard</h2>
                    <div class="flex items-center bg-indigo-50 border border-indigo-100 rounded-lg shadow-sm px-4 py-2">
                        <i class="fas fa-coins text-indigo-600 mr-2 text-lg"></i>
                        <div>
                            <span class="text-sm font-medium text-indigo-800">Available Credits:</span>
                            <span id="availableCredits"
                                class="ml-1 text-lg font-bold text-indigo-600">{{ $client->credits ?? 0 }}</span>
                        </div>
                        {{-- <button id="purchaseCredits" class="ml-3 text-xs px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                <i class="fas fa-plus-circle mr-1"></i> Add
                            </button> --}}
                    </div>
                </div>

                <!-- Step 1: Site Information -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold flex items-center mb-4">
                        <span
                            class="bg-indigo-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2">1</span>
                        Site Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="searchUrl" class="block text-sm font-medium text-gray-700 mb-1">Site URL</label>
                            <input type="text" id="searchUrl" name="searchUrl" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3">
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <select id="location" name="location"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 bg-white hover:border-gray-400">
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Keywords -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold flex items-center mb-4">
                        <span
                            class="bg-indigo-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2">2</span>
                        Keywords Input
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <!-- Botones de selección de keywords -->
                        <div class="flex flex-wrap gap-3 items-center">
                            <button id="topKeywordsButton"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md min-w-[140px]">
                                <i class="fas fa-chart-line"></i> Top Keywords
                            </button>

                            <button id="keywordsByCityButton"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-md min-w-[160px]">
                                <i class="fas fa-city"></i> Keywords by City
                            </button>

                            <button type="button" onclick="document.getElementById('csvFile').click();"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-md min-w-[170px]">
                                <i class="fas fa-file-csv"></i> Upload CSV
                            </button>

                            <input type="file" id="csvFile" name="csvFile" accept=".csv" class="hidden"
                                onchange="this.previousElementSibling.textContent = this.files[0] ? this.files[0].name : 'Upload CSV'">
                        </div>

                        <!-- Input manual de keywords -->
                        <div>
                            <label for="manualKeyword" class="block text-sm font-medium text-gray-700 mb-1">
                                Add Keyword
                            </label>
                            <div class="flex gap-2 items-center">
                                <input type="text" id="manualKeyword" name="manualKeyword"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3">
                                <button type="button" id="addKeyword"
                                    class="flex items-center gap-2 py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md min-w-[100px]">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Limit: 50 keywords</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-4"></div>
                </div>



                <!-- Step 3: Submit -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold flex items-center mb-4">
                        <span class="bg-indigo-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2">3</span>
                        Start Analysis
                    </h3>
                    <button type="submit" id="processKeywords"
                        class="w-full md:w-auto py-2 px-6 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Process Keywords
                    </button>
                </div>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-green-800">First Page</h3>
                        <p class="mt-2 text-3xl font-bold text-green-900" id="firstPageCount">0</p>
                    </div>

                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-yellow-800">Second Page</h3>
                        <p class="mt-2 text-3xl font-bold text-yellow-900" id="secondPageCount">0</p>
                    </div>

                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-red-800">Beyond</h3>
                        <p class="mt-2 text-3xl font-bold text-red-900" id="otherPagesCount">0</p>
                    </div>
                </div>
                <!-- Results & Actions -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Results</h3>

                    <!-- Results Table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="w-full border-collapse bg-white shadow-md rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        <i class="fas fa-key"></i> Keyword
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-chart-line"></i> Position
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-search"></i> Search Volume
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-dollar-sign"></i> CPC
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        <i class="fas fa-link"></i> URL
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-tachometer-alt"></i> Difficulty
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-cogs"></i> Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="resultsBody">
                                <!-- Data rows -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 justify-end">
                        <button id="removeNotFound"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                            <i class="fas fa-trash-alt"></i> Remove Not Found
                        </button>

                        <button id="printTable"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                            <i class="fas fa-print"></i> Print Table
                        </button>

                        <button id="saveResults"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                            <i class="fas fa-save"></i> Save Analysis
                        </button>

                        <button id="exportCsv"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md">
                            <i class="fas fa-file-export"></i> Export CSV
                        </button>

                        <button id="fetchKeywordData"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-md">
                            <i class="fas fa-chart-bar"></i> Volumes & CPC
                        </button>

                        <a id="saveHistory" href="{{ route('keyword.show', $client->highlevel_id) }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-md">
                            <i class="fas fa-history"></i>  View Ranking History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            // Este archivo debe cargarse antes que los demás scripts
            // Contiene variables globales necesarias para el funcionamiento

            // Token CSRF para peticiones AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Rutas de la aplicación (usando helper route de Laravel)
            const keywordPositionRoute = '{{ route('keyword.position', $client->highlevel_id) }}';
            const dataForSeoRoute = '{{ route('dataforseo.search_volume', $client->highlevel_id) }}';
            const saveResultsRoute = '{{ route('keyword.save',$client->highlevel_id) }}';
            const keywordHistoryRoute = '{{ route('keyword.history',$client->highlevel_id) }}';
            const logoUrl = '{{ asset('img/logo.png') }}';


            // Variables de la aplicación
        </script>

        <script>
           $(document).ready(function() {
                $('#location').select2({
                    placeholder: 'Select a location',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('api.cities') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term, // search term
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>

        <script src="{{ asset('js/keyword/keyword.js') }}"></script>
        <script src="{{ asset('js/keyword/util.js') }}"></script>
        <script src="{{ asset('js/keyword/result.js') }}"></script>
    @endpush
</x-guest-layout>
