<x-guest-layout>
    {{-- <x-slot name="header">
        @include('components.header', ['name' => 'Client'])
    </x-slot> --}}

    <div class="container mx-auto px-6 py-12 max-w-5xl">
        @if(session('alert'))
            <x-alert 
                :type="session('alert.type')"
                :title="session('alert.title')"
                :message="session('alert.message')"
                :icon="session('alert.icon')"
                :timer="session('alert.timer')"
            />
        @endif

        @if (session('messages'))
            <div class="space-y-4 mb-8">
                @foreach (session('messages') as $msg)
                    @php
                        $color = str_contains($msg, '✅')
                            ? 'green'
                            : (str_contains($msg, '⚠️')
                                ? 'yellow'
                                : (str_contains($msg, '❌')
                                    ? 'red'
                                    : 'blue'));
                        $icon = [
                            'green' =>
                                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                            'yellow' =>
                                '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
                            'red' =>
                                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                            'blue' =>
                                '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/>',
                        ][$color];
                        $msg = str_replace(['✅', '⚠️', '❌'], '', $msg);
                    @endphp

                    <div
                        class="flex items-start p-5 border rounded-xl bg-{{ $color }}-50 border-{{ $color }}-200 text-{{ $color }}-700 shadow-sm">
                        <svg class="w-6 h-6 mt-0.5 mr-4 flex-shrink-0 text-{{ $color }}-600"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            {!! $icon !!}
                        </svg>
                        <p class="font-medium text-base">{{ $msg }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <form id="campaignForm" action="{{ route('campaigns.store', $client->highlevel_id) }}" method="POST"
            class="bg-white shadow-xl rounded-2xl p-8 space-y-10">

            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-800 mb-8">Google Ads Campaign</h1>

                <!-- Account Selectors -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <!-- Google Account Selector -->
                    <div class="space-y-3">
                        <label for="google-account-select" class="block text-sm font-semibold text-gray-700">
                            Google Ads Account
                        </label>
                        <div class="relative">
                            <select id="google-account-select" name="google_account"
                                class="w-full bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors duration-200 appearance-none">
                                <option value="">Select an account</option>
                                @foreach ($customer_ids as $google)
                                    <option value="{{ $google->customer_id }}">{{ $google->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Select the Google Ads account for your campaign</p>
                    </div>

                    <!-- Customer Selector -->
                    <div class="space-y-3" id="customer-selector-container">
                        <label for="customerid" class="block text-sm font-semibold text-gray-700">
                            Client Account
                        </label>
                        <div class="relative">
                            <select name="customer_id" id="customerid"
                                class="w-full bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors duration-200 appearance-none">
                                <option value="">Select a client account</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Select the client account for this campaign</p>
                    </div>
                </div>
            </div>

            @csrf
            <div class="space-y-8">
                <x-ads.name-campaign-input step="1" placeholder="Please enter name campaign"
                    name="Name Campaign" />
                <x-ads.user-location-input step="2" placeholder="Please enter your city and state"
                    name="User Location" />

                <x-ads.campaign-template-selector step="3" name="Campaign Template" :groups="[
                    'Corporate Transportation' => [
                        'black_car_limo' => 'Black Car & Limo Service (Executive Rides)',
                        'executive_transport' => 'Executive Transportation (VIP Business Travel)',
                    ],
                    'Airport Services' => [
                        'airport_limo' => 'Airport Limo Transfers (Premium Arrivals/Departures)',
                    ],
                ]" />

                <x-ads.keyword-generator step="4" name="Keyword Generation" />

                <x-ads.ad-creator step="5" ad-count="6" name="Ad Creation" :client="$client" />

                <x-ads.target-area-input step="6" value="15" name="Target Area" />

                <x-ads.daily-budget-input step="7" value="16" min="5"
                    recommendation="$16-$50 for best results" name="Daily Budget" />

                <x-ads.schedule-selector step="8" name="Ad Schedule" :day-options="['Days', 'Monday-Friday', 'Weekends', 'All days']" :time-options="['From', '8:00 AM', '9:00 AM', '10:00 AM']"
                    end-time="10:00 PM" />

                <x-ads.campaign-preview />
            </div>
        </form>
    </div>
    <footer class="w-full text-center py-6 text-gray-500 text-sm border-t mt-8">
        <p>
            This site is protected by U.S. data protection laws. <br>
            <a href="{{ route('privacy.policy') }}" class="text-blue-600 hover:underline">Privacy Policy</a> |
            <a href="{{ route('terms.service') }}" class="text-blue-600 hover:underline">Terms of Service</a>
        </p>
    </footer>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('campaignForm');
                const submitButton = form.querySelector('button[type="submit"]');
                const accountSelect = document.getElementById('google-account-select');
                const customerSelect = document.getElementById('customerid');
                const campaignNameInput = form.querySelector('input[name="name_campaign"]');

                // Función para guardar el estado del formulario
                function saveFormState() {
                    const formData = new FormData(form);
                    const formState = {};
                    
                    // Guardar datos básicos del formulario
                    for (let [key, value] of formData.entries()) {
                        formState[key] = value;
                    }

                    // Guardar datos complejos de JavaScript
                    try {
                        // Guardar keywords
                        const keywordsInput = document.querySelector('input[name="keywords"]');
                        if (keywordsInput) {
                            formState.keywords = keywordsInput.value;
                        }

                        // Guardar anuncios generados
                        const adsInput = document.querySelector('input[name="generated_ads"]');
                        if (adsInput) {
                            formState.generated_ads = adsInput.value;
                        }

                        // Guardar datos de ubicación
                        const locationInput = document.querySelector('input[name="location_data"]');
                        if (locationInput) {
                            formState.location_data = locationInput.value;
                        }

                        // Guardar horario
                        const scheduleInput = document.querySelector('input[name="ad_schedule"]');
                        if (scheduleInput) {
                            formState.ad_schedule = scheduleInput.value;
                        }

                        localStorage.setItem('campaignFormState', JSON.stringify(formState));
                    } catch (error) {
                        console.error('Error saving state:', error);
                    }
                }

                // Función para restaurar el estado del formulario
                function restoreFormState() {
                    try {
                        const savedState = localStorage.getItem('campaignFormState');
                        if (savedState) {
                            const formState = JSON.parse(savedState);
                            
                            // Restaurar datos básicos
                            for (let [key, value] of Object.entries(formState)) {
                                const input = form.querySelector(`[name="${key}"]`);
                                if (input) {
                                    input.value = value;
                                    // Disparar evento change para activar validaciones
                                    input.dispatchEvent(new Event('change'));
                                }
                            }

                            // Restaurar datos complejos
                            if (formState.keywords) {
                                const keywordsInput = document.querySelector('input[name="keywords"]');
                                if (keywordsInput) {
                                    keywordsInput.value = formState.keywords;
                                    keywordsInput.dispatchEvent(new Event('change'));
                                }
                            }

                            if (formState.generated_ads) {
                                const adsInput = document.querySelector('input[name="generated_ads"]');
                                if (adsInput) {
                                    adsInput.value = formState.generated_ads;
                                    adsInput.dispatchEvent(new Event('change'));
                                }
                            }

                            if (formState.location_data) {
                                const locationInput = document.querySelector('input[name="location_data"]');
                                if (locationInput) {
                                    locationInput.value = formState.location_data;
                                    locationInput.dispatchEvent(new Event('change'));
                                }
                            }

                            if (formState.ad_schedule) {
                                const scheduleInput = document.querySelector('input[name="ad_schedule"]');
                                if (scheduleInput) {
                                    scheduleInput.value = formState.ad_schedule;
                                    scheduleInput.dispatchEvent(new Event('change'));
                                }
                            }

                            // Actualizar la vista previa si existe
                            if (typeof updatePreview === 'function') {
                                updatePreview();
                            }
                        }
                    } catch (error) {
                        console.error('Error restoring state:', error);
                    }
                }

                // Guardar estado cuando cambian los inputs
                form.addEventListener('input', function() {
                    saveFormState();
                    const allStepsCompleted = Array.from(form.querySelectorAll('.step'))
                        .every(step => step.checkValidity());
                    submitButton.disabled = !allStepsCompleted;
                });

                // Guardar estado cuando cambian los datos complejos
                document.addEventListener('keywordsUpdated', saveFormState);
                document.addEventListener('adsGenerated', saveFormState);
                document.addEventListener('locationUpdated', saveFormState);
                document.addEventListener('scheduleUpdated', saveFormState);

                // Restaurar estado al cargar la página
                restoreFormState();

                // Limpiar el estado guardado cuando el formulario se envía exitosamente
                form.addEventListener('submit', function() {
                    localStorage.removeItem('campaignFormState');
                });

                // Disable the submit button initially
                submitButton.disabled = true;

                // Enable the submit button when all steps are completed
                form.addEventListener('input', function() {
                    const allStepsCompleted = Array.from(form.querySelectorAll('.step'))
                        .every(step => step.checkValidity());
                    submitButton.disabled = !allStepsCompleted;
                });

                // Función para validar el nombre de la campaña
                async function validateCampaignName(name) {
                    try {
                        const response = await fetch(`/api/validate-campaign-name/${name}`);
                        const data = await response.json();
                        return data.available;
                    } catch (error) {
                        console.error('Error validating campaign name:', error);
                        return true; // En caso de error, permitimos el envío
                    }
                }

                // Validar el nombre de la campaña mientras se escribe
                let nameValidationTimeout;
                campaignNameInput.addEventListener('input', function() {
                    clearTimeout(nameValidationTimeout);
                    const name = this.value.trim();
                    
                    if (name.length > 0) {
                        nameValidationTimeout = setTimeout(async () => {
                            const isValid = await validateCampaignName(name);
                            if (!isValid) {
                                this.setCustomValidity('This campaign name is already in use');
                            } else {
                                this.setCustomValidity('');
                            }
                        }, 500);
                    }
                });

                // Function to load customers based on selected account
                function loadCustomers(accountId) {
                    if (!accountId) {
                        customerSelect.innerHTML = '<option value="">Select an account first</option>';
                        document.getElementById('customer-selector-container').style.display = 'none';
                        return;
                    }

                    const clientId = '{{ $client->highlevel_id }}';
                    console.log(`Selected account: ${accountId}, Client ID: ${clientId}`);
                    const url = `{{ route('campaings.list', '') }}/${clientId}?account_id=${accountId}`;

                    // Clear select and add default option
                    customerSelect.innerHTML = '<option value="">Select a client...</option>';

                    // Remove any existing loading state
                    const existingLoading = customerSelect.parentElement.querySelector('.loading-overlay');
                    if (existingLoading) {
                        existingLoading.remove();
                    }

                    // Show loading state with a better UI
                    const loadingOption = document.createElement('div');
                    loadingOption.className = 'loading-overlay absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg z-10';
                    loadingOption.innerHTML = `
                        <div class="flex flex-col items-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-2"></div>
                            <p class="text-sm text-gray-600">Loading clients...</p>
                        </div>
                    `;
                    customerSelect.parentElement.style.position = 'relative';
                    customerSelect.parentElement.appendChild(loadingOption);

                    // Disable the select while loading
                    customerSelect.disabled = true;

                    // Add a small delay to prevent rapid switching
                    const loadingTimeout = setTimeout(() => {
                        fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('API response error');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Remove loading state
                                loadingOption.remove();
                                customerSelect.disabled = false;

                                // Clear the select after loading
                                customerSelect.innerHTML = '<option value="">Select a client...</option>';

                                // Check if data exists and accounts property exists
                                if (data.success && data.accounts && Array.isArray(data.accounts)) {
                                    // Sort clients alphabetically by name
                                    const sortedAccounts = data.accounts.sort((a, b) => {
                                        const nameA = a.name || '';
                                        const nameB = b.name || '';
                                        return nameA.localeCompare(nameB);
                                    });

                                    // Fill the select with clients
                                    sortedAccounts.forEach(account => {
                                        const option = document.createElement('option');
                                        // Extract only the numeric ID from customer_id
                                        const customerId = account.customer_id.replace('customers/', '');
                                        option.value = customerId;

                                        // Show name if exists, otherwise show ID
                                        option.textContent = account.name || `Client ${customerId}`;
                                        customerSelect.appendChild(option);
                                    });

                                    // If there's only one client, select it automatically
                                    if (sortedAccounts.length === 1) {
                                        customerSelect.value = sortedAccounts[0].customer_id.replace('customers/', '');
                                    }

                                    // Mostrar el contenedor del selector si hay cuentas
                                    document.getElementById('customer-selector-container').style.display = 'block';
                                } else {
                                    console.warn('Response does not contain valid data:', data);
                                    const option = document.createElement('option');
                                    option.value = '';
                                    option.textContent = 'No clients found';
                                    option.disabled = true;
                                    customerSelect.appendChild(option);
                                    // Ocultar el contenedor del selector si no hay cuentas
                                    document.getElementById('customer-selector-container').style.display = 'none';
                                }
                            })
                            .catch(error => {
                                // Remove loading state
                                loadingOption.remove();
                                customerSelect.disabled = false;
                                
                                console.error('Error querying API:', error);
                                customerSelect.innerHTML = '<option value="">Error loading clients</option>';
                                // Ocultar el contenedor del selector en caso de error
                                document.getElementById('customer-selector-container').style.display = 'none';
                            });
                    }, 300); // 300ms delay to prevent rapid switching

                    // Cleanup timeout if component is unmounted
                    return () => clearTimeout(loadingTimeout);
                }

                // Event listener for account selector changes
                let debounceTimer;
                accountSelect.addEventListener('change', function() {
                    // Clear any existing timer
                    if (debounceTimer) {
                        clearTimeout(debounceTimer);
                    }
                    
                    // Set a new timer
                    debounceTimer = setTimeout(() => {
                        loadCustomers(this.value);
                    }, 300);
                });

                // Load clients on start if an account is already selected
                if (accountSelect.value) {
                    loadCustomers(accountSelect.value);
                    // Refrescar el token automáticamente al cargar la página
                    refreshGoogleAdsToken('{{ $client->highlevel_id }}', accountSelect.value);
                } else {
                    customerSelect.innerHTML = '<option value="">Select an account first</option>';
                }

                // Función para refrescar el token de Google Ads
                async function refreshGoogleAdsToken(clientId, accountId) {
                    // Mostrar indicador de carga
                    const loadingDiv = document.createElement('div');
                    loadingDiv.id = 'token-refresh-loading';
                    loadingDiv.className = 'bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4';
                    loadingDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Refreshing Google Ads token...</span>
                        </div>
                    `;
                    document.querySelector('.container').insertBefore(loadingDiv, document.querySelector('.container').firstChild);

                    try {
                        const response = await fetch('{{ route("google-ads.refresh-token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                client_id: clientId,
                                account_id: accountId
                            })
                        });

                        const data = await response.json();

                        // Remover indicador de carga
                        const loadingIndicator = document.getElementById('token-refresh-loading');
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }

                        if (data.success) {
                            // Mostrar mensaje de éxito
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
                            alertDiv.innerHTML = `
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">${data.message}</span>
                            `;
                            document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);

                            // Recargar la lista de clientes
                            loadCustomers(accountId);
                        } else {
                            if (data.requires_reauth) {
                                // Redirigir al login si se requiere reautenticación
                                window.location.href = '{{ route("campaigns.login", "") }}/' + clientId;
                            } else {
                                // Mostrar mensaje de error
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';
                                alertDiv.innerHTML = `
                                    <strong class="font-bold">Error!</strong>
                                    <span class="block sm:inline">${data.message}</span>
                                `;
                                document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);
                            }
                        }
                    } catch (error) {
                        // Remover indicador de carga
                        const loadingIndicator = document.getElementById('token-refresh-loading');
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }

                        console.error('Error refreshing token:', error);
                        // Mostrar mensaje de error
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';
                        alertDiv.innerHTML = `
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">Error refreshing token. Please try again.</span>
                        `;
                        document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);
                    }
                }

                // Agregar botón de refresco de token
                const accountSelectorContainer = document.querySelector('#google-account-select').parentElement;
                const refreshButton = document.createElement('button');
                refreshButton.type = 'button';
                refreshButton.className = 'mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500';
                refreshButton.innerHTML = `
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Token
                `;
                refreshButton.onclick = function() {
                    const selectedAccount = accountSelect.value;
                    if (selectedAccount) {
                        refreshGoogleAdsToken('{{ $client->highlevel_id }}', selectedAccount);
                    } else {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4';
                        alertDiv.innerHTML = `
                            <strong class="font-bold">Warning!</strong>
                            <span class="block sm:inline">Please select an account first.</span>
                        `;
                        document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);
                    }
                };
                accountSelectorContainer.appendChild(refreshButton);
            });
        </script>
    @endpush
</x-guest-layout>
