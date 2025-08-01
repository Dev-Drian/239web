<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Tracker Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/lucide-icons@0.317.0/dist/lucide-icons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            border-color: #e2e8f0;
            border-radius: 0.375rem;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-slide-down {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .gradient-btn {
            background: linear-gradient(45deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .black-btn {
            background: black;
            color: white;
        }

        .active-filter {
            background-color: #3b82f6;
            color: white;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .active-filter button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.65rem;
            padding: 0;
        }

        .active-filter button:hover {
            opacity: 0.8;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Colores para el estado del vuelo */
        .status-landed {
            color: #10b981;
            /* Verde */
        }

        .status-scheduled {
            color: #3b82f6;
            /* Azul */
        }

        .status-en-route {
            color: #f59e0b;
            /* Amarillo */
        }

        .status-cancelled {
            color: #ef4444;
            /* Rojo */
        }
    </style>
</head>

<body class="bg-white min-h-screen">
    <div class="container mx-auto p-4 space-y-4">
        <h1 class="text-2xl font-bold text-gray-900 mb-4 text-center animate-fade-in">
            <i data-lucide="airplane" class="inline-block mr-2 text-blue-600"></i>
            Flight Tracker Dashboard
        </h1>

        <!-- Filtros -->
        <div class="bg-white shadow-sm rounded-lg p-4 mb-4 animate-slide-down">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Search Filters</h2>

            <div class="grid grid-cols-2 gap-3">
                <!-- Direction Filter -->
                <div class="transition-all hover:shadow-md p-2 rounded-lg border border-gray-200">
                    <label class="block text-xs font-medium text-gray-700 mb-1 flex items-center">
                        <i data-lucide="plane" class="mr-1 text-blue-500"></i>Flight Direction
                    </label>
                    <div class="flex space-x-2">
                        <label class="inline-flex items-center transition-all hover:text-gray-900">
                            <input type="radio" name="direction" value="inbound"
                                class="form-radio text-gray-700 focus:ring-gray-500" checked>
                            <span class="ml-1 text-xs">Inbound</span>
                        </label>
                        <label class="inline-flex items-center transition-all hover:text-gray-900">
                            <input type="radio" name="direction" value="outbound"
                                class="form-radio text-gray-700 focus:ring-gray-500">
                            <span class="ml-1 text-xs">Outbound</span>
                        </label>
                    </div>
                </div>

                <!-- Flight ICAO Filter -->
                <div class="transition-all hover:shadow-md p-2 rounded-lg border border-gray-200">
                    <label for="flight_icao" class="block text-xs font-medium text-gray-700 mb-1 flex items-center">
                        <i data-lucide="code" class="mr-1 text-blue-500"></i>Flight ICAO
                    </label>
                    <input type="text" id="flight_icao"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition-all text-xs"
                        placeholder="Enter flight ICAO">
                </div>

                <!-- Airport Filter -->
                <div class="transition-all hover:shadow-md p-2 rounded-lg border border-gray-200">
                    <label for="airportSelect" class="block text-xs font-medium text-gray-700 mb-1 flex items-center">
                        <i data-lucide="map-pin" class="mr-1 text-blue-500"></i>Airport
                    </label>
                    <select id="airportSelect"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition-all text-xs">
                        <option value="">Select an airport</option>
                    </select>
                </div>

                <!-- Airline Filter -->
                <div class="transition-all hover:shadow-md p-2 rounded-lg border border-gray-200">
                    <label for="airlineSelect" class="block text-xs font-medium text-gray-700 mb-1 flex items-center">
                        <i data-lucide="cloud" class="mr-1 text-blue-500"></i>Airline
                    </label>
                    <select id="airlineSelect"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition-all text-xs">
                        <option value="">Select an airline</option>
                    </select>
                </div>
            </div>

            <!-- Active Filters -->
            <div id="activeFilters" class="mt-4 p-2 bg-gray-50 rounded-lg hidden animate-fade-in">
                <h3 class="text-xs font-medium text-gray-700 mb-1">Active Filters:</h3>
                <div id="activeFiltersList" class="flex flex-wrap gap-1"></div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex space-x-2 justify-center">
                <button id="fetchFlightsBtn"
                    class="gradient-btn font-bold py-1 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 text-xs">
                    <i data-lucide="search" class="inline-block mr-1"></i>Fetch Flights
                </button>
                <button id="clearFiltersBtn"
                    class="black-btn font-bold py-1 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 text-xs">
                    <i data-lucide="x-circle" class="inline-block mr-1"></i>Clear Filters
                </button>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="hidden">
            <div class="loader"></div>
        </div>

        <!-- Flights Table -->
        <div id="flightsContainer" class="bg-white shadow-sm rounded-lg overflow-hidden animate-fade-in">
            <table id="flightsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Flight Number</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Flight ICAO</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Airline IATA</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Departure IATA</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Arrival IATA</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody id="flightsTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Flight rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/lucide@0.317.0/dist/umd/lucide.min.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        $(document).ready(function() {
            $('#airportSelect, #airlineSelect').select2({
                ajax: {
                    url: function() {
                        return this.attr('id') === 'airportSelect' ? '{{ route('api.airports') }}' :
                            '{{ route('api.airlines') }}';
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page
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
                },
                placeholder: 'Select an option',
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return $("<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__title'>" + repo.text + "</div></div>");
            }

            function formatRepoSelection(repo) {
                return repo.text;
            }

            // Validar que se seleccione una dirección si se elige un aeropuerto
            $('#airportSelect').on('change', function() {
                const airportSelected = $(this).val();
                if (airportSelected && !$('input[name="direction"]:checked').val()) {
                    alert(
                        'Please select a flight direction (Inbound or Outbound) when choosing an airport.'
                    );
                    $(this).val(null).trigger('change'); // Limpiar selección
                }
            });

            // Actualizar filtros activos
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
                    $('#activeFilters').removeClass('hidden').addClass('animate-fade-in');
                    activeFilters.forEach(filter => {
                        const filterElement = $(
                            `<span class="active-filter">${filter}<button onclick="removeFilter('${filter}')">×</button></span>`
                        );
                        filtersList.append(filterElement);
                    });
                } else {
                    $('#activeFilters').addClass('hidden');
                }
            }

            // Eliminar un filtro activo
            window.removeFilter = function(filter) {
                const filterText = filter.split(': ')[1];
                if (filter.includes('Direction')) {
                    $('input[name="direction"]').prop('checked', false);
                } else if (filter.includes('Flight ICAO')) {
                    $('#flight_icao').val('');
                } else if (filter.includes('Airline')) {
                    $('#airlineSelect').val(null).trigger('change');
                } else if (filter.includes('Airport')) {
                    $('#airportSelect').val(null).trigger('change');
                }
                updateActiveFilters();
            };

            // Limpiar todos los filtros
            function clearFilters() {
                $('input[name="direction"]').prop('checked', false);
                $('#flight_icao').val('');
                $('#airlineSelect, #airportSelect').val(null).trigger('change');
                updateActiveFilters();
            }

            // Fetch flights
            async function fetchFlights() {
                const direction = $('input[name="direction"]:checked').val();
                const flightIcao = $('#flight_icao').val();
                const airlineIata = $('#airlineSelect').val();
                const airportIata = $('#airportSelect').val();

                const params = {};
                if (direction && airportIata) {
                    params.direction = direction;
                    params.airportIata = airportIata;
                }
                if (airlineIata) params.airline_iata = airlineIata;
                if (flightIcao) params.flight_icao = flightIcao;

                try {
                    // Show loader
                    $('#loader').removeClass('hidden');
                    $('#flightsContainer').addClass('hidden');

                    const response = await fetch('{{ route('get-flights') }}?' + new URLSearchParams(params));
                    const flights = await response.json();

                    if (!response.ok) throw new Error(flights.error || 'Failed to fetch flights');

                    const flightsTableBody = document.getElementById('flightsTableBody');
                    flightsTableBody.innerHTML = '';

                    if (!flights || flights.length === 0) {
                        flightsTableBody.innerHTML =
                            '<tr><td colspan="8" class="px-4 py-2 text-sm text-gray-500 text-center">No flights found.</td></tr>';
                        return;
                    }

                    flights.forEach((flight, index) => {
                        const flightRow = document.createElement('tr');
                        flightRow.className = 'transition-all hover:bg-gray-50';
                        flightRow.innerHTML = `
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">${flight.flight_number || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">${flight.flight_icao || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">${flight.airline_iata || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">${flight.dep_icao || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">${flight.arr_icao || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs ${getStatusClass(flight.status)}">${flight.status || '-'}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">
                                <button class="gradient-btn font-bold py-1 px-3 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 text-xs" onclick="showFlight('${flight.flight_icao}', '${flight.flight_iata}')">
                                    Show Flight
                                </button>
                            </td>
                         `
                        flightRow.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s both`;
                        flightsTableBody.appendChild(flightRow);
                    });
                } catch (error) {
                    console.error('Error fetching flights:', error);
                    document.getElementById('flightsTableBody').innerHTML = `
                                        <tr>
                            <td colspan="8" class="px-4 py-2 text-sm text-red-500 text-center">
                                Error: ${error.message}
                            </td>
                        </tr>
                    `;
                } finally {
                    // Hide loader
                    $('#loader').addClass('hidden');
                    $('#flightsContainer').removeClass('hidden');
                }
            }

            // Show flight
            window.showFlight = function(flightIcao, flightIata) {
                const params = new URLSearchParams();
                if (flightIcao) params.append('flight_icao', flightIcao);
                if (flightIata) params.append('flight_iata', flightIata);

                window.location.href = '{{ route('guest.request.info', $id) }}?' + params.toString();
            };

            // Event listeners
            $('input[name="direction"], #flight_icao, #airlineSelect, #airportSelect').on('change',
                updateActiveFilters);
            $('#fetchFlightsBtn').on('click', fetchFlights);
            $('#clearFiltersBtn').on('click', clearFilters);

            // Initialize active filters on page load
            updateActiveFilters();
        });

        function getStatusClass(status) {
            switch (status) {
                case 'landed':
                    return 'status-landed';
                case 'scheduled':
                    return 'status-scheduled';
                case 'en-route':
                    return 'status-en-route';
                case 'cancelled':
                    return 'status-cancelled';
                default:
                    return '';
            }
        }
    </script>
</body>

</html>
