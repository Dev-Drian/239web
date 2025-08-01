<!-- filepath: /c:/xampp/htdocs/limo-partner/resources/views/airlabs/request.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Airlines and Airports Selection') }}
        </h2>
    </x-slot>

    <div>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Select Filters') }}</h3>

                <!-- Flight Direction -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Flight Direction') }}</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="direction" value="inbound"
                                class="form-radio h-4 w-4 text-indigo-600">
                            <span class="ml-2">Inbound</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="direction" value="outbound"
                                class="form-radio h-4 w-4 text-indigo-600">
                            <span class="ml-2">Outbound</span>
                        </label>
                    </div>
                </div>

                <!-- Flight Number Filter -->
                <div class="form-group">
                    <label for="flight_icao">Flight ICAO (opcional):</label>
                    <input type="text" class="form-control" id="flight_icao" name="flight_icao"
                        placeholder="Filtrar por número de código ICAO de vuelo">
                </div>

                <!-- Airport Select -->
                <div class="mb-4">
                    <label for="airportSelect"
                        class="block text-sm font-medium text-gray-700">{{ __('Airports') }}</label>
                    <select id="airportSelect"
                        class="select2 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Select an airport</option>
                    </select>
                </div>

                <!-- Airline Select -->
                <div class="mb-4">
                    <label for="airlineSelect"
                        class="block text-sm font-medium text-gray-700">{{ __('Airlines') }}</label>
                    <select id="airlineSelect"
                        class="select2 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Select an airline</option>
                    </select>
                </div>

                <!-- Applied Filters Display -->
                <div id="activeFilters" class="mb-4 p-3 bg-gray-50 rounded-md hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Active Filters:</h4>
                    <div id="activeFiltersList" class="flex flex-wrap gap-2">
                        <!-- Active filters will be displayed here -->
                    </div>
                </div>

                <div class="mb-4">
                    <button id="fetchFlightsBtn"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Fetch Flights') }}
                    </button>
                    <button id="clearFiltersBtn"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Clear Filters') }}
                    </button>
                </div>

                <!-- Container to display flights -->
                <div id="flightsContainer" class="mt-4">
                    <table id="flightsTable" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Flight Number</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Flight ICAO</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Flight IATA</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Airline IATA</th>

                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Departure IATA</th>

                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Arrival IATA</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody id="flightsTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Flight rows will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#airportSelect').select2({
                ajax: {
                    url: '{{ route('api.airports') }}', // URL de tu endpoint para obtener los datos
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // término de búsqueda
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Select an airport',
                minimumInputLength: 1,
                templateResult: formatRepo, // función para formatear los resultados
                templateSelection: formatRepoSelection // función para formatear la selección
            });

            $('#airlineSelect').select2({
                ajax: {
                    url: '{{ route('api.airlines') }}', // URL de tu endpoint para obtener los datos
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // término de búsqueda
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Select an airline',
                minimumInputLength: 1,
                templateResult: formatRepo, // función para formatear los resultados
                templateSelection: formatRepoSelection // función para formatear la selección
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.text);

                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.text;
            }

            function updateActiveFilters() {
                const activeFilters = [];
                const direction = $('input[name="direction"]:checked').val();
                const flightIcao = $('#flight_icao').val();
                const airlineIata = $('#airlineSelect').val();
                const airportIata = $('#airportSelect').val();

                if (direction) activeFilters.push(`Direction: ${direction}`);
                if (flightIcao) activeFilters.push(`Flight ICAO: ${flightIcao}`);
                if (airlineIata) activeFilters.push(`Airline: ${airlineIata}`);
                if (airportIata) activeFilters.push(`Airport: ${airportIata}`);

                const filtersList = $('#activeFiltersList');
                filtersList.empty();

                if (activeFilters.length > 0) {
                    $('#activeFilters').removeClass('hidden');
                    activeFilters.forEach(filter => {
                        filtersList.append(`
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                ${filter}
                            </span>
                        `);
                    });
                } else {
                    $('#activeFilters').addClass('hidden');
                }
            }

            function clearFilters() {
                $('input[name="direction"]').prop('checked', false);
                $('#flight_icao').val('');
                $('#airlineSelect').val(null).trigger('change');
                $('#airportSelect').val(null).trigger('change');
                updateActiveFilters();
            }

            async function fetchFlights() {
                const direction = $('input[name="direction"]:checked').val();
                const flightIcao = $('#flight_icao').val();
                const airlineIata = $('#airlineSelect').val();
                const airportIata = $('#airportSelect').val();

                // Solo agregamos parámetros si tienen valores
                const params = {};

                if (direction && airportIata) {
                    params.direction = direction;
                    params.airportIata = airportIata;
                }

                if (airlineIata) {
                    params.airline_iata = airlineIata;
                }

                if (flightIcao) {
                    params.flight_icao = flightIcao;
                }

                // Log para debug
                console.log('Sending request with params:', params);

                try {
                    const response = await fetch('{{ route('get-flights') }}?' + new URLSearchParams(params));
                    const flights = await response.json();

                    if (!response.ok) {
                        throw new Error(flights.error || 'Failed to fetch flights');
                    }

                    console.log('Received flights:', flights);

                    const flightsTableBody = document.getElementById('flightsTableBody');
                    flightsTableBody.innerHTML = '';

                    if (!flights || flights.length === 0) {
                        flightsTableBody.innerHTML =
                            '<tr><td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">No flights found.</td></tr>';
                        return;
                    }

                    flights.forEach(flight => {
                        const flightRow = document.createElement('tr');
                        flightRow.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.flight_number || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.flight_icao || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.flight_iata || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.airline_iata || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.dep_icao || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.arr_icao || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${flight.status || '-'}</td>
                        `;
                        flightsTableBody.appendChild(flightRow);
                    });
                } catch (error) {
                    console.error('Error fetching flights:', error);
                    // Mostrar error al usuario
                    const flightsTableBody = document.getElementById('flightsTableBody');
                    flightsTableBody.innerHTML = `
                        <tr>
                            <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                Error: ${error.message}
                            </td>
                        </tr>
                    `;
                }
            }

            // Event listeners
            $('input[name="direction"], #flight_icao, #airlineSelect, #airportSelect').on('change', updateActiveFilters);
            $('#fetchFlightsBtn').on('click', fetchFlights);
            $('#clearFiltersBtn').on('click', clearFilters);
        });
    </script>
</x-app-layout>