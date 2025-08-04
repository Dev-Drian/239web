<div class="hidden tab-content" id="citation-tab">
    <div class="max-w-6xl mx-auto p-6">
        <div class="glass-dark rounded-lg border border-white/15 shadow-sm">
            <!-- Header -->
            <div class="p-6 border-b border-white/15 bg-gradient-to-r from-amber-500/10 to-orange-500/10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-500/20 rounded-lg">
                        <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Citation Information</h3>
                        <p class="text-sm text-slate-300 mt-1">Business directory and local citation details</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Business Owner Section -->
                    <div class="glass rounded-lg p-5 border border-white/20">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-indigo-300 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Business Owner
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label for="owner_name" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Owner Full Name
                                </label>
                                <input type="text" id="owner_name" name="citation[owner_name]" 
                                    value="{{ $client->clientExtra->owner_name ?? '' }}"
                                    placeholder="Enter business owner's full name"
                                    class="w-full px-4 py-3 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Location Details Section -->
                    <div class="glass rounded-lg p-5 border border-white/20">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-green-300 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Location Details
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="address_line2" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Address Line 2
                                </label>
                                <input type="text" id="address_line2" name="citation[address_line2]"
                                    value="{{ $client->clientExtra->address_line2 ?? '' }}"
                                    placeholder="Suite, Unit, Building, etc."
                                    class="w-full px-4 py-3 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-semibold text-slate-300 mb-2">
                                    State/Province
                                </label>
                                <input type="text" id="state" name="citation[state]" 
                                    value="{{ $client->clientExtra->state ?? '' }}"
                                    placeholder="Enter state or province"
                                    class="w-full px-4 py-3 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="zip_code" class="block text-sm font-semibold text-slate-300 mb-2">
                                    ZIP/Postal Code
                                </label>
                                <input type="text" id="zip_code" name="citation[zip]" 
                                    value="{{ $client->clientExtra->zip ?? '' }}"
                                    placeholder="Enter ZIP or postal code"
                                    class="w-full px-4 py-3 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="glass rounded-lg p-5 border border-white/20">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-purple-300 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Contact Information
                        </h4>
                        <div>
                            <label for="business_fax" class="block text-sm font-semibold text-slate-300 mb-2">
                                Business Fax Number
                            </label>
                            <input type="text" id="business_fax" name="citation[business_fax]"
                                value="{{ $client->clientExtra->business_fax ?? '' }}"
                                placeholder="Enter fax number (optional)"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200">
                        </div>
                    </div>

                    <!-- Directory Listings Section -->
                    <div class="bg-indigo-50 rounded-lg p-5 border border-indigo-200">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-indigo-800 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Directory Listings
                        </h4>
                        <div>
                            <label for="directory_list" class="block text-sm font-semibold text-gray-700 mb-2">
                                Directory Platforms
                            </label>
                            <input type="text" id="directory_list" name="citation[directory_list]"
                                value="{{ $client->clientExtra->directory_list ?? '' }}"
                                placeholder="Google My Business, Yelp, Yellow Pages, etc."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                            <p class="text-xs text-indigo-600 mt-2 flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Separate multiple directories with commas
                            </p>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="bg-rose-50 rounded-lg p-5 border border-rose-200">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-rose-800 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Business Media
                        </h4>
                        <div>
                            <label for="photo_3_url" class="block text-sm font-semibold text-gray-700 mb-2">
                                Additional Photo URL
                            </label>
                            <input type="url" id="photo_3_url" name="citation[photo_url3]" 
                                value="{{ $client->clientExtra->photo_url3 ?? '' }}"
                                placeholder="https://example.com/business-photo.jpg"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-200 transition-all duration-200">
                            <p class="text-xs text-rose-600 mt-2 flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Enter a valid URL for the business photo
                            </p>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <h4 class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Special Instructions
                        </h4>
                        <div>
                            <label for="instructions_notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                Instructions & Notes
                            </label>
                            <textarea id="instructions_notes" name="citation[instructions_notes]" rows="4"
                                placeholder="Add any special instructions, notes, or requirements for citation management..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all duration-200 resize-none">{{ $client->clientExtra->instructions_notes ?? '' }}</textarea>
                        </div>
                    </div>

                </div>

                <!-- Summary Card -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-blue-900 mb-1">Citation Management Tips</h5>
                            <p class="text-sm text-blue-700 leading-relaxed">
                                Ensure all information is consistent across directories. Complete profiles with accurate business details, 
                                contact information, and high-quality photos improve local search visibility and customer trust.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>