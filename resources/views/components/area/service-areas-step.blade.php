<form id="service-form" method="POST">
    @csrf <!-- CSRF token for security -->
    <div class="form-step hidden animate__animated" id="step-2">
        <div class="w-full max-w-4xl mx-auto glass-dark rounded-2xl shadow-2xl overflow-hidden border border-white/15 backdrop-blur-xl">
            <!-- Enhanced Header Section -->
            <div class="bg-gradient-to-r from-blue-600/80 via-indigo-600/80 to-purple-600/80 px-6 py-4 backdrop-blur-xl border-b border-white/10">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-map-marked-alt mr-3"></i>Service Areas
                </h2>
                <p class="text-blue-100 mt-1">Search for your city, hit Enter, and wait a bit until it populates.</p>
            </div>

            <!-- City Search Section -->
            <div class="p-6">
                <div class="relative mb-6">
                    <!-- Enhanced Select2 Dropdown -->
                    <select id="location"
                        class="block w-full pl-10 pr-10 py-3 text-base text-white glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 shadow-lg appearance-none transition-all hover:border-white/30 bg-transparent backdrop-blur-xl">
                        <option value="" selected disabled>Select a location</option>
                        <!-- Options will be loaded dynamically -->
                    </select>
                    <!-- Enhanced Search Icon -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Enhanced Loader -->
                <div id="loader" class="flex justify-center items-center my-4 hidden">
                    <div class="glass rounded-2xl p-4 border border-white/20 backdrop-blur-xl">
                        <div class="loader ease-linear rounded-full border-4 border-t-4 border-white/20 border-t-blue-500 h-8 w-8"></div>
                        <p class="text-white text-sm mt-2">Loading locations...</p>
                    </div>
                </div>

                <!-- Enhanced Content Below Search -->
                <div id="content-below-search" class="hidden">
                    <!-- Enhanced Cities Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center border-b border-white/20 pb-2">
                            <i class="fas fa-city mr-2 text-blue-400"></i>Cities
                        </h3>
                        <div id="cities-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- City items will be loaded dynamically -->
                        </div>
                        <p id="no-cities-message" class="text-slate-400 text-sm mt-2 hidden">No cities available.</p>
                        
                        <!-- Enhanced Additional Cities -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-300 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Additional Cities
                                <div class="relative ml-2 group">
                                    <i class="fas fa-info-circle text-blue-400 cursor-pointer"></i>
                                    <div class="absolute z-10 hidden group-hover:block w-64 p-3 mt-1 glass border border-white/20 rounded-2xl shadow-2xl text-xs left-0 backdrop-blur-xl">
                                        <p class="font-medium text-white mb-1">Required Format:</p>
                                        <p class="text-slate-300">• <span class="font-mono bg-white/10 px-1 rounded">City Name</span></p>
                                        <p class="text-slate-300 mt-1">Example: <span class="font-mono bg-white/10 px-1 rounded">New York</span></p>
                                        <p class="text-slate-300 mt-2">• Separate with commas <strong>or</strong> new lines</p>
                                        <p class="text-slate-300">• One city per line</p>
                                    </div>
                                </div>
                            </label>
                            <textarea name="extra_cities"
                                class="w-full p-3 glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                placeholder="Enter additional cities, separated by commas..." rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Enhanced Airports Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center border-b border-white/20 pb-2">
                            <i class="fas fa-plane mr-2 text-cyan-400"></i>Airports and Ports
                        </h3>
                        <div id="airports-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Airport items will be loaded dynamically -->
                        </div>
                        <p id="no-airports-message" class="text-slate-400 text-sm mt-2 hidden">No airports available.</p>
                        
                        <!-- Enhanced Additional Airports -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-300 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Additional Airports
                                <div class="relative ml-2 group">
                                    <i class="fas fa-info-circle text-blue-400 cursor-pointer"></i>
                                    <div class="absolute z-10 hidden group-hover:block w-64 p-3 mt-1 glass border border-white/20 rounded-2xl shadow-2xl text-xs left-0 backdrop-blur-xl">
                                        <p class="font-medium text-white mb-1">Required Format:</p>
                                        <p class="text-slate-300">• <span class="font-mono bg-white/10 px-1 rounded">IATA</span></p>
                                        <p class="text-slate-300 mt-1">Example: <span class="font-mono bg-white/10 px-1 rounded">JFK</span></p>
                                        <p class="text-slate-300 mt-2">• Separate with commas <strong>or</strong> new lines</p>
                                        <p class="text-slate-300">• One airport per line</p>
                                    </div>
                                </div>
                            </label>
                            <textarea name="extra_airports"
                                class="w-full p-3 glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                placeholder="Enter additional airports with their IATA codes (e.g., JFK - John F. Kennedy Airport)..."
                                rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Enhanced Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center border-b border-white/20 pb-2">
                            <i class="fas fa-concierge-bell mr-2 text-orange-400"></i>Available Services
                        </h3>
                        <div id="services-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Services will be generated dynamically here -->
                        </div>
                    </div>

                    <!-- Enhanced Additional Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center border-b border-white/20 pb-2">
                            <i class="fas fa-plus-circle mr-2 text-pink-400"></i>Additional Services
                        </h3>
                        <textarea name="extra_service"
                            class="w-full p-4 glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500/50 transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                            placeholder="Describe other services you offer..." rows="3"></textarea>
                    </div>

                    <!-- Enhanced Navigation Buttons -->
                    <div class="flex justify-between gap-4">
                        <button
                            class="prev-step glass hover:bg-white/10 text-slate-300 hover:text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 shadow-lg flex-1 flex items-center justify-center border border-white/20 backdrop-blur-xl transform hover:-translate-y-1"
                            data-prev="1">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        <button type="submit"
                            class="next-step bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl flex-1 flex items-center justify-center transform hover:-translate-y-1"
                            data-next="3">
                            Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Scripts for Select2 and Event Handling -->
