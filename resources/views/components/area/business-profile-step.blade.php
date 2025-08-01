<div class="form-step hidden animate__animated" id="step-1">
    <div class="w-full max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Cabecera -->
<!-- Business Profile Header with Info Tooltip inside -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
    <div class="flex items-center justify-between">
      <!-- Business Profile Title -->
      <h2 class="text-2xl font-bold text-white flex items-center">
        <i class="fas fa-briefcase mr-3"></i>Business Profile
      </h2>
      
      <!-- Info tooltip inside the header - only visible on hover -->
      <div class="relative group inline-block cursor-pointer">
        <!-- Info icon - made more visible with border -->
        <span class="flex items-center justify-center w-6 h-6 text-blue-600 bg-white rounded-full border-2 border-blue-300 shadow-md transition-all duration-300 group-hover:shadow-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </span>
        
        <!-- Tooltip content - hidden by default, visible on hover -->
        <div class="absolute z-20 right-0 mt-2 w-64 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 shadow-xl invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300">
          <!-- Tooltip body - removed header and learn more link -->
          <div class="px-4 py-3">
            <p>For Businesses with Address Visible on Google</p>
          </div>
          
          <!-- Arrow pointer -->
          <div class="absolute -top-2 right-2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-l-transparent border-r-transparent border-b-white"></div>
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
                    <label for="companySearch" class="block text-sm font-medium text-gray-700 mb-2">
                        Search for Your Business:
                    </label>
                    <div class="relative">
                        <input type="text" id="companySearch" name="company_search"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Enter business name or address">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" id="showManualFormBtn" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit mr-2"></i>Enter business information manually
                        </button>
                    </div>
                </div>

                <!-- Manual Entry Form -->
                <div id="manualEntryForm" class="hidden mt-6">
                    <div class="space-y-4">
                        <div>
                            <label for="manual_business_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Name *
                            </label>
                            <input type="text" id="manual_business_name" name="manual_business_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Address *
                            </label>
                            <input type="text" id="manual_address" name="manual_address" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_city" class="block text-sm font-medium text-gray-700 mb-2">
                                City *
                            </label>
                            <input type="text" id="manual_city" name="manual_city" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="manual_phone" name="manual_phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_website" class="block text-sm font-medium text-gray-700 mb-2">
                                Website
                            </label>
                            <input type="url" id="manual_website" name="manual_website"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="https://example.com">
                        </div>

                        <div>
                            <label for="manual_business_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Email *
                            </label>
                            <input type="email" id="manual_business_email" name="manual_business_email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_year_found" class="block text-sm font-medium text-gray-700 mb-2">
                                Year Found *
                            </label>
                            <input type="number" id="manual_year_found" name="manual_year_found" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_employees" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Employees *
                            </label>
                            <input type="number" id="manual_employees" name="manual_employees" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_social_media" class="block text-sm font-medium text-gray-700 mb-2">
                                Social Media Links
                            </label>
                            <textarea id="manual_social_media" name="manual_social_media" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Enter one URL per line:
https://facebook.com/yourbusiness
https://instagram.com/yourbusiness"></textarea>
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="button" id="submitManualForm"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-medium transition duration-200 shadow-md w-full flex items-center justify-center">
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
                    <label for="companySearch" class="block text-sm font-medium text-gray-700 mb-2">
                        Search for Your Business:
                    </label>
                    <div class="relative">
                        <input type="text" id="companySearch" name="company_search"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Enter business name or address">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" id="showManualFormBtn" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit mr-2"></i>Enter business information manually
                        </button>
                    </div>
                </div>

                <!-- Manual Entry Form -->
                <div id="manualEntryForm" class="hidden mt-6">
                    <div class="space-y-4">
                        <div>
                            <label for="manual_business_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Name *
                            </label>
                            <input type="text" id="manual_business_name" name="manual_business_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Address *
                            </label>
                            <input type="text" id="manual_address" name="manual_address" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_city" class="block text-sm font-medium text-gray-700 mb-2">
                                City *
                            </label>
                            <input type="text" id="manual_city" name="manual_city" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="manual_phone" name="manual_phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_website" class="block text-sm font-medium text-gray-700 mb-2">
                                Website
                            </label>
                            <input type="url" id="manual_website" name="manual_website"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="https://example.com">
                        </div>

                        <div>
                            <label for="manual_business_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Business Email *
                            </label>
                            <input type="email" id="manual_business_email" name="manual_business_email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_year_found" class="block text-sm font-medium text-gray-700 mb-2">
                                Year Found *
                            </label>
                            <input type="number" id="manual_year_found" name="manual_year_found" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_employees" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Employees *
                            </label>
                            <input type="number" id="manual_employees" name="manual_employees" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="manual_social_media" class="block text-sm font-medium text-gray-700 mb-2">
                                Social Media Links
                            </label>
                            <textarea id="manual_social_media" name="manual_social_media" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Enter one URL per line:
