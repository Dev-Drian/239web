<div class="hidden tab-content" id="airports-tab">
    <div class="mb-8 bg-white shadow-lg rounded-lg p-6">
        
        <!-- Manual Airport Entry Form -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="iata-code" class="block text-sm font-medium text-gray-700 mb-2">
                        IATA Code
                    </label>
                    <input 
                        type="text" 
                        id="iata-code" 
                        placeholder="3-Letter IATA Code" 
                        maxlength="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all uppercase"
                    >
                </div>
                
                <div class="flex items-end">
                    <button 
                        type="button"
                        id="add-airport-btn"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center space-x-2"
                    >
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Airport</span>
                    </button>
                </div>
            </div>
            <p id="validation-message" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>
    
        <!-- Lista de aeropuertos -->
        <div id="airports-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $selectedAirports = json_decode($client->airports, true) ?? [];
            @endphp
        
            @foreach($selectedAirports as $iata_code)
                <label class="airport-label flex items-center p-4 border border-gray-200 rounded-lg 
                             hover:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer group">
                    <input type="checkbox" name="airports[]" value="{{ $iata_code }}"
                        class="airport-checkbox w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3"
                        checked>
                    <div class="flex flex-col flex-grow">
                        <span class="text-gray-800 font-medium group-hover:text-blue-700">
                            {{ $iata_code }}
                        </span>
                    </div>
                    <span class="ml-auto text-xl text-blue-600">
                        <i class="fas fa-plane-departure"></i>
                    </span>
                </label>
            @endforeach
        </div>

        <!-- Campo oculto para enviar todos los aeropuertos seleccionados -->
        <input type="hidden" name="selected_airports" id="selected-airports">
        
        <p id="no-airports-message" class="text-gray-500 text-sm mt-4 text-center hidden">No airports available.</p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addAirportBtn = document.getElementById('add-airport-btn');
        const iataCodeInput = document.getElementById('iata-code');
        const airportsContainer = document.getElementById('airports-container');
        const noAirportsMessage = document.getElementById('no-airports-message');
        const validationMessage = document.getElementById('validation-message');
        const selectedAirportsInput = document.getElementById('selected-airports');

        function showValidationMessage(message) {
            validationMessage.textContent = message;
            validationMessage.classList.remove('hidden');
            setTimeout(() => {
                validationMessage.classList.add('hidden');
            }, 3000);
        }

        function updateSelectedAirports() {
            const selected = Array.from(document.querySelectorAll('.airport-checkbox:checked'))
                                  .map(cb => cb.value);
            selectedAirportsInput.value = JSON.stringify(selected);
        }

        function addAirport() {
            const iataCode = iataCodeInput.value.trim().toUpperCase();
            
            validationMessage.classList.add('hidden');

            if (!iataCode) {
                showValidationMessage('Please enter an IATA code');
                iataCodeInput.focus();
                return;
            }

            if (iataCode.length !== 3) {
                showValidationMessage('IATA code must be exactly 3 letters');
                iataCodeInput.focus();
                return;
            }

            // Crear nuevo elemento
            const newAirportLabel = document.createElement('label');
            newAirportLabel.className = 'airport-label flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer group';
            
            newAirportLabel.innerHTML = `
                <input type="checkbox" name="airports[]" value="${iataCode}"
                    class="airport-checkbox w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3" checked>
                <div class="flex flex-col flex-grow">
                    <span class="text-gray-800 font-medium group-hover:text-blue-700">${iataCode}</span>
                </div>
                <span class="ml-auto text-xl text-blue-600">
                    <i class="fas fa-plane-departure"></i>
                </span>
            `;

            airportsContainer.appendChild(newAirportLabel);
            
            iataCodeInput.value = '';
            noAirportsMessage.classList.add('hidden');
            updateSelectedAirports();
        }

        addAirportBtn.addEventListener('click', addAirport);

        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('airport-checkbox')) {
                updateSelectedAirports();
            }
        });

        iataCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addAirport();
            }
        });

        updateSelectedAirports();
    });
    </script>
</div>
