<form id="service-form" method="POST">
    @csrf <!-- CSRF token for security -->
    <div class="form-step hidden animate__animated" id="step-2">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-map-marked-alt mr-3"></i>Service Areas
                </h2>
                <p class="text-blue-100 mt-1">Search for your city, hit Enter, and wait a bit until it populates.</p>
            </div>
            <!-- City Search Section -->
            <div class="p-6">
                <div class="relative mb-6">
                    <!-- Select2 Dropdown -->
                    <select id="location"
                        class="block w-full pl-10 pr-10 py-3 text-base text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm appearance-none transition-all hover:border-gray-400">
                        <option value="" selected disabled>Select a location</option>
                        <!-- Options will be loaded dynamically -->
                    </select>
                    <!-- Search Icon -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <!-- Loader (placed below the Select2 dropdown) -->
                <div id="loader" class="flex justify-center items-center my-4 hidden">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-8 w-8"></div>
                </div>

                <!-- Content Below Search (hidden by default) -->
                <div id="content-below-search" class="hidden">
                    <!-- Dentro del div con id="content-below-search", después de las secciones de ciudades y aeropuertos -->

                    <!-- Cities Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-city mr-2 text-blue-600"></i>Cities
                        </h3>
                        <div id="cities-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- City items will be loaded dynamically -->
                        </div>
                        <p id="no-cities-message" class="text-gray-500 text-sm mt-2 hidden">No cities available.</p>

                        <!-- Añade este textarea para ciudades adicionales -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                Additional Airports
                                <div class="relative ml-2 group">
                                    <i class="fas fa-info-circle text-blue-400 cursor-pointer"></i>
                                    <div
                                        class="absolute z-10 hidden group-hover:block w-64 p-3 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg text-xs left-0">
                                        <p class="font-medium text-gray-800 mb-1">Required Format:</p>
                                        <p class="text-gray-600">• <span class="font-mono bg-gray-100 px-1">IATA - Full
                                                Airport Name</span></p>
                                        <p class="text-gray-600 mt-1">Example: <span
                                                class="font-mono bg-gray-100 px-1">JFK - John F. Kennedy Airport</span>
                                        </p>
                                        <p class="text-gray-600 mt-2">• Separate with commas <strong>or</strong> new
                                            lines</p>
                                        <p class="text-gray-600">• One airport per line</p>
                                    </div>
                                </div>
                            </label>


                            <textarea name="extra_cities"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter additional cities, separated by commas..." rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Airports Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-plane mr-2 text-blue-600"></i>Airports and Ports
                        </h3>
                        <div id="airports-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Airport items will be loaded dynamically -->
                        </div>
                        <p id="no-airports-message" class="text-gray-500 text-sm mt-2 hidden">No airports available.</p>

                        <!-- Añade este textarea para aeropuertos adicionales -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                Additional Airports
                                <div class="relative ml-2 group">
                                    <i class="fas fa-info-circle text-blue-400 cursor-pointer"></i>
                                    <div
                                        class="absolute z-10 hidden group-hover:block w-64 p-3 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg text-xs left-0">
                                        <p class="font-medium text-gray-800 mb-1">Required Format:</p>
                                        <p class="text-gray-600">• <span class="font-mono bg-gray-100 px-1">IATA</span>
                                        </p>
                                        <p class="text-gray-600 mt-1">Example: <span
                                                class="font-mono bg-gray-100 px-1">JFK </span></p>
                                        <p class="text-gray-600 mt-2">• Separate with commas <strong>or</strong> new
                                            lines</p>
                                        <p class="text-gray-600">• One airport per line</p>
                                    </div>
                                </div>
                            </label>

                            <textarea name="extra_airports"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter additional airports with their IATA codes (e.g., JFK - John F. Kennedy Airport)..."
                                rows="2"></textarea>
                        </div>
                    </div>


                    <!-- Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-concierge-bell mr-2 text-blue-600"></i>Available Services
                        </h3>
                        <div id="services-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Services will be generated dynamically here -->
                        </div>
                    </div>
                    <!-- Additional Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-plus-circle mr-2 text-blue-600"></i>Additional Services
                        </h3>
                        <textarea name="extra_service"
                            class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Describe other services you offer..." rows="3"></textarea>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-4">
                        <button
                            class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition duration-200 shadow-md flex-1 flex items-center justify-center"
                            data-prev="1">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        <button type="submit"
                            class="next-step bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 shadow-md flex-1 flex items-center justify-center"
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
    <script>
        document.getElementById('service-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Recopila los valores seleccionados
            const selectedCities = Array.from(document.querySelectorAll('input[name="cities[]"]:checked')).map(
                input => input.value);
            const selectedAirports = Array.from(document.querySelectorAll('input[name="airports[]"]:checked')).map(
                input => input.value);
            const selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked')).map(
                input => input.value);
            const extraService = document.querySelector('textarea[name="extra_service"]').value;

            // Nuevos campos adicionales
            const extraCities = document.querySelector('textarea[name="extra_cities"]').value;
            const extraAirports = document.querySelector('textarea[name="extra_airports"]').value;

            // Prepara los datos para enviar
            const data = {
                city: cityMain,
                areas: selectedCities,
                airports: selectedAirports,
                services: selectedServices,
                extra_service: extraService,
                extra_cities: extraCities, // Añade las ciudades adicionales
                extra_airports: extraAirports // Añade los aeropuertos adicionales
            };

            console.log(data);

            // Resto del código de envío permanece igual...
            fetch(routeStoreArea, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(
                                `Server error: ${response.status} - ${JSON.stringify(errorData)}`);
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

            // Contenedor donde se insertarán los servicios
            const servicesContainer = $('#services-container');

            // Generar dinámicamente los servicios
            services.forEach(service => {
                // Crear el valor para el atributo "value" del input (en minúsculas y sin espacios)
                const value = service.toLowerCase().replace(/ /g, '_');

                // Crear el HTML para cada servicio
                const serviceHTML = `
            <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer">
                <input type="checkbox" name="services[]" value="${value}" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3">
                <span class="text-gray-800">${service}</span>
            </label>
        `;

                // Insertar el servicio en el contenedor
                servicesContainer.append(serviceHTML);
            });


            $('#location').select2({
                placeholder: "Search for a city or airport...",
                allowClear: true,
                width: '100%',
                dropdownCssClass: "select2-dropdown-custom",
                minimumInputLength: 3,
                theme: "classic",
                ajax: {
                    url: "https://portal.crm.limo/api/pruebas", // Asegúrate de que esta ruta sea correcta
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // Coincide con $request->get('q') en el backend
                            page: params.page || 1 // Paginación
                        };
                    },
                    processResults: function(data, params) {
                        console.log("API Response:",
                        data); // Depuración: Verifica la respuesta de la API

                        // Validar que los datos tengan la estructura esperada
                        if (!data || !data.data || !data.data.locations) {
                            console.error("Invalid API response structure");
                            return {
                                results: [],
                                pagination: {
                                    more: false
                                }
                            };
                        }

                        return {
                            results: data.data.locations.map(function(location) {
                                return {
                                    id: location.id,
                                    text: `${location.name}, ${location.state_code}` // Formato: "Ciudad, Código de Estado"
                                };
                            }),
                            pagination: {
                                more: (data.data.info.total_locations > (params.page || 1) * 30)
                            }
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error); // Manejo de errores
                    },
                    cache: false
                },
                language: {
                    searching: function() {
                        return "Searching...";
                    },
                    noResults: function() {
                        return "No results found";
                    },
                    inputTooShort: function() {
                        return "Please enter 3 or more characters";
                    }
                },
                templateResult: function(item) {
                    if (!item.id) return item.text;
                    return $('<span>' + item.text + '</span>');
                },
                templateSelection: function(item) {
                    return item.text || item.id;
                }
            });

            $('#location').on('select2:select', function(e) {
                console.log("Selected:", e.params.data);
                const selectedCity = e.params.data.text; // Formato: "Ciudad, Código de Estado"
                if (selectedCity) {
                    const [city, stateCode] = selectedCity.split(',').map(item => item
                .trim()); // Divide y limpia
                    console.log("City:", city);
                    console.log("State Code:", stateCode);
                    cityMain = selectedCity; // Guarda el texto seleccionado
                } else {
                    console.error("Invalid selection data");
                }
            });
            // Enhanced styling for Select2
            function styleSelect2() {
                $('.select2-container--classic .select2-selection--single').css({
                    'height': '50px',
                    'padding-top': '10px',
                    'padding-left': '30px',
                    'border-radius': '8px',
                    'box-shadow': '0 1px 3px rgba(0,0,0,0.1)',
                    'border': '1px solid #d1d5db',
                    'transition': 'all 0.3s ease'
                });

                // Add hover effect
                $('.select2-container--classic').hover(function() {
                    $(this).find('.select2-selection--single').css('border-color', '#93c5fd');
                }, function() {
                    $(this).find('.select2-selection--single').css('border-color', '#d1d5db');
                });
            }

            // Call styling function
            styleSelect2();

            // Format options
            function formatLocationOption(location) {
                if (!location.id) return location.text;
                return $(`<div class="flex items-center py-1">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    <span>${location.text}</span>
                </div>`);
            }

            function formatLocationSelection(location) {
                if (!location.id) return location.text;
                return $(`<div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    <span>${location.text}</span>
                </div>`);
            }

            // Handle selection event
            $('#location').on('select2:select', function(e) {
                const selectedCity = e.params.data.id; // Get the selected city

                // Disable the select and show the loader
                $('#location').prop('disabled', true);
                $('#loader').removeClass('hidden');

                // Send POST request to the route
                fetch(routeGenerateCityAndAiport, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            city: cityMain
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.data) {
                            // Show the content below the search
                            $('#content-below-search').removeClass('hidden');

                            // Clear containers before adding new data
                            $('#cities-container').empty();
                            $('#airports-container').empty();

                            // Display cities
                            if (data.data.cities.length > 0) {
                                data.data.cities.forEach(city => {
                                    $('#cities-container').append(`
                                        <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer group">
                                            <input type="checkbox" name="cities[]" value="${city}"
                                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3">
                                            <div class="flex flex-col">
                                                <span class="text-gray-800 font-medium group-hover:text-blue-700">${city}</span>
                                            </div>
                                        </label>
                                    `);
                                });
                                $('#no-cities-message').addClass('hidden');
                            } else {
                                $('#no-cities-message').removeClass('hidden');
                            }

                            // Display airports
                            if (data.data.airports.length > 0) {
                                data.data.airports.forEach(airport => {
                                    $('#airports-container').append(`
                                        <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer group">
                                            <input type="checkbox" name="airports[]" value="${airport.IATA_code}"
                                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3">
                                            <div class="flex flex-col">
                                                <span class="text-gray-800 font-medium group-hover:text-blue-700">${airport.name}</span>
                                                <span class="text-gray-500 text-sm">IATA Code: ${airport.IATA_code}</span>
                                            </div>
                                            <span class="ml-auto text-xl text-blue-600">
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
                        // Enable the select and hide the loader
                        $('#location').prop('disabled', false);
                        $('#loader').addClass('hidden');
                    });
            });
        });
    </script>
@endpush

<!-- Loader Animation Styles -->
<style>
    .loader {
        border-top-color: #3498db;
        -webkit-animation: spinner 1.5s linear infinite;
        animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