https://facebook.com/yourbusiness
https://instagram.com/yourbusiness"></textarea>
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="button" id="submitManualForm"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-medium transition duration-200 shadow-md w-full flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>Save Business Information
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Business Details Card (Hidden by Default) -->
    <div id="companyDetails" class="hidden opacity-0 transition-opacity duration-500 mt-4">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-2">
            <div class="flex items-start">
                <i class="fas fa-store-alt mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Name:</span>
                    <span id="placeName" class="ml-2 text-gray-800"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-map-marker-alt mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Address:</span>
                    <span id="address" class="ml-2 text-gray-800"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-phone-alt mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Phone:</span>
                    <span id="phone" class="ml-2 text-gray-800"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-globe mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Website:</span>
                    <a id="website" href="#"
                        class="ml-2 text-blue-600 hover:text-blue-800 underline transition-colors duration-200"
                        target="_blank"></a>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-map mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Google Maps:</span>
                    <a id="googleMaps" href="#"
                        class="ml-2 text-blue-600 hover:text-blue-800 underline transition-colors duration-200">View on
                        Google Maps</a>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-location-arrow mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold text-gray-700">Coordinates:</span>
                    <span id="coords" class="ml-2 text-gray-800"></span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-clock mt-1 text-blue-600 w-6"></i>
                <div>
                    <span class="font-bold">Opening Hours:</span>
                    <div id="hours" class="ml-6 mt-2 space-y-1"></div>
                </div>
            </div>
        </div>
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Update Business Information</h3>

            <div class="space-y-4">
                <div>
                    <label for="business_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Email
                    </label>
                    <input type="email" id="business_email" name="business_email" value="{{ $client->email ?? '' }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <div>
                    <label for="year_found" class="block text-sm font-medium text-gray-700 mb-2">
                        Year Found
                    </label>
                    <input type="number" id="year_found" name="year_found"
                        value="{{ $client->clientDetails->year_found ?? '' }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <div>
                    <label for="employees" class="block text-sm font-medium text-gray-700 mb-2"></label>
                        Employees
                    </label>
                    <input type="number" id="employees" name="employees"
                        value="{{ $client->clientDetails->employees ?? '' }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <div class="relative">
                    <div class="flex items-center justify-between">
                        <label for="social_media" class="block text-sm font-medium text-gray-700 mb-2">
                            Social Media Pages
                        </label>
                        <div class="group relative inline-block">
                            <button type="button" aria-label="Format help"
                                class="text-gray-400 hover:text-blue-500 focus:outline-none">
                                <i class="fas fa-question-circle"></i>
                            </button>
                            <div
                                class="absolute z-10 left-full ml-2 hidden group-hover:block w-64 bg-white p-3 rounded-lg shadow-lg border border-gray-200 text-sm">
                                <p class="font-medium text-gray-800 mb-1">Required format:</p>
                                <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                    <li>Enter one URL per line</li>
                                    <li>Example: <span class="text-blue-500">https://facebook.com/yourbusiness</span>
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Example:
                  https://facebook.com/yourbusiness
                  https://instagram.com/yourbusiness
                  https://linkedin.com/company/yourbusiness">{{ is_array($socialLinks) ? implode("\n", $socialLinks) : '' }}
                </textarea>
                </div>
            </div>

        </div>
    </div>

    <div id="submitButtonContainer" class="hidden opacity-0 transition-opacity duration-500 mt-4">
        <div class="flex justify-center">
            <button id="submit-info"
                class="mt-4 next-step bg-blue-600 hover:bg-blue-
                 text-white px-8 py-4 rounded-lg font-medium transition duration-200 shadow-md w-full flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>Confirm Information
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_GQmd0pkdZA-q9z-ZJipm7DiHszyTDmw&libraries=places&language=en">
</script>

<script>
    let place_id;
    let formatted_phone_number;
    let website;
    let city;
    let name;
    const routeStoreClientLocation = "{{ route('area.store.client-locations', $client->highlevel_id) }}";
