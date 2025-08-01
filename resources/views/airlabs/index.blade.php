<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Data Synchronization'])
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                {{ __('Synchronize Data') }}
            </h3>

            <!-- Buttons Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <button id="syncAirportsAirlinesBtn" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out group">
                    <svg class="w-5 h-5 mr-3 text-indigo-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    {{ __('Sync Airports & Airlines') }}
                </button>

                <button id="syncCountriesBtn" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out group">
                    <svg class="w-5 h-5 mr-3 text-indigo-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                    {{ __('Sync Countries') }}
                </button>

                <button id="syncCitiesBtn" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out group">
                    <svg class="w-5 h-5 mr-3 text-indigo-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ __('Sync Cities') }}
                </button>
            </div>

            <!-- Improved Loader -->
            <div id="loader" class="hidden">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-20 transition-opacity flex items-center justify-center">
                    <div class="bg-white p-6 rounded-lg shadow-xl flex items-center space-x-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
                        <p class="text-gray-700" id="loaderText">Synchronizing data...</p>
                    </div>
                </div>
            </div>

            <!-- Improved Success Alert -->
            <div id="successAlert" class="hidden rounded-lg p-4 mb-4 bg-green-50 border border-green-200" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-green-700" id="successMessage"></span>
                    <button class="ml-auto" onclick="hideSuccess()">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Improved Error Alert -->
            <div id="errorAlert" class="hidden rounded-lg p-4 mb-4 bg-red-50 border border-red-200" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-red-700" id="errorMessage"></span>
                    <button class="ml-auto" onclick="hideError()">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function showLoader(message = 'Synchronizing data...') {
                $('#loaderText').text(message);
                $('#loader').removeClass('hidden');
            }

            function hideLoader() {
                $('#loader').addClass('hidden');
            }

            function showError(message) {
                $('#errorMessage').text(message);
                $('#errorAlert').removeClass('hidden')
                    .addClass('animate__animated animate__fadeIn');
                setTimeout(() => {
                    hideError();
                }, 5000);
            }

            function hideError() {
                $('#errorAlert').addClass('hidden');
            }

            function showSuccess(message) {
                $('#successMessage').text(message);
                $('#successAlert').removeClass('hidden')
                    .addClass('animate__animated animate__fadeIn');
                setTimeout(() => {
                    hideSuccess();
                }, 5000);
            }

            function hideSuccess() {
                $('#successAlert').addClass('hidden');
            }

            async function handleSync(route, type) {
                const buttonId = `#sync${type}Btn`;
                const originalHtml = $(buttonId).html();
                
                $(buttonId).prop('disabled', true)
                    .html('<div class="flex items-center"><div class="animate-spin mr-2"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>Synchronizing...</div>');

                try {
                    const response = await fetch(route);
                    const result = await response.json();
                    
                    if (response.ok) {
                        showSuccess(result.message);
                    } else {
                        showError(result.message || 'An error occurred');
                    }
                } catch (error) {
                    console.error(`Error synchronizing ${type}:`, error);
                    showError(`Error synchronizing ${type}. Please try again.`);
                } finally {
                    $(buttonId).prop('disabled', false).html(originalHtml);
                }
            }

            $('#syncAirportsAirlinesBtn').on('click', () => 
                handleSync('{{ route('sincronizar-datos') }}', 'AirportsAirlines'));

            $('#syncCountriesBtn').on('click', () => 
                handleSync('{{ route('sincronizar-paises') }}', 'Countries'));

            $('#syncCitiesBtn').on('click', () => 
                handleSync('{{ route('sincronizar-ciudades') }}', 'Cities'));
        });
    </script>

    <style>
        .animate__animated {
            animation-duration: 0.5s;
        }
        
        .animate__fadeIn {
            animation-name: fadeIn;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</x-app-layout>