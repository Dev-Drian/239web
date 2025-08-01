<div id="basic-tab" class="tab-content p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Client Info -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Client Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Client Name*</label>
                    <input type="text" id="name" name="name" value="{{ $client->name ?? ''  }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="highlevel_id" class="block text-sm font-medium text-gray-700">Highlevel ID</label>
                    <input type="text" id="highlevel_id" name="highlevel_id" disabled
                        value="{{ $client->highlevel_id }}"
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address*</label>
                    <input type="email" id="email" name="email" value="{{ $client->email ?? '' }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="text" id="website" name="website" value="{{ $client->website  ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    
                    <div>
                        <label for="premium" class="block text-sm font-medium text-gray-700">Account Type</label>
                        <select id="premium" name="premium"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1" {{ $client->premium ? 'selected' : '' }}>Premium</option>
                            <option value="0" {{ !$client->premium ? 'selected' : '' }}>Standard</option>
                        </select>
                    </div>
                </div>
                
               
            </div>
        </div>

        <!-- Contact & Additional Info -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Contact & Additional Info</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                    <input type="text" id="full_name" name="details[full_name]"
                        value="{{ $client->ClientDetails->full_name ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" name="details[phone]"
                        value="{{ $client->clientLocations->formatted_phone_number ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="address" name="address" value="{{ $client->address ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="city" name="city" value="{{ $client->city ?? ''  }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="year_found" class="block text-sm font-medium text-gray-700">Year Founded</label>
                        <input type="number" id="year_found" name="details[year_found]" 
                            value="{{ $client->ClientDetails->year_found ?? '' }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            min="1000" max="9999" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4)">
                    </div>
                    
                    
                    <div>
                        <label for="employees" class="block text-sm font-medium text-gray-700">Employees</label>
                        <input type="number" id="employees" name="details[employees]"
                            value="{{ $client->ClientDetails->employees ?? '' }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>