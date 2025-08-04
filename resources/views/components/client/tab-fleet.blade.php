<div class="fleet-container max-w-6xl mx-auto glass-dark rounded-xl shadow-lg overflow-hidden tab-content hidden"
    id="fleet-tab">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4 flex flex-col">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fas fa-car mr-3"></i> Fleet Management
        </h2>
        <p class="text-indigo-100 mt-1">Manage your fleet vehicles and add new ones</p>
    </div>

    <!-- Content -->
    <div class="p-6">
        <!-- Selected Vehicles Section -->
        <div id="selected-vehicles-container" class="mb-6">
            <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-400"></i>Selected Vehicles
            </h3>
            <div id="selected-vehicles-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <!-- Selected vehicles will appear here -->
            </div>
        </div>
        <input type="hidden" name="cars" id="cars-data" value="{{ is_string($client->cars) ? $client->cars : json_encode($client->cars) }}">
    
        <!-- Vehicle Selection Section -->
        <div class="mb-6 border-t border-white/15 pt-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-list mr-2 text-indigo-400"></i>Select Your Fleet Vehicles
            </h3>

            <!-- Vehicle Selection Grid -->
            <div id="vehicle-selection-container" class="space-y-6">
                <!-- Vehicle brands will be generated here -->
            </div>
        </div>

        <!-- Custom Vehicle Section -->
        <div class="mb-6 border-t border-white/15 pt-6">
            <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                <i class="fas fa-plus-circle mr-2 text-green-400"></i>Add Custom Vehicle
            </h3>
            <div class="glass rounded-lg p-4 border border-white/20">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Brand</label>
                        <input type="text" id="custom-brand"
                            class="w-full p-2 glass border border-white/20 rounded text-sm bg-transparent text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            placeholder="Enter brand">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Model</label>
                        <input type="text" id="custom-model"
                            class="w-full p-2 glass border border-white/20 rounded text-sm bg-transparent text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            placeholder="Enter model">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Year</label>
                        <select id="custom-year"
                            class="w-full p-2 glass border border-white/20 rounded text-sm bg-transparent text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            <option value="">Select Year</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Color</label>
                        <select id="custom-color"
                            class="w-full p-2 glass border border-white/20 rounded text-sm bg-transparent text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
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
                    <div class="col-span-2 md:col-span-4 hidden" id="custom-color-other-container">
                        <input type="text" id="custom-color-other" class="w-full p-2 glass border border-white/20 rounded text-sm bg-transparent text-white placeholder-slate-400" placeholder="Specify color">
                    </div>
                </div>
                <button id="add-custom-vehicle-btn" type="button"
                    class="mt-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white py-2 px-4 rounded hover:from-green-600 hover:to-emerald-600 transition text-sm font-medium">
                    Add Custom Vehicle
                </button>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end mt-6">
            <button id="save-fleet-btn" type="button"
                class="bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200 shadow-md flex items-center">
                <i class="fas fa-save mr-2"></i> Save Fleet
            </button>
        </div>
    </div>
</div>

