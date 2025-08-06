<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keyword Position Finder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Loader and counters -->
                <div id="loader" class="hidden">
                    <div class="mb-6 bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin">
                                </div>
                                <span class="text-gray-700 font-medium">Processing keywords...</span>
                            </div>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: 0%" id="progressBar"></div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Processed</p>
                                <p class="text-lg font-semibold">
                                    <span id="processedCountLoader">0</span>/<span id="totalCountLoader">0</span>
                                </p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Time remaining</p>
                                <p class="text-lg font-semibold" id="timeLeft">0m 0s</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Speed</p>
                                <p class="text-lg font-semibold">~2s/keyword</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search form -->
                <form id="keywordForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="searchUrl" class="block text-sm font-medium text-gray-700">Site URL</label>
                            <input type="text" id="searchUrl" name="searchUrl" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- <div>
                            <label for="csvFile" class="block text-sm font-medium text-gray-700">CSV File of
                                Keywords</label>
                            <input type="file" id="csvFile" name="csvFile" accept=".csv"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div> --}}
                    </div>

                    <!-- Manual keyword input -->
                    <div class="mt-8">
                        {{-- <div>
                            <label for="manualKeyword" class="block text-sm font-medium text-gray-700">Add Keyword
                                Manually</label>
                            <input type="text" id="manualKeyword" name="manualKeyword"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">Limit: 50 keywords</p>
                        </div>
                        <div class="flex items-end">
                            <button type="button" id="addKeyword"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Keyword
                            </button>
                        </div> --}}
                        <div class="flex justify-between items-center mb-4">
                            <div class="space-x-2">
                                <button id="getKeywordData"
                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                                    <i class="fas fa-sync mr-2"></i> Get Volumes & CPC
                                </button>
                                <button id="exportCsv"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Export CSV
                                </button>
                                <button id="saveResults"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Save Results
                                </button>
                                <button id="printTable"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-print mr-2"></i> Print Results
                                </button>
    
                                <button id="topKeywords"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                    <i class="fas fa-star mr-2"></i> Top Keywords
                                </button>
                                <button id="topKeywordsByCity"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                                    <i class="fas fa-city mr-2"></i> Top Keywords by City
                                </button>
                                <button type="button" onclick="document.getElementById('csvFile').click();"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    <i class="fas fa-file-csv mr-2"></i> Choose CSV File
                                </button>
                                <input type="file" id="csvFile" name="csvFile" accept=".csv" class="hidden"
                                    onchange="this.previousElementSibling.textContent = this.files[0] ? this.files[0].name : 'Choose CSV File'">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Process Keywords
                        </button>
                    </div>
                </form>

                <!-- Results table -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Results</h3>


                    <div class="mt-2 flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Keyword
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Position
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Search Volume
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    URL
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    CPC
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultsBody" class="bg-white divide-y divide-gray-200">
                                            <!-- Results will be inserted here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Este archivo debe cargarse antes que los demás scripts
            // Contiene variables globales necesarias para el funcionamiento

            // Token CSRF para peticiones AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Rutas de la aplicación (usando helper route de Laravel)
            const keywordPositionRoute = '{{ route('keyword.position',"adsaas") }}';
            const dataForSeoRoute = '{{ route('dataforseo.search-volume') }}';
            const saveResultsRoute = '{{ route('keyword.save') }}';
            const keywordHistoryRoute = '{{ route('keyword.history') }}';
            const logoUrl = '{{ asset('img/logo.png') }}';



            // Variables compartidas entre archivos
            let keywords = [];
            let results = [];
            let processedCount = 0;
            let intervalId;

            
            // Función para imprimir la tabla
            // Función para imprimir la tabla
        </script>
        <script src="{{ asset('js/keyword/util.js') }}"></script>
        <script src="{{ asset('js/keyword/main.js') }}"></script>
        <script src="{{ asset('js/keyword/jeyword.js') }}"></script>
        <script src="{{ asset('js/keyword/result.js') }}"></script>
    @endpush --}}
</x-app-layout>
