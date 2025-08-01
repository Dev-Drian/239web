<div class="fleet-container max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden tab-content hidden"
    id="fleet-tab">
    <!-- Header -->


    <!-- Content -->
    <div class="p-5">
        <!-- Selected Vehicles Section -->
        <div id="selected-vehicles-container" class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-600"></i>Selected Vehicles
            </h3>
            <div id="selected-vehicles-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <!-- Selected vehicles will appear here -->
            </div>
        </div>
        <input type="hidden" name="cars" id="cars-data" value="{{ is_string($client->cars) ? $client->cars : json_encode($client->cars) }}">
    
        <!-- Add Vehicles Section -->
        <div class="mb-6 border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-plus-circle mr-2 text-blue-600"></i>Add New Vehicles
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Standard Vehicle Form -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-3">Standard Vehicle</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Brand</label>
                            <select id="brand-select"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Brand</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Model</label>
                            <select id="model-select"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                disabled>
                                <option value="">Select Model</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Year</label>
                            <select id="year-select"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Color</label>
                            <select id="color-select"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Color</option>
                                <option value="black">Black</option>
                                <option value="white">White</option>
                                <option value="silver">Silver</option>
                                <option value="gray">Gray</option>
                                <option value="blue">Blue</option>
                                <option value="red">Red</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-2 hidden" id="color-other-container">
                            <input type="text" id="color-other-input"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Specify color">
                        </div>
                    </div>
                    <button id="add-vehicle-btn" type="button"
                        class="mt-3 w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition text-sm font-medium">
                        Add Vehicle
                    </button>
                </div>

                <!-- Custom Vehicle Form -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-3">Custom Vehicle</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Brand</label>
                            <input type="text" id="custom-brand"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Enter brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Model</label>
                            <input type="text" id="custom-model"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Enter model">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Year</label>
                            <select id="custom-year"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Color</label>
                            <select id="custom-color"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Color</option>
                                <option value="black">Black</option>
                                <option value="white">White</option>
                                <option value="silver">Silver</option>
                                <option value="gray">Gray</option>
                                <option value="blue">Blue</option>
                                <option value="red">Red</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-2 hidden" id="custom-color-other-container">
                            <input type="text" id="custom-color-other"
                                class="w-full p-2 border rounded text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Specify color">
                        </div>
                    </div>
                    <button id="add-custom-vehicle-btn" type="button"
                        class="mt-3 w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition text-sm font-medium">
                        Add Custom Vehicle
                    </button>
                </div>
            </div>
        </div>


    </div>
</div>