</script>

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
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-6">
                    <!-- Información del Negocio -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-800">Business Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-store-alt mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">Name:</span>
                                        <span class="ml-2 text-gray-800">${manualInfo.name}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">Address:</span>
                                        <span class="ml-2 text-gray-800">${manualInfo.formatted_address}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">Phone:</span>
                                        <span class="ml-2 text-gray-800">${manualInfo.formatted_phone_number}</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-envelope mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">Email:</span>
                                        <span class="ml-2 text-gray-800">{{ $client->email ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-globe mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">Website:</span>
                                        <a href="${manualInfo.website}" class="ml-2 text-blue-600 hover:text-blue-800 underline transition-colors duration-200" target="_blank">
                                            ${manualInfo.website}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map mt-1 text-blue-600 w-6"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">City:</span>
                                        <span class="ml-2 text-gray-800">${manualInfo.city}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="flex items-start">
                        <i class="fas fa-share-alt mt-1 text-blue-600 w-6"></i>
                        <div>
                            <span class="font-bold text-gray-700">Social Media:</span>
                            <div class="ml-2 text-gray-800">
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
                                                    <a href="{{ $fullLink }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700 hover:underline">
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
                        <p class="text-gray-700">Would you like to update this information?</p>
                        <div class="mt-3 flex justify-center gap-4">
                            <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-800" onclick="showSearchSection()">Yes</button>
                            <button class="bg-blue-600 next-step text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-800">No</button>
                        </div>
                    </div>
                </div>
            `;
            return;
        }

        // Si hay place_id, continuar con la lógica existente de Google Places
        if (existingDetailsElement && existingDetailsElement.getAttribute("data-place-id")) {
            const placeId = existingDetailsElement.getAttribute("data-place-id");
            const service = new google.maps.places.PlacesService(document.createElement('div'));

            service.getDetails({
                placeId: placeId,
                fields: ["name", "formatted_address", "geometry", "place_id", "url", "formatted_phone_number",
                    "website", "opening_hours"
                ]
            }, function(place, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    const openingHours = place.opening_hours?.weekday_text ?
                        place.opening_hours.weekday_text.map(day => {
                            const [dayName, hours] = day.split(": ");
                            return `<div>${dayName}: ${hours || "Closed"}</div>`;
                        }).join("") :
                        "<div>Closed</div>";

                    existingDetailsElement.innerHTML = `
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-6">
                        <!-- Información del Negocio -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-gray-800">Business Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <div class="flex items-start">
                                        <i class="fas fa-store-alt mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Name:</span>
                                            <span class="ml-2 text-gray-800">${place.name || "N/A"}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-map-marker-alt mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Address:</span>
                                            <span class="ml-2 text-gray-800">${place.formatted_address || "N/A"}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-phone-alt mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Phone:</span>
                                            <span class="ml-2 text-gray-800">{{ $client->clientDetails->phone ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-envelope mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Email:</span>
                                            <span class="ml-2 text-gray-800">{{ $client->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-start">
                                        <i class="fas fa-globe mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Website:</span>
                                            <a href="${place.website || "#"}" class="ml-2 text-blue-600 hover:text-blue-800 underline transition-colors duration-200" target="_blank">
                                                ${place.website || "N/A"}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-map mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Google Maps:</span>
                                            <a href="${place.url || "#"}" class="ml-2 text-blue-600 hover:text-blue-800 underline transition-colors duration-200">
                                                View on Google Maps
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-location-arrow mt-1 text-blue-600 w-6"></i>
                                        <div>
                                            <span class="font-bold text-gray-700">Coordinates:</span>
                                            <span class="ml-2 text-gray-800">
                                                ${place.geometry?.location?.lat() || "N/A"},
                                                ${place.geometry?.location?.lng() || "N/A"}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Horarios y Redes Sociales -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="flex items-start">
                                <i class="fas fa-clock mt-1 text-blue-600 w-6"></i>
                                <div>
                                    <span class="font-bold">Opening Hours:</span>
                                    <div class="ml-6 mt-2 space-y-1">
                                        ${openingHours}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-share-alt mt-1 text-blue-600 w-6"></i>
                                <div>
                                    <span class="font-bold text-gray-700">Social Media:</span>
                                    <div class="ml-2 text-gray-800">
                                        @if (isset($client->clientSocial->social_links) && $client->clientSocial->social_links != 'N/A')
                                            @php
                                                $socialLinks = json_decode($client->clientSocial->social_links, true);
                                            @endphp

                                            @if (is_array($socialLinks) && count($socialLinks) > 0)
                                                <ul class="list-none pl-0">
                                                    @foreach ($socialLinks as $link)
                                                        @php
                                                            // Añadir https:// si no tiene protocolo
                                                            $fullLink = strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0 ? $link : 'https://' . $link;
                                                        @endphp
                                                        <li class="mb-1">
                                                            <a href="{{ $fullLink }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700 hover:underline">
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
                        </div>

                        <!-- Botones de Confirmación -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-700">Would you like to update this information?</p>
                            <div class="mt-3 flex justify-center gap-4">
                                <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-800" onclick="showSearchSection()">Yes</button>
                                <button class="bg-blue-600 next-step text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-800">No</button>
                            </div>
                        </div>
                    </div>
                    `;
                } else {
                    console.error("Error fetching place details:", status);
                    // If there's an error fetching place details, show the search section
                    showSearchSection();
                }
            });
        } else {
            // If there's no existing data, show the search section
            showSearchSection();
        }
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