@push('js')
    <script>
        const routeStoreFleet = "{{ route('fleet.store', $client->highlevel_id) }}";
        const clientCars = @json($client->cars);

        // Define all vehicle models by brand with categories
        const fleetData = {
            Cadillac: ['Escalade', 'Lyriq', 'CT4', 'CT5', 'CT6', 'XT5', 'XT6'],
            BMW: ['7 Series', '5 Series', '3 Series', 'X5', 'X7'],
            Mercedes: ['S-Class', 'E-Class', 'GLS', 'GLE', 'V-Class', 'Sprinter', 'Metris'],
            Lincoln: ['Navigator', 'Aviator', 'Corsair', 'Nautilus', 'Continental'],
            Ford: ['Explorer', 'Expedition', 'Transit', '14 passenger Limo Bus', '23 Passengers Minibus', '32 Passengers Minibus', '35 Passengers Minibus'],
            'Chevrolet & GMC': ['Suburban', 'Tahoe', 'GMC Yukon'],
            Tesla: ['Model S', 'Model 3', 'Model X', 'Model Y'],
            Volvo: ['S90', 'S60', 'V90', 'V60', 'XC90', 'XC60'],
            Coaches: ['Coach']
        };

        document.addEventListener('DOMContentLoaded', function() {
            const selectedVehiclesList = document.getElementById('selected-vehicles-list');
            const vehicleSelectionContainer = document.getElementById('vehicle-selection-container');
            const customYear = document.getElementById('custom-year');
            const customColor = document.getElementById('custom-color');
            const customColorOther = document.getElementById('custom-color-other');
            const customColorOtherContainer = document.getElementById('custom-color-other-container');
            const addCustomVehicleBtn = document.getElementById('add-custom-vehicle-btn');
            const saveFleetBtn = document.getElementById('save-fleet-btn');
            const carsDataInput = document.getElementById('cars-data');

            // Populate year select (2010-2025)
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 2010; year--) {
                customYear.innerHTML += `<option value="${year}">${year}</option>`;
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
                return formattedData;
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

            // Generate vehicle selection grid
            function generateVehicleGrid() {
                vehicleSelectionContainer.innerHTML = '';
                
                Object.entries(fleetData).forEach(([brand, models]) => {
                    const brandSection = document.createElement('div');
                    brandSection.className = 'glass-dark border border-white/15 rounded-lg p-4 shadow-sm mb-4';
                    
                    brandSection.innerHTML = `
                        <h4 class="font-semibold text-lg text-white mb-3 flex items-center">
                            <i class="fas fa-car mr-2 text-indigo-400"></i>${brand}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            ${models.map(model => `
                                <div class="vehicle-option glass border border-white/20 rounded-lg p-3 transition-all duration-300"
                                     data-brand="${brand}" data-model="${model}">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-white">${model}</span>
                                        <input type="checkbox" class="vehicle-checkbox ml-2" 
                                               data-brand="${brand}" data-model="${model}">
                                    </div>
                                    <div class="vehicle-details hidden opacity-0 transform translate-y-2 transition-all duration-300 ease-out">
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-medium text-slate-300 mb-1">Year</label>
                                                <select class="vehicle-year w-full p-1 glass border border-white/20 rounded text-xs bg-transparent text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                                        data-brand="${brand}" data-model="${model}">
                                                    ${Array.from({length: 16}, (_, i) => currentYear - i).map(year => 
                                                        `<option value="${year}" ${year === currentYear ? 'selected' : ''}>${year}</option>`
                                                    ).join('')}
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-slate-300 mb-1">Color</label>
                                                <select class="vehicle-color w-full p-1 glass border border-white/20 rounded text-xs bg-transparent text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                                        data-brand="${brand}" data-model="${model}">
                                                    <option value="black" selected>Black</option>
                                                    <option value="white">White</option>
                                                    <option value="silver">Silver</option>
                                                    <option value="gray">Gray</option>
                                                    <option value="blue">Blue</option>
                                                    <option value="red">Red</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="vehicle-color-other hidden mt-2">
                                            <input type="text" class="vehicle-color-other-input w-full p-1 glass border border-white/20 rounded text-xs bg-transparent text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                                   placeholder="Specify color" data-brand="${brand}" data-model="${model}">
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                    
                    vehicleSelectionContainer.appendChild(brandSection);
                });

                // Add event listeners to vehicle options
                document.querySelectorAll('.vehicle-option').forEach(option => {
                    const checkbox = option.querySelector('.vehicle-checkbox');
                    const details = option.querySelector('.vehicle-details');
                    
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            option.classList.add('border-indigo-500', 'bg-indigo-500/10');
                            details.classList.remove('hidden');
                            // Trigger animation after a small delay
                            setTimeout(() => {
                                details.classList.remove('opacity-0', 'translate-y-2');
                            }, 50);
                            addVehicleFromSelectors(this.dataset.brand, this.dataset.model);
                        } else {
                            // Remove all selection styles completely
                            option.classList.remove('border-indigo-500', 'bg-indigo-500/10');
                            option.style.borderColor = '';
                            option.style.backgroundColor = '';
                            option.style.removeProperty('border-color');
                            option.style.removeProperty('background-color');
                            details.classList.add('opacity-0', 'translate-y-2');
                            setTimeout(() => {
                                details.classList.add('hidden');
                            }, 300);
                            
                            // Force a re-render to clear any remaining styles
                            option.offsetHeight;
                            removeVehicle(this.dataset.brand, this.dataset.model);
                        }
                    });
                });

                // Add event listeners for year and color changes
                document.querySelectorAll('.vehicle-year, .vehicle-color').forEach(selector => {
                    selector.addEventListener('change', function() {
                        const brand = this.dataset.brand;
                        const model = this.dataset.model;
                        updateVehicleDetails(brand, model);
                    });
                });

                // Add event listeners for color other input
                document.querySelectorAll('.vehicle-color').forEach(colorSelect => {
                    colorSelect.addEventListener('change', function() {
                        const brand = this.dataset.brand;
                        const model = this.dataset.model;
                        const colorOtherContainer = this.closest('.vehicle-option').querySelector('.vehicle-color-other');
                        
                        if (this.value === 'other') {
                            colorOtherContainer.classList.remove('hidden');
                        } else {
                            colorOtherContainer.classList.add('hidden');
                        }
                        
                        updateVehicleDetails(brand, model);
                    });
                });

                document.querySelectorAll('.vehicle-color-other-input').forEach(input => {
                    input.addEventListener('input', function() {
                        const brand = this.dataset.brand;
                        const model = this.dataset.model;
                        updateVehicleDetails(brand, model);
                    });
                });
            }

            // Add vehicle to selected list from selectors
            function addVehicleFromSelectors(brand, model) {
                const option = document.querySelector(`[data-brand="${brand}"][data-model="${model}"]`).closest('.vehicle-option');
                const year = option.querySelector('.vehicle-year').value;
                const colorSelect = option.querySelector('.vehicle-color');
                const colorOtherInput = option.querySelector('.vehicle-color-other-input');
                
                let color = colorSelect.value;
                if (color === 'other') {
                    color = colorOtherInput.value || 'Other';
                }

                // Check if vehicle already exists
                const existingIndex = selectedVehicles.findIndex(v => v.brand === brand && v.model === model);
                if (existingIndex === -1) {
                    selectedVehicles.push({
                        brand: brand,
                        model: model,
                        year: year,
                        color: color
                    });
                    renderSelectedVehicles();
                    updateHiddenInput();
                }
            }

            // Update vehicle details when selectors change
            function updateVehicleDetails(brand, model) {
                const option = document.querySelector(`[data-brand="${brand}"][data-model="${model}"]`).closest('.vehicle-option');
                const year = option.querySelector('.vehicle-year').value;
                const colorSelect = option.querySelector('.vehicle-color');
                const colorOtherInput = option.querySelector('.vehicle-color-other-input');
                
                let color = colorSelect.value;
                if (color === 'other') {
                    color = colorOtherInput.value || 'Other';
                }

                // Update existing vehicle
                const existingIndex = selectedVehicles.findIndex(v => v.brand === brand && v.model === model);
                if (existingIndex !== -1) {
                    selectedVehicles[existingIndex] = {
                        brand: brand,
                        model: model,
                        year: year,
                        color: color
                    };
                    renderSelectedVehicles();
                    updateHiddenInput();
                }
            }

            // Remove vehicle from selected list
            function removeVehicle(brand, model) {
                selectedVehicles = selectedVehicles.filter(vehicle => 
                    !(vehicle.brand === brand && vehicle.model === model)
                );
                renderSelectedVehicles();
                updateHiddenInput();
            }

            // Function to render selected vehicles
            function renderSelectedVehicles() {
                selectedVehiclesList.innerHTML = '';

                if (selectedVehicles.length === 0) {
                    selectedVehiclesList.innerHTML =
                        '<p class="col-span-3 text-slate-400 italic text-sm">No vehicles selected yet</p>';
                    return;
                }

                selectedVehicles.forEach((vehicle, index) => {
                    const vehicleElement = document.createElement('div');
                    vehicleElement.className =
                        'glass border border-white/20 rounded-lg p-3 flex justify-between items-center shadow-sm';

                    const colorDisplay = vehicle.color ? vehicle.color : 'Not specified';
                    const yearDisplay = vehicle.year ? vehicle.year : 'Not specified';

                    vehicleElement.innerHTML = `
                    <div class="flex-1">
                        <div class="font-medium text-white">${vehicle.brand} ${vehicle.model}</div>
                        <div class="text-xs text-slate-300 mt-1">
                            <span class="inline-block mr-2">
                                <i class="fas fa-calendar-alt text-slate-400 mr-1"></i>${yearDisplay}
                            </span>
                            <span class="inline-block">
                                <i class="fas fa-palette text-slate-400 mr-1"></i>${colorDisplay}
                            </span>
                        </div>
                    </div>
                    <button class="remove-vehicle-btn text-red-400 hover:text-red-300 p-1 transition-colors duration-200" data-index="${index}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                    selectedVehiclesList.appendChild(vehicleElement);
                });

                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-vehicle-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const vehicle = selectedVehicles[index];
                        
                        // Uncheck the corresponding checkbox
                        const checkbox = document.querySelector(`.vehicle-checkbox[data-brand="${vehicle.brand}"][data-model="${vehicle.model}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                            const vehicleOption = checkbox.closest('.vehicle-option');
                            
                            // Remove all selection styles completely
                            vehicleOption.classList.remove('border-indigo-500', 'bg-indigo-500/10');
                            vehicleOption.style.borderColor = '';
                            vehicleOption.style.backgroundColor = '';
                            vehicleOption.style.removeProperty('border-color');
                            vehicleOption.style.removeProperty('background-color');
                            
                            // Hide the details with animation
                            const details = vehicleOption.querySelector('.vehicle-details');
                            details.classList.add('opacity-0', 'translate-y-2');
                            setTimeout(() => {
                                details.classList.add('hidden');
                            }, 300);
                            
                            // Force a re-render to clear any remaining styles
                            vehicleOption.offsetHeight;
                        }
                        
                        selectedVehicles.splice(index, 1);
                        renderSelectedVehicles();
                        updateHiddenInput();
                    });
                });
            }

            // Event listener for custom color
            customColor.addEventListener('change', function() {
                if (this.value === 'other') {
                    customColorOtherContainer.classList.remove('hidden');
                } else {
                    customColorOtherContainer.classList.add('hidden');
                    customColorOther.value = '';
                }
            });

            // Function to add a custom vehicle
            function addCustomVehicle() {
                const brand = document.getElementById('custom-brand').value;
                const model = document.getElementById('custom-model').value;
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
                        confirmButtonColor: '#6366f1'
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
                document.getElementById('custom-brand').value = '';
                document.getElementById('custom-model').value = '';
                customYear.value = '';
                customColor.value = '';
                customColorOther.value = '';
                customColorOtherContainer.classList.add('hidden');

                renderSelectedVehicles();
                updateHiddenInput();
            }

            // Event listener for add custom vehicle button
            addCustomVehicleBtn.addEventListener('click', addCustomVehicle);

            // Save fleet button handler
            saveFleetBtn.addEventListener('click', function() {
                if (selectedVehicles.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Vehicles Selected',
                        text: 'No vehicle data to save',
                        confirmButtonColor: '#6366f1'
                    });
                    return;
                }

                const fleetFormData = updateHiddenInput();

                fetch(routeStoreFleet, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(fleetFormData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Fleet Saved',
                            text: 'Vehicle information has been saved successfully',
                            confirmButtonColor: '#6366f1'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'There was an error saving the fleet data',
                            confirmButtonColor: '#6366f1'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving fleet data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error saving the fleet data',
                        confirmButtonColor: '#6366f1'
                    });
                });
            });

            // Function to mark checkboxes for saved vehicles
            function markSavedVehicles() {
                selectedVehicles.forEach(vehicle => {
                    const checkbox = document.querySelector(`.vehicle-checkbox[data-brand="${vehicle.brand}"][data-model="${vehicle.model}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                        const vehicleOption = checkbox.closest('.vehicle-option');
                        vehicleOption.classList.add('border-indigo-500', 'bg-indigo-500/10');
                        
                        // Show the details
                        const details = vehicleOption.querySelector('.vehicle-details');
                        details.classList.remove('hidden');
                        details.classList.remove('opacity-0', 'translate-y-2');
                        
                        // Set the year and color values
                        const yearSelect = vehicleOption.querySelector('.vehicle-year');
                        const colorSelect = vehicleOption.querySelector('.vehicle-color');
                        const colorOtherInput = vehicleOption.querySelector('.vehicle-color-other-input');
                        
                        if (yearSelect && vehicle.year) {
                            yearSelect.value = vehicle.year;
                        }
                        
                        if (colorSelect && vehicle.color) {
                            if (vehicle.color === 'black' || vehicle.color === 'white' || vehicle.color === 'silver' || 
                                vehicle.color === 'gray' || vehicle.color === 'blue' || vehicle.color === 'red') {
                                colorSelect.value = vehicle.color;
                            } else {
                                colorSelect.value = 'other';
                                colorOtherInput.value = vehicle.color;
                                vehicleOption.querySelector('.vehicle-color-other').classList.remove('hidden');
                            }
                        }
                    }
                });
            }

            // Initialize the interface
            generateVehicleGrid();
            
            // Mark saved vehicles after grid is generated
            setTimeout(() => {
                markSavedVehicles();
            }, 300);
        });
    </script>
@endpush
