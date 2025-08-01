<div class="hidden tab-content" id="location-tab">
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-6">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex items-start">

                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 text-blue-600 w-6"></i>
                        <div class="w-full">
                            <label class="block text-gray-700 font-bold">Address</label>
                            <input 
                                id="business-address"
                                type="text" 
                                name="location[address]"
                                value="{{ $client->clientLocations->formatted_address ?? ''  }}"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-start">
                        <i class="fas fa-map mt-1 text-blue-600 w-6"></i>
                        <div class="w-full">
                            <label class="block text-gray-700 font-bold">Google Maps</label>
                            <input 
                                id="business-gmb-url"
                                type="text" 
                                name="location[gmburl]"
                                value="{{ $client->clientLocations->gmburl ?? '' }}" 
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-location-arrow mt-1 text-blue-600 w-6"></i>
                        <div class="w-full">
                            <label class="block text-gray-700 font-bold">Coordinates</label>
                            <div class="flex space-x-2 mt-1">
                                <input 
                                    id="business-latitude"
                                    type="text" 
                                    name="location[latitude]"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ $client->clientLocations->lat ?? '40.7128' }}"
                                >
                                <input 
                                    id="business-longitude"
                                    type="text" 
                                    name="location[longitude]"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ $client->clientLocations->lng ?? '-74.0060' }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="flex items-start">
                    <i class="fas fa-clock mt-1 text-blue-600 w-6"></i>
                    <div>
                        
                        <span class="font-bold">Opening Hours:</span>
                        <div class="ml-6 mt-2 space-y-1">
                            <textarea 
                                name="location[weekday_text]" 
                                rows="7"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >@if (!empty($client->clientLocations->weekday_text) && is_array(json_decode($client->clientLocations->weekday_text, true)))
@foreach (json_decode($client->clientLocations->weekday_text, true) as $day)
{{ str_replace(["\u202f", "\u2009"], " ", $day) }}
@endforeach
@endif</textarea>
                        </div>
                        
                        
                    </div>
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
</div>