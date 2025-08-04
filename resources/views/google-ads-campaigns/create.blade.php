<x-guest-layout>
    <div class="min-h-screen main-bg py-6">
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
                                ? 'emerald'
                                : (str_contains($msg, '⚠️')
                                    ? 'amber'
                                    : (str_contains($msg, '❌')
                                        ? 'red'
                                        : 'blue'));
                            $icon = [
                                'emerald' =>
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                                'amber' =>
                                    '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
                                'red' =>
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                                'blue' =>
                                    '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/>',
                            ][$color];
                            $msg = str_replace(['✅', '⚠️', '❌'], '', $msg);
                        @endphp
                        <div class="flex items-start p-5 glass border border-{{ $color }}-400/30 rounded-2xl bg-{{ $color }}-500/10 text-{{ $color }}-300 shadow-lg backdrop-blur-xl">
                            <svg class="w-6 h-6 mt-0.5 mr-4 flex-shrink-0 text-{{ $color }}-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                {!! $icon !!}
                            </svg>
                            <p class="font-medium text-base">{{ $msg }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <form id="campaignForm" action="{{ route('campaigns.store', $client->highlevel_id) }}" method="POST"
                class="glass-dark shadow-2xl rounded-2xl p-8 space-y-10 border border-white/15 backdrop-blur-xl">
                
                <div class="mb-10">
                    <h1 class="text-4xl font-bold text-white mb-8 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg ring-2 ring-blue-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        Google Ads Campaign
                    </h1>
                    
                    <!-- Enhanced Account Selectors -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <!-- Enhanced Google Account Selector -->
                        <div class="space-y-3">
                            <label for="google-account-select" class="block text-sm font-semibold text-slate-300 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                                </svg>
                                Google Ads Account
                            </label>
                            <div class="relative">
                                <select id="google-account-select" name="google_account"
                                    class="w-full glass border border-white/20 rounded-2xl py-3 pl-4 pr-10 text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 shadow-lg transition-all duration-300 appearance-none bg-transparent backdrop-blur-xl">
                                    <option value="" class="bg-slate-800 text-white">Select an account</option>
                                    {{-- @foreach ($customer_ids as $google)
                                        <option value="{{ $google->customer_id }}" class="bg-slate-800 text-white">{{ $google->name }}</option>
                                    @endforeach --}}
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-slate-400 mt-2">Select the Google Ads account for your campaign</p>
                        </div>

                        <!-- Enhanced Customer Selector -->
                        <div class="space-y-3" id="customer-selector-container">
                            <label for="customerid" class="block text-sm font-semibold text-slate-300 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Client Account
                            </label>
                            <div class="relative">
                                <select name="customer_id" id="customerid"
                                    class="w-full glass border border-white/20 rounded-2xl py-3 pl-4 pr-10 text-white leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 shadow-lg transition-all duration-300 appearance-none bg-transparent backdrop-blur-xl">
                                    <option value="" class="bg-slate-800 text-white">Select a client account</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-slate-400 mt-2">Select the client account for this campaign</p>
                        </div>
                    </div>
                </div>

                @csrf
                <div class="space-y-8">
                    <x-ads.name-campaign-input step="1" placeholder="Please enter name campaign" name="Name Campaign" />
                    <x-ads.user-location-input step="2" placeholder="Please enter your city and state" name="User Location" />
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
                    <x-ads.daily-budget-input step="7" value="16" min="5" recommendation="$16-$50 for best results" name="Daily Budget" />
                    <x-ads.schedule-selector step="8" name="Ad Schedule" :day-options="['Days', 'Monday-Friday', 'Weekends', 'All days']" :time-options="['From', '8:00 AM', '9:00 AM', '10:00 AM']" end-time="10:00 PM" />
                    <x-ads.campaign-preview />
                </div>
            </form>
        </div>
    </div>

    <footer class="w-full text-center py-6 text-slate-400 text-sm border-t border-white/20 mt-8">
        <p>
            This site is protected by U.S. data protection laws. <br>
            <a href="{{ route('privacy.policy') }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">Privacy Policy</a> |
            <a href="{{ route('terms.service') }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">Terms of Service</a>
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

                // Enhanced notification system for dark theme
                function showNotification(message, type = 'info') {
                    const notification = document.createElement('div');
                    const colors = {
                        success: 'from-emerald-500 to-green-600 border-emerald-400',
                        error: 'from-red-500 to-pink-600 border-red-400',
                        info: 'from-blue-500 to-indigo-600 border-blue-400',
                        warning: 'from-amber-500 to-orange-600 border-amber-400'
                    };
                    
                    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm glass backdrop-blur-xl`;
                    
                    notification.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                ${type === 'success' ?
                                     '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                                    type === 'error' ?
                                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                                    type === 'warning' ?
                                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>' :
                                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                                }
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">${message}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white/80 hover:text-white transition-colors duration-200 transform hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `;
                    
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                    }, 100);
                    
                    setTimeout(() => {
                        notification.style.transform = 'translateX(100%)';
                        notification.style.opacity = '0';
                        setTimeout(() => {
                            if (document.body.contains(notification)) {
                                document.body.removeChild(notification);
                            }
                        }, 500);
                    }, 4000);
                }

                // All existing JavaScript functionality remains exactly the same
                function saveFormState() {
                    const formData = new FormData(form);
                    const formState = {};
                    
                    for (let [key, value] of formData.entries()) {
                        formState[key] = value;
                    }
                    
                    try {
                        const keywordsInput = document.querySelector('input[name="keywords"]');
                        if (keywordsInput) {
                            formState.keywords = keywordsInput.value;
                        }
                        
                        const adsInput = document.querySelector('input[name="generated_ads"]');
                        if (adsInput) {
                            formState.generated_ads = adsInput.value;
                        }
                        
                        const locationInput = document.querySelector('input[name="location_data"]');
                        if (locationInput) {
                            formState.location_data = locationInput.value;
                        }
                        
                        const scheduleInput = document.querySelector('input[name="ad_schedule"]');
                        if (scheduleInput) {
                            formState.ad_schedule = scheduleInput.value;
                        }
                        
                        localStorage.setItem('campaignFormState', JSON.stringify(formState));
                    } catch (error) {
                        console.error('Error saving state:', error);
                    }
                }

                function restoreFormState() {
                    try {
                        const savedState = localStorage.getItem('campaignFormState');
                        if (savedState) {
                            const formState = JSON.parse(savedState);
                            
                            for (let [key, value] of Object.entries(formState)) {
                                const input = form.querySelector(`[name="${key}"]`);
                                if (input) {
                                    input.value = value;
                                    input.dispatchEvent(new Event('change'));
                                }
                            }
                            
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
                            
                            if (typeof updatePreview === 'function') {
                                updatePreview();
                            }
                        }
                    } catch (error) {
                        console.error('Error restoring state:', error);
                    }
                }

                form.addEventListener('input', function() {
                    saveFormState();
                    const allStepsCompleted = Array.from(form.querySelectorAll('.step'))
                        .every(step => step.checkValidity());
                    submitButton.disabled = !allStepsCompleted;
                });

                document.addEventListener('keywordsUpdated', saveFormState);
                document.addEventListener('adsGenerated', saveFormState);
                document.addEventListener('locationUpdated', saveFormState);
                document.addEventListener('scheduleUpdated', saveFormState);

                restoreFormState();

                form.addEventListener('submit', function() {
                    localStorage.removeItem('campaignFormState');
                });

                submitButton.disabled = true;

                form.addEventListener('input', function() {
                    const allStepsCompleted = Array.from(form.querySelectorAll('.step'))
                        .every(step => step.checkValidity());
                    submitButton.disabled = !allStepsCompleted;
                });

                async function validateCampaignName(name) {
                    try {
                        const response = await fetch(`/api/validate-campaign-name/${name}`);
                        const data = await response.json();
                        return data.available;
                    } catch (error) {
                        console.error('Error validating campaign name:', error);
                        return true;
                    }
                }

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

                function loadCustomers(accountId) {
                    if (!accountId) {
                        customerSelect.innerHTML = '<option value="" class="bg-slate-800 text-white">Select an account first</option>';
                        document.getElementById('customer-selector-container').style.display = 'none';
                        return;
                    }
                    
                    const clientId = '{{ $client->highlevel_id }}';
                    console.log(`Selected account: ${accountId}, Client ID: ${clientId}`);
                    const url = `{{ route('campaings.list', '') }}/${clientId}?account_id=${accountId}`;

                    customerSelect.innerHTML = '<option value="" class="bg-slate-800 text-white">Select a client...</option>';

                    const existingLoading = customerSelect.parentElement.querySelector('.loading-overlay');
                    if (existingLoading) {
                        existingLoading.remove();
                    }

                    const loadingOption = document.createElement('div');
                    loadingOption.className = 'loading-overlay absolute inset-0 glass bg-black/50 flex items-center justify-center rounded-2xl z-10 backdrop-blur-xl';
                    loadingOption.innerHTML = `
                        <div class="flex flex-col items-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-400 mb-2"></div>
                            <p class="text-sm text-white">Loading clients...</p>
                        </div>
                    `;
                    customerSelect.parentElement.style.position = 'relative';
                    customerSelect.parentElement.appendChild(loadingOption);

                    customerSelect.disabled = true;

                    const loadingTimeout = setTimeout(() => {
                        fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('API response error');
                                }
                                return response.json();
                            })
                            .then(data => {
                                loadingOption.remove();
                                customerSelect.disabled = false;

                                customerSelect.innerHTML = '<option value="" class="bg-slate-800 text-white">Select a client...</option>';

                                if (data.success && data.accounts && Array.isArray(data.accounts)) {
                                    const sortedAccounts = data.accounts.sort((a, b) => {
                                        const nameA = a.name || '';
                                        const nameB = b.name || '';
                                        return nameA.localeCompare(nameB);
                                    });

                                    sortedAccounts.forEach(account => {
                                        const option = document.createElement('option');
                                        const customerId = account.customer_id.replace('customers/', '');
                                        option.value = customerId;
                                        option.textContent = account.name || `Client ${customerId}`;
                                        option.className = 'bg-slate-800 text-white';
                                        customerSelect.appendChild(option);
                                    });

                                    if (sortedAccounts.length === 1) {
                                        customerSelect.value = sortedAccounts[0].customer_id.replace('customers/', '');
                                    }

                                    document.getElementById('customer-selector-container').style.display = 'block';
                                } else {
                                    console.warn('Response does not contain valid data:', data);
                                    const option = document.createElement('option');
                                    option.value = '';
                                    option.textContent = 'No clients found';
                                    option.disabled = true;
                                    option.className = 'bg-slate-800 text-white';
                                    customerSelect.appendChild(option);
                                    document.getElementById('customer-selector-container').style.display = 'none';
                                }
                            })
                            .catch(error => {
                                loadingOption.remove();
                                customerSelect.disabled = false;
                                
                                console.error('Error querying API:', error);
                                customerSelect.innerHTML = '<option value="" class="bg-slate-800 text-white">Error loading clients</option>';
                                document.getElementById('customer-selector-container').style.display = 'none';
                            });
                    }, 300);

                    return () => clearTimeout(loadingTimeout);
                }

                let debounceTimer;
                accountSelect.addEventListener('change', function() {
                    if (debounceTimer) {
                        clearTimeout(debounceTimer);
                    }
                    
                    debounceTimer = setTimeout(() => {
                        loadCustomers(this.value);
                    }, 300);
                });

                if (accountSelect.value) {
                    loadCustomers(accountSelect.value);
                    refreshGoogleAdsToken('{{ $client->highlevel_id }}', accountSelect.value);
                } else {
                    customerSelect.innerHTML = '<option value="" class="bg-slate-800 text-white">Select an account first</option>';
                }

                async function refreshGoogleAdsToken(clientId, accountId) {
                    const loadingDiv = document.createElement('div');
                    loadingDiv.id = 'token-refresh-loading';
                    loadingDiv.className = 'glass border border-blue-400/30 text-blue-300 px-4 py-3 rounded-2xl relative mb-4 backdrop-blur-xl';
                    loadingDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-3 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

                        const loadingIndicator = document.getElementById('token-refresh-loading');
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }

                        if (data.success) {
                            showNotification(data.message, 'success');
                            loadCustomers(accountId);
                        } else {
                            if (data.requires_reauth) {
                                window.location.href = '{{ route("campaigns.login", "") }}/' + clientId;
                            } else {
                                showNotification(data.message, 'error');
                            }
                        }
                    } catch (error) {
                        const loadingIndicator = document.getElementById('token-refresh-loading');
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }
                        console.error('Error refreshing token:', error);
                        showNotification('Error refreshing token. Please try again.', 'error');
                    }
                }

                const accountSelectorContainer = document.querySelector('#google-account-select').parentElement;
                const refreshButton = document.createElement('button');
                refreshButton.type = 'button';
                refreshButton.className = 'mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1';
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
                        showNotification('Please select an account first.', 'warning');
                    }
                };
                accountSelectorContainer.appendChild(refreshButton);
            });
        </script>
    @endpush
</x-guest-layout>
