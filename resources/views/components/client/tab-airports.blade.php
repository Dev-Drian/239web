<div id="airports-tab" class="tab-content hidden">
    <div class="p-6 space-y-6">
        <!-- Airports Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-3 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                <h3 class="text-2xl font-bold text-white">Airport Information</h3>
            </div>
            <button type="button" id="add-airport"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-xl hover:from-indigo-600 hover:to-purple-600 transition-all duration-300 text-sm font-medium shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add Airport
            </button>
        </div>

        <!-- Manual Airport Entry Form -->
        <div class="glass-dark p-4 rounded-xl border border-white/15 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="iata-code" class="block text-sm font-medium text-slate-300 mb-2">
                        IATA Code
                    </label>
                    <input 
                        type="text" 
                        id="iata-code" 
                        placeholder="3-Letter IATA Code" 
                        maxlength="3"
                        class="w-full px-3 py-2 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all uppercase"
                    >
                </div>
                
                <div class="flex items-end">
                    <button 
                        type="button"
                        id="add-airport-btn"
                        class="w-full px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg hover:from-indigo-600 hover:to-purple-600 transition-all flex items-center justify-center space-x-2"
                    >
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Airport</span>
                    </button>
                </div>
            </div>
            <p id="validation-message" class="text-red-400 text-sm mt-2 hidden"></p>
        </div>
    
        <!-- Lista de aeropuertos -->
        <div id="airports-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $selectedAirports = json_decode($client->airports, true) ?? [];
            @endphp
        
            @foreach($selectedAirports as $iata_code)
                <label class="airport-label flex items-center p-4 glass border border-white/20 rounded-xl 
                             hover:bg-white/5 hover:border-indigo-500/50 transition-all cursor-pointer group">
                    <input type="checkbox" name="airports[]" value="{{ $iata_code }}"
                        class="airport-checkbox w-5 h-5 text-indigo-500 rounded focus:ring-indigo-500 mr-3"
                        checked>
                    <div class="flex flex-col flex-grow">
                        <span class="text-white font-medium group-hover:text-indigo-300">
                            {{ $iata_code }}
                        </span>
                    </div>
                    <span class="ml-auto text-xl text-indigo-400">
                        <i class="fas fa-plane-departure"></i>
                    </span>
                </label>
            @endforeach
        </div>

        <!-- Campo oculto para enviar todos los aeropuertos seleccionados -->
        <input type="hidden" name="selected_airports" id="selected-airports">
        
        <p id="no-airports-message" class="text-slate-400 text-sm mt-4 text-center hidden">No airports available.</p>
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
            newAirportLabel.className = 'airport-label flex items-center p-4 glass border border-white/20 rounded-xl hover:bg-white/5 hover:border-indigo-500/50 transition-all cursor-pointer group';
            
            newAirportLabel.innerHTML = `
                <input type="checkbox" name="airports[]" value="${iataCode}"
                    class="airport-checkbox w-5 h-5 text-indigo-500 rounded focus:ring-indigo-500 mr-3" checked>
                <div class="flex flex-col flex-grow">
                    <span class="text-white font-medium group-hover:text-indigo-300">${iataCode}</span>
                </div>
                <span class="ml-auto text-xl text-indigo-400">
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
