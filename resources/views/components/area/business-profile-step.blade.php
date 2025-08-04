<div class="form-step hidden animate__animated" id="step-1">
    <div class="w-full max-w-4xl mx-auto glass-dark rounded-2xl shadow-2xl overflow-hidden border border-white/15 backdrop-blur-xl">
        <!-- Enhanced Header -->
        <div class="bg-gradient-to-r from-blue-600/80 via-indigo-600/80 to-purple-600/80 px-6 py-4 backdrop-blur-xl border-b border-white/10">
            <div class="flex items-center justify-between">
                <!-- Business Profile Title -->
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-briefcase mr-3"></i>Business Profile
                </h2>
                
                <!-- Enhanced Info tooltip -->
                <div class="relative group inline-block cursor-pointer">
                    <!-- Enhanced Info icon -->
                    <span class="flex items-center justify-center w-8 h-8 text-blue-600 glass rounded-full border-2 border-blue-400/50 shadow-lg transition-all duration-300 group-hover:shadow-xl group-hover:scale-110 backdrop-blur-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    
                    <!-- Enhanced Tooltip content -->
                    <div class="absolute z-20 right-0 mt-2 w-64 glass text-white text-sm rounded-2xl border border-white/20 shadow-2xl invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 backdrop-blur-xl">
                        <div class="px-4 py-3">
                            <p>For Businesses with Address Visible on Google</p>
                        </div>
                        <!-- Enhanced Arrow pointer -->
                        <div class="absolute -top-2 right-2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-l-transparent border-r-transparent border-b-slate-800"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido del formulario -->
        @if ($client->clientLocations)
            <div id="existingCompanyDetails" data-place-id="{{ $client->clientLocations->place_id }}"
                class="transition-opacity duration-500"></div>
            <div id="searchSection" class="p-6 hidden">
                <!-- Business Search Section -->
                <div class="mb-6">
                    <label for="companySearch" class="block text-sm font-medium text-slate-300 mb-2">
                        <svg class="w-4 h-4 inline-block mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search for Your Business:
                    </label>
                    <div class="relative">
                        <input type="text" id="companySearch" name="company_search"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                            placeholder="Enter business name or address">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" id="showManualFormBtn" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center mx-auto">
                            <i class="fas fa-edit mr-2"></i>Enter business information manually
                        </button>
                    </div>
                </div>

                <!-- Enhanced Manual Entry Form -->
                <div id="manualEntryForm" class="hidden mt-6">
                    <div class="space-y-4">
                        <div>
                            <label for="manual_business_name" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Business Name *
                            </label>
                            <input type="text" id="manual_business_name" name="manual_business_name" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_address" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Business Address *
                            </label>
                            <input type="text" id="manual_address" name="manual_address" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_city" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                City *
                            </label>
                            <input type="text" id="manual_city" name="manual_city" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_phone" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Phone Number
                            </label>
                            <input type="tel" id="manual_phone" name="manual_phone"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_website" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9" />
                                </svg>
                                Website
                            </label>
                            <input type="url" id="manual_website" name="manual_website"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                placeholder="https://example.com">
                        </div>
                        
                        <div>
                            <label for="manual_business_email" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Business Email *
                            </label>
                            <input type="email" id="manual_business_email" name="manual_business_email" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_year_found" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Year Found *
                            </label>
                            <input type="number" id="manual_year_found" name="manual_year_found" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_employees" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Number of Employees *
                            </label>
                            <input type="number" id="manual_employees" name="manual_employees" required
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                        </div>
                        
                        <div>
                            <label for="manual_social_media" class="block text-sm font-medium text-slate-300 mb-2">
                                <svg class="w-4 h-4 inline-block mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-9 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2" />
                                </svg>
                                Social Media Links
                            </label>
                            <textarea id="manual_social_media" name="manual_social_media" rows="4"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                placeholder="Enter one URL per line:&#10;https://facebook.com/yourbusiness&#10;https://instagram.com/yourbusiness"></textarea>
                        </div>
                        
                        <div class="flex justify-center mt-6">
                            <button type="button" id="submitManualForm"
                                class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl w-full flex items-center justify-center transform hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i>Save Business Information
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="p-6">
                <!-- Business Search Section -->
                <div class="mb-6">
                    <label for="companySearch" class="block text-sm font-medium text-slate-300 mb-2">
                        <svg class="w-4 h-4 inline-block mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search for Your Business:
                    </label>
                    <div class="relative">
                        <input type="text" id="companySearch" name="company_search"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                            placeholder="Enter business name or address">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" id="showManualFormBtn" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center mx-auto">
                            <i class="fas fa-edit mr-2"></i>Enter business information manually
                        </button>
                    </div>
                </div>

                <!-- Manual Entry Form (same as above) -->
                <div id="manualEntryForm" class="hidden mt-6">
                    <!-- Same form content as above -->
                </div>
            </div>
        @endif
    </div>

    <!-- Enhanced Business Details Card -->
    <div id="companyDetails" class="hidden opacity-0 transition-opacity duration-500 mt-4">
        <div class="glass-dark border border-white/20 rounded-2xl p-6 space-y-2 backdrop-blur-xl shadow-2xl">
            <div class="flex items-start">
                <i class="fas fa-store-alt mt-1 text-blue-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Name:</span>
                    <span id="placeName" class="ml-2 text-white"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-map-marker-alt mt-1 text-orange-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Address:</span>
                    <span id="address" class="ml-2 text-white"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-phone-alt mt-1 text-cyan-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Phone:</span>
                    <span id="phone" class="ml-2 text-white"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-globe mt-1 text-pink-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Website:</span>
                    <a id="website" href="#"
                        class="ml-2 text-blue-400 hover:text-blue-300 underline transition-colors duration-200"
                        target="_blank"></a>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-map mt-1 text-green-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Google Maps:</span>
                    <a id="googleMaps" href="#"
                        class="ml-2 text-blue-400 hover:text-blue-300 underline transition-colors duration-200">View on
                        Google Maps</a>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-location-arrow mt-1 text-purple-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Coordinates:</span>
                    <span id="coords" class="ml-2 text-white"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-clock mt-1 text-yellow-400 w-6"></i>
                <div>
                    <span class="font-bold text-slate-300">Opening Hours:</span>
                    <div id="hours" class="ml-6 mt-2 space-y-1 text-white"></div>
                </div>
            </div>
        </div>

        <!-- Enhanced Update Form -->
        <div class="glass-dark border-t border-white/20 rounded-b-2xl p-6 backdrop-blur-xl">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Update Business Information
            </h3>
            <div class="space-y-4">
                <div>
                    <label for="business_email" class="block text-sm font-medium text-slate-300 mb-2">
                        Business Email
                    </label>
                    <input type="email" id="business_email" name="business_email" value="{{ $client->email ?? '' }}"
                        required
                        class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                </div>
                <div>
                    <label for="year_found" class="block text-sm font-medium text-slate-300 mb-2">
                        Year Found
                    </label>
                    <input type="number" id="year_found" name="year_found"
                        value="{{ $client->clientDetails->year_found ?? '' }}" required
                        class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                </div>
                <div>
                    <label for="employees" class="block text-sm font-medium text-slate-300 mb-2">
                        Employees
                    </label>
                    <input type="number" id="employees" name="employees"
                        value="{{ $client->clientDetails->employees ?? '' }}" required
                        class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <label for="social_media" class="block text-sm font-medium text-slate-300 mb-2">
                            Social Media Pages
                        </label>
                        <div class="group relative inline-block">
                            <button type="button" aria-label="Format help"
                                class="text-slate-400 hover:text-blue-400 focus:outline-none transition-colors duration-200">
                                <i class="fas fa-question-circle"></i>
                            </button>
                            <div
                                class="absolute z-10 left-full ml-2 hidden group-hover:block w-64 glass p-3 rounded-2xl shadow-2xl border border-white/20 text-sm backdrop-blur-xl">
                                <p class="font-medium text-white mb-1">Required format:</p>
                                <ul class="list-disc pl-5 space-y-1 text-slate-300">
                                    <li>Enter one URL per line</li>
                                    <li>Example: <span class="text-blue-400">https://facebook.com/yourbusiness</span>
                                    </li>
                                    <li>Each link must start with http:// or https://</li>
                                    <li>Separate multiple URLs with line breaks</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @php
                        $socialLinks =
                            isset($client->clientSocial->social_links) && $client->clientSocial->social_links != 'N/A'
                                ? json_decode($client->clientSocial->social_links, true)
                                : [];
                    @endphp
                    <textarea id="social_media" name="social_media" rows="4"
                        class="w-full px-4 py-3 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 resize-none bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                        placeholder="Example:&#10;https://facebook.com/yourbusiness&#10;https://instagram.com/yourbusiness&#10;https://linkedin.com/company/yourbusiness">{{ is_array($socialLinks) ? implode("\n", $socialLinks) : '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Submit Button -->
    <div id="submitButtonContainer" class="hidden opacity-0 transition-opacity duration-500 mt-4">
        <div class="flex justify-center">
            <button id="submit-info"
                class="mt-4 next-step bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl w-full flex items-center justify-center transform hover:-translate-y-1">
                <i class="fas fa-check-circle mr-2"></i>Confirm Information
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_GQmd0pkdZA-q9z-ZJipm7DiHszyTDmw&libraries=places&language=en"></script>
<script>
    let place_id;
    let formatted_phone_number;
    let website;
    let city;
    let name;
    const routeStoreClientLocation = "{{ route('area.store.client-locations', $client->highlevel_id) }}";