@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const routeGenerateCityAndAiport = "{{ route('generate-nearby-cities-and-airports', $client->highlevel_id) }}";
        const routeStoreArea = "{{ route('area.store', $client->highlevel_id) }}";
        let cityMain;
    </script>
    
    <!-- All existing JavaScript remains exactly the same -->
    <script>
        document.getElementById('service-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // All existing JavaScript logic remains the same
            const selectedCities = Array.from(document.querySelectorAll('input[name="cities[]"]:checked')).map(
                input => input.value);
            const selectedAirports = Array.from(document.querySelectorAll('input[name="airports[]"]:checked')).map(
                input => input.value);
            const selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked')).map(
                input => input.value);
            const extraService = document.querySelector('textarea[name="extra_service"]').value;
            const extraCities = document.querySelector('textarea[name="extra_cities"]').value;
            const extraAirports = document.querySelector('textarea[name="extra_airports"]').value;

            const data = {
                city: cityMain,
                areas: selectedCities,
                airports: selectedAirports,
                services: selectedServices,
                extra_service: extraService,
                extra_cities: extraCities,
                extra_airports: extraAirports
            };

            console.log(data);

            fetch(routeStoreArea, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(`Server error: ${response.status} - ${JSON.stringify(errorData)}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data saved successfully!',
                            confirmButtonText: 'Accept'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error saving data: ' + (data.message || 'Unknown error'),
                            confirmButtonText: 'Accept'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred: ' + error.message,
                        confirmButtonText: 'Accept'
                    });
                });
        });
    </script>

    <script>
        $(document).ready(function() {
            let areas = @json($client->areas);
            let services_client = @json($client->services);
            let extra_service = @json($client->extra_service);
            const services = [
                'Airport Transfers',
                'Corporate Transfers',
                'Wedding Transportation',
                'Point to Point',
                'Per Hour',
                'Concert and Events',
                'Group Transportation',
                'Cruise Port Transfers',
                'Wine Tours'
            ];

            // Enhanced services container
            const servicesContainer = $('#services-container');
            
            // Generate services with dark theme styling
            services.forEach(service => {
                const value = service.toLowerCase().replace(/ /g, '_');
                const serviceHTML = `
                    <label class="flex items-center p-4 glass border border-white/20 rounded-2xl hover:bg-blue-500/10 hover:border-blue-400/50 transition-all cursor-pointer group backdrop-blur-xl">
                        <input type="checkbox" name="services[]" value="${value}" class="w-5 h-5 text-blue-500 bg-transparent border-white/30 rounded focus:ring-blue-500/50 focus:ring-2 mr-3">
                        <span class="text-white group-hover:text-blue-300 transition-colors duration-200">${service}</span>
                    </label>
                `;
                servicesContainer.append(serviceHTML);
            });

            // Enhanced Select2 styling for dark theme
            $('#location').select2({
                placeholder: "Search for a city or airport...",
                allowClear: true,
                width: '100%',
                dropdownCssClass: "select2-dropdown-dark",
                minimumInputLength: 3,
                theme: "classic",
                ajax: {
                    url: "https://portal.crm.limo/api/pruebas",
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
                                    id: location.id,
                                    text: `${location.name}, ${location.state_code}`
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
                    searching: function() { return "Searching..."; },
                    noResults: function() { return "No results found"; },
                    inputTooShort: function() { return "Please enter 3 or more characters"; }
                }
            });

            // All other existing JavaScript remains exactly the same
            $('#location').on('select2:select', function(e) {
                console.log("Selected:", e.params.data);
                const selectedCity = e.params.data.text;
                if (selectedCity) {
                    const [city, stateCode] = selectedCity.split(',').map(item => item.trim());
                    console.log("City:", city);
                    console.log("State Code:", stateCode);
                    cityMain = selectedCity;
                } else {
                    console.error("Invalid selection data");
                }
            });

            $('#location').on('select2:select', function(e) {
                const selectedCity = e.params.data.id;
                $('#location').prop('disabled', true);
                $('#loader').removeClass('hidden');

                fetch(routeGenerateCityAndAiport, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ city: cityMain })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.data) {
                            $('#content-below-search').removeClass('hidden');
                            $('#cities-container').empty();
                            $('#airports-container').empty();

                            // Display cities with dark theme styling
                            if (data.data.cities.length > 0) {
                                data.data.cities.forEach(city => {
                                    $('#cities-container').append(`
                                        <label class="flex items-center p-4 glass border border-white/20 rounded-2xl hover:bg-blue-500/10 hover:border-blue-400/50 transition-all cursor-pointer group backdrop-blur-xl">
                                            <input type="checkbox" name="cities[]" value="${city}"
                                                class="w-5 h-5 text-blue-500 bg-transparent border-white/30 rounded focus:ring-blue-500/50 focus:ring-2 mr-3">
                                            <div class="flex flex-col">
                                                <span class="text-white font-medium group-hover:text-blue-300 transition-colors duration-200">${city}</span>
                                            </div>
                                        </label>
                                    `);
                                });
                                $('#no-cities-message').addClass('hidden');
                            } else {
                                $('#no-cities-message').removeClass('hidden');
                            }

                            // Display airports with dark theme styling
                            if (data.data.airports.length > 0) {
                                data.data.airports.forEach(airport => {
                                    $('#airports-container').append(`
                                        <label class="flex items-center p-4 glass border border-white/20 rounded-2xl hover:bg-cyan-500/10 hover:border-cyan-400/50 transition-all cursor-pointer group backdrop-blur-xl">
                                            <input type="checkbox" name="airports[]" value="${airport.IATA_code}"
                                                class="w-5 h-5 text-cyan-500 bg-transparent border-white/30 rounded focus:ring-cyan-500/50 focus:ring-2 mr-3">
                                            <div class="flex flex-col flex-1">
                                                <span class="text-white font-medium group-hover:text-cyan-300 transition-colors duration-200">${airport.name}</span>
                                                <span class="text-slate-400 text-sm">IATA Code: ${airport.IATA_code}</span>
                                            </div>
                                            <span class="ml-auto text-xl text-cyan-400 group-hover:text-cyan-300 transition-colors duration-200">
                                                <i class="fas fa-plane-departure"></i>
                                            </span>
                                        </label>
                                    `);
                                });
                                $('#no-airports-message').addClass('hidden');
                            } else {
                                $('#no-airports-message').removeClass('hidden');
                            }
                        } else {
                            console.error('Error: No valid data received.');
                        }
                    })
                    .catch(error => {
                        console.error('Request error:', error);
                    })
                    .finally(() => {
                        $('#location').prop('disabled', false);
                        $('#loader').addClass('hidden');
                    });
            });
        });
    </script>
@endpush

@push('styles')
<style>
    /* Enhanced dark theme loader animation */
    .loader {
        border-top-color: #3b82f6;
        -webkit-animation: spinner 1.5s linear infinite;
        animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Dark theme Select2 dropdown styling */
    .select2-dropdown-dark {
        background-color: rgba(15, 23, 42, 0.95) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 16px !important;
        backdrop-filter: blur(12px) !important;
    }

    .select2-dropdown-dark .select2-results__option {
        color: white !important;
        background-color: transparent !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        margin: 4px 8px !important;
    }

    .select2-dropdown-dark .select2-results__option--highlighted {
        background-color: rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
    }

    .select2-dropdown-dark .select2-search__field {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: white !important;
        border-radius: 12px !important;
        padding: 8px 12px !important;
    }

    .select2-dropdown-dark .select2-search__field::placeholder {
        color: rgba(148, 163, 184, 0.7) !important;
    }
</style>
@endpush