@push('js')
    <script>
        const routeStoreFleet = "{{ route('fleet.store', $client->highlevel_id) }}";
        const clientCars = @json($client->cars);

        // Define all vehicle models by brand
        const fleetData = {
            Cadillac: ['Escalade', 'Lyriq', 'CT4', 'CT5', 'CT6', 'XT5', 'XT6'],
            BMW: ['7 Series', '5 Series', '3 Series', 'X5', 'X7'],
            Mercedes: ['S-Class', 'E-Class', 'GLS', 'GLE', 'V-Class', 'Sprinter', 'Metris'],
            Lincoln: ['Navigator', 'Aviator', 'Corsair', 'Nautilus', 'Continental'],
            Ford: ['Explorer', 'Expedition', 'Transit'],
            'Chevrolet & GMC': ['Suburban', 'Tahoe', 'GMC Yukon'],
            Tesla: ['Model S', 'Model 3', 'Model X', 'Model Y'],
            Volvo: ['S90', 'S60', 'V90', 'V60', 'XC90', 'XC60'],
            'Buses & Minibuses': ['Limo Bus (14 Passengers)', 'Minibus (23 Passengers)', 'Minibus (32 Passengers)',
                'Minibus (35 Passengers)', 'Coach'
            ]
        };

        document.addEventListener('DOMContentLoaded', function() {
            const selectedVehiclesList = document.getElementById('selected-vehicles-list');
            const brandSelect = document.getElementById('brand-select');
            const modelSelect = document.getElementById('model-select');
            const yearSelect = document.getElementById('year-select');
            const colorSelect = document.getElementById('color-select');
            const colorOtherInput = document.getElementById('color-other-input');
            const colorOtherContainer = document.getElementById('color-other-container');
            const addVehicleBtn = document.getElementById('add-vehicle-btn');
            const carsDataInput = document.getElementById('cars-data');

            const customBrand = document.getElementById('custom-brand');
            const customModel = document.getElementById('custom-model');
            const customYear = document.getElementById('custom-year');
            const customColor = document.getElementById('custom-color');
            const customColorOther = document.getElementById('custom-color-other');
            const customColorOtherContainer = document.getElementById('custom-color-other-container');
            const addCustomVehicleBtn = document.getElementById('add-custom-vehicle-btn');

            // Populate brand select
            Object.keys(fleetData).forEach(brand => {
                brandSelect.innerHTML += `<option value="${brand}">${brand}</option>`;
            });

            // Populate year selects (2010-2025)
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 2010; year--) {
                const option = `<option value="${year}">${year}</option>`;
                yearSelect.innerHTML += option;
                customYear.innerHTML += option;
            }

            // Array to store selected vehicles
            let selectedVehicles = [];

            // Function to update the hidden input with current vehicles data
            function updateHiddenInput() {
                const formattedData = {};
                
                selectedVehicles.forEach(vehicle => {
                    if (!formattedData[vehicle.brand]) {
                        formattedData[vehicle.brand] = [];
                    }
                    
                    formattedData[vehicle.brand].push({
                        model: vehicle.model,
                        year: vehicle.year,
                        color: vehicle.color
                    });
                });
                
                carsDataInput.value = JSON.stringify(formattedData);
            }

            // Load saved vehicles if they exist
            if (typeof clientCars !== 'undefined' && clientCars) {
                try {
                    const savedCars = typeof clientCars === 'string' ? JSON.parse(clientCars) : clientCars;

                    // Convert saved object to array of vehicles
                    Object.entries(savedCars).forEach(([brand, models]) => {
                        models.forEach(car => {
                            selectedVehicles.push({
                                brand: brand,
                                model: car.model,
                                year: car.year,
                                color: car.color
                            });
                        });
                    });

                    // Display loaded vehicles
                    renderSelectedVehicles();
                    updateHiddenInput();
                } catch (error) {
                    console.error('Error loading saved car data:', error);
                }
            }

            // Event listener for brand select
            brandSelect.addEventListener('change', function() {
                const selectedBrand = this.value;
                modelSelect.innerHTML = '<option value="">Select Model</option>';

                if (selectedBrand) {
                    modelSelect.disabled = false;
                    fleetData[selectedBrand].forEach(model => {
                        modelSelect.innerHTML += `<option value="${model}">${model}</option>`;
                    });
                } else {
                    modelSelect.disabled = true;
                }
            });

            // Event listeners for color selects
            colorSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    colorOtherContainer.classList.remove('hidden');
                } else {
                    colorOtherContainer.classList.add('hidden');
                    colorOtherInput.value = '';
                }
            });

            customColor.addEventListener('change', function() {
                if (this.value === 'other') {
                    customColorOtherContainer.classList.remove('hidden');
                } else {
                    customColorOtherContainer.classList.add('hidden');
                    customColorOther.value = '';
                }
            });

            // Function to render selected vehicles
            function renderSelectedVehicles() {
                selectedVehiclesList.innerHTML = '';

                if (selectedVehicles.length === 0) {
                    selectedVehiclesList.innerHTML =
                        '<p class="col-span-3 text-gray-500 italic text-sm">No vehicles selected yet</p>';
                    updateHiddenInput();
                    return;
                }

                selectedVehicles.forEach((vehicle, index) => {
                    const vehicleElement = document.createElement('div');
                    vehicleElement.className =
                        'bg-gray-50 border border-gray-200 rounded-lg p-3 flex justify-between items-center shadow-sm';

                    const colorDisplay = vehicle.color ? vehicle.color : 'Not specified';
                    const yearDisplay = vehicle.year ? vehicle.year : 'Not specified';

                    vehicleElement.innerHTML = `
                    <div class="flex-1">
                        <div class="font-medium">${vehicle.brand} ${vehicle.model}</div>
                        <div class="text-xs text-gray-600 mt-1">
                            <span class="inline-block mr-2">
                                <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>${yearDisplay}
                            </span>
                            <span class="inline-block">
                                <i class="fas fa-palette text-gray-400 mr-1"></i>${colorDisplay}
                            </span>
                        </div>
                    </div>
                    <button class="remove-vehicle-btn text-red-500 hover:text-red-700 p-1" data-index="${index}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                    selectedVehiclesList.appendChild(vehicleElement);
                });

                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-vehicle-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        selectedVehicles.splice(index, 1);
                        renderSelectedVehicles();
                        updateHiddenInput();
                    });
                });
                
                updateHiddenInput();
            }

            // Function to add a standard vehicle
            function addStandardVehicle() {
                const brand = brandSelect.value;
                const model = modelSelect.value;
                const year = yearSelect.value;
                let color = colorSelect.value;

                if (color === 'other') {
                    color = colorOtherInput.value;
                }

                if (!brand || !model) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: 'Please select both brand and model',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                selectedVehicles.push({
                    brand: brand,
                    model: model,
                    year: year,
                    color: color
                });

                // Reset form fields
                modelSelect.innerHTML = '<option value="">Select Model</option>';
                modelSelect.disabled = true;
                brandSelect.value = '';
                yearSelect.value = '';
                colorSelect.value = '';
                colorOtherInput.value = '';
                colorOtherContainer.classList.add('hidden');

                renderSelectedVehicles();
                updateHiddenInput();
            }

            // Function to add a custom vehicle
            function addCustomVehicle() {
                const brand = customBrand.value;
                const model = customModel.value;
                const year = customYear.value;
                let color = customColor.value;

                if (color === 'other') {
                    color = customColorOther.value;
                }

                if (!brand || !model) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: 'Please enter both brand and model',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                selectedVehicles.push({
                    brand: brand,
                    model: model,
                    year: year,
                    color: color
                });

                // Reset form fields
                customBrand.value = '';
                customModel.value = '';
                customYear.value = '';
                customColor.value = '';
                customColorOther.value = '';
                customColorOtherContainer.classList.add('hidden');

                renderSelectedVehicles();
                updateHiddenInput();
            }

            // Event listeners for add buttons
            addVehicleBtn.addEventListener('click', addStandardVehicle);
            addCustomVehicleBtn.addEventListener('click', addCustomVehicle);

            // If you're using AJAX to submit via a custom route
            if (typeof routeStoreFleet !== 'undefined') {
                // Add function to save fleet data separately
                window.saveFleetData = function() {
                    if (selectedVehicles.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Vehicles Selected',
                            text: 'No vehicle data to save',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }

                    fetch(routeStoreFleet, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                cars: carsDataInput.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Fleet Saved',
                                    text: 'Vehicle information has been saved successfully',
                                    confirmButtonColor: '#3b82f6'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message ||
                                        'There was an error saving the fleet data',
                                    confirmButtonColor: '#3b82f6'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error saving fleet data:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error saving the fleet data',
                                confirmButtonColor: '#3b82f6'
                            });
                        });
                };
            }
        });
    </script>
@endpush