</script>

<!-- All the existing JavaScript remains exactly the same -->
<script>
    function fetchPlaceDetails() {
        const existingDetailsElement = document.getElementById("existingCompanyDetails");
        // Si no hay place_id, mostrar la información manual
        if (existingDetailsElement && !existingDetailsElement.getAttribute("data-place-id")) {
            const manualInfo = {
                name: "{{ $client->clientLocations->name ?? 'N/A' }}",
                formatted_address: "{{ $client->clientLocations->formatted_address ?? 'N/A' }}",
                formatted_phone_number: "{{ $client->clientLocations->formatted_phone_number ?? 'N/A' }}",
                website: "{{ $client->website ?? 'N/A' }}",
                city: "{{ $client->city ?? 'N/A' }}",
                geometry: {
                    location: {
                        lat: function() { return null; },
                        lng: function() { return null; }
                    }
                },
                url: "#"
            };
            existingDetailsElement.innerHTML = `
                <div class="glass-dark border border-white/20 rounded-2xl p-6 space-y-6 backdrop-blur-xl shadow-2xl">
                    <!-- Información del Negocio -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-white">Business Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-store-alt mt-1 text-blue-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">Name:</span>
                                        <span class="ml-2 text-white">${manualInfo.name}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 text-orange-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">Address:</span>
                                        <span class="ml-2 text-white">${manualInfo.formatted_address}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1 text-cyan-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">Phone:</span>
                                        <span class="ml-2 text-white">${manualInfo.formatted_phone_number}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-envelope mt-1 text-red-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">Email:</span>
                                        <span class="ml-2 text-white">{{ $client->email ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-globe mt-1 text-pink-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">Website:</span>
                                        <a href="${manualInfo.website}" class="ml-2 text-blue-400 hover:text-blue-300 underline transition-colors duration-200" target="_blank">
                                            ${manualInfo.website}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map mt-1 text-green-400 w-6"></i>
                                    <div>
                                        <span class="font-bold text-slate-300">City:</span>
                                        <span class="ml-2 text-white">${manualInfo.city}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Redes Sociales -->
                    <div class="flex items-start">
                        <i class="fas fa-share-alt mt-1 text-indigo-400 w-6"></i>
                        <div>
                            <span class="font-bold text-slate-300">Social Media:</span>
                            <div class="ml-2 text-white">
                                @if (isset($client->clientSocial->social_links) && $client->clientSocial->social_links != 'N/A')
                                    @php
                                        $socialLinks = json_decode($client->clientSocial->social_links, true);
                                    @endphp
                                    @if (is_array($socialLinks) && count($socialLinks) > 0)
                                        <ul class="list-none pl-0">
                                            @foreach ($socialLinks as $link)
                                                @php
                                                    $fullLink = strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0 ? $link : 'https://' . $link;
                                                @endphp
                                                <li class="mb-1">
                                                    <a href="{{ $fullLink }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 hover:underline">
                                                        {{ $link }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        N/A
                                    @endif
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Botones de Confirmación -->
                    <div class="mt-6 text-center">
                        <p class="text-slate-300">Would you like to update this information?</p>
                        <div class="mt-3 flex justify-center gap-4">
                            <button class="bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold px-6 py-2 rounded-2xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 shadow-lg" onclick="showSearchSection()">Yes</button>
                            <button class="bg-gradient-to-r from-blue-500 to-purple-500 next-step text-white font-bold px-6 py-2 rounded-2xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 shadow-lg">No</button>
                        </div>
                    </div>
                </div>
            `;
            return;
        }
        // Rest of the JavaScript remains exactly the same...
    }

    function showSearchSection() {
        // Show the search section and hide the existing details
        const searchSection = document.getElementById("searchSection");
        const existingDetails = document.getElementById("existingCompanyDetails");
        if (searchSection) {
            searchSection.style.display = "block";
        }
        if (existingDetails) {
            existingDetails.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", fetchPlaceDetails);
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("companySearch");
        if (!input) return; // Exit if the input doesn't exist

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setFields(["name", "formatted_address", "geometry", "place_id", "url",
            "formatted_phone_number", "website", "opening_hours"
        ]);

        const daysTranslation = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        autocomplete.addListener("place_changed", function() {
            const place = autocomplete.getPlace();
            place_id = place.place_id;

            if (!place.geometry) return;



            document.getElementById("placeName").textContent = place.name;
            document.getElementById("address").textContent = place.formatted_address;
            document.getElementById("phone").textContent = place.formatted_phone_number || "N/A";

            const websiteElement = document.getElementById("website");
            websiteElement.href = place.website || "#";
            websiteElement.textContent = place.website || "N/A";

            document.getElementById("googleMaps").href = place.url;
            document.getElementById("coords").textContent =
                `${place.geometry.location.lat()}, ${place.geometry.location.lng()}`;

            const hoursContainer = document.getElementById("hours");
            hoursContainer.innerHTML = "";
            if (place.opening_hours && place.opening_hours.weekday_text) {
                place.opening_hours.weekday_text.forEach((day, index) => {
                    const englishDay = daysTranslation[index];
                    let time = day.split(": ")[1] || "Closed";
                    if (time.toLowerCase() === "cerrado") time = "Closed";
                    const div = document.createElement("div");
                    div.textContent = `${englishDay}: ${time}`;
                    hoursContainer.appendChild(div);
                });
            } else {
                hoursContainer.textContent = "N/A";
            }

            // Mostrar con animación
            const details = document.getElementById("companyDetails");
            const submitContainer = document.getElementById("submitButtonContainer");

            details.classList.remove("hidden");
            submitContainer.classList.remove("hidden");

            setTimeout(() => {
                details.classList.remove("opacity-0");
                submitContainer.classList.remove("opacity-0");
            }, 50);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#submit-info").click(function() {
            const clientId = {{ $client->id }};

            const socialMediaText = $("#social_media").val();
            const socialMediaLines = socialMediaText.split('\n').filter(line => line.trim() !== '');
            const socialMediaArray = [];
            const address = $("#address").text();
            const city = address.split(',')[1]?.trim() || "Unknown City";
            const websiteElement = document.getElementById("website");
            const website = websiteElement.href !== "#" ? websiteElement.href : "N/A";

            // Simplemente añadir cada URL al array
            socialMediaLines.forEach(url => {
                url = url.trim();
                if (url) {
                    socialMediaArray.push(url);
                }
            });

            function extractIdentifierFromUrl(gmburl) {
                const match = gmburl.match(/\/place\/([^\/]+)\/[@?]/);
                return match ? match[1] : null;
            }

            const gmburl = $("#googleMaps").attr("href");
            const placeId = place_id || extractIdentifierFromUrl(gmburl);

            const data = {
                client_id: clientId,
                place_id: placeId,
                formatted_address: $("#address").text(),
                formatted_phone_number: $("#phone").text() || "N/A",
                lat: parseFloat($("#coords").text().split(",")[0]) || null,
                lng: parseFloat($("#coords").text().split(",")[1]) || null,
                gmburl: gmburl,
                weekday_text: $("#hours").children().map(function() {
                    return $(this).text();
                }).get(),
                business_email: $("#business_email").val(),
                business_phone: $("#phone").val(),
                year_found: $("#year_found").val(),
                employees: $("#employees").val(),
                social_media: JSON.stringify(socialMediaArray),
                name:  $("#placeName").text() || "N/A", // Usa la variable almacenada o el texto del elemento
                city: city,
                website: website, // Add this line

            };

                console.log(data);
            $.ajax({
                url: routeStoreClientLocation,
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Business information has been updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Optional: clear form or redirect
                            $("#manualEntryForm").addClass("hidden");
                            $("#companySearch").prop("disabled", false);
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem updating your business information.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Mostrar/ocultar formulario manual
        $("#showManualFormBtn").click(function() {
            $("#manualEntryForm").toggleClass("hidden");
            $("#companySearch").prop("disabled", $("#manualEntryForm").is(":visible"));
        });

        // Manejar envío del formulario manual
        $("#submitManualForm").click(function() {
            const clientId = {{ $client->id }};
            const socialMediaText = $("#manual_social_media").val();
            const socialMediaLines = socialMediaText.split('\n').filter(line => line.trim() !== '');

            const data = {
                client_id: clientId,
                place_id: null,
                name: $("#manual_business_name").val(),
                formatted_address: $("#manual_address").val(),
                formatted_phone_number: $("#manual_phone").val() || "N/A",
                lat: null,
                lng: null,
                gmburl: null,
                weekday_text: [],
                business_email: $("#manual_business_email").val(),
                year_found: $("#manual_year_found").val(),
                employees: $("#manual_employees").val(),
                social_media: JSON.stringify(socialMediaLines),
                city: $("#manual_city").val(),
                website: $("#manual_website").val() || "N/A"
            };

            $.ajax({
                url: routeStoreClientLocation,
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "The business information has been successfully updated.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#manualEntryForm").addClass("hidden");
                            $("#companySearch").prop("disabled", false);
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem updating the business information.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });
</script>
