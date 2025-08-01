<div id="services-tab" class="tab-content p-6 hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Services -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-lg font-semibold">Services</h3>
                <button type="button" id="add-service" 
                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Add Service
                </button>
            </div>
            
            <div id="services-container" class="space-y-3">
                @if ($client->services)
                    @php
                        $services = is_array($client->services) ? $client->services : (is_string($client->services) ? json_decode($client->services, true) : []);
                        $services = $services ?: [];
                    @endphp
                    @foreach ($services as $index => $service)
                        <div class="service-item bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-gray-700">Service #{{ $index + 1 }}</h4>
                                <button type="button" class="remove-service text-red-600 hover:text-red-800 text-sm"
                                    onclick="removeService(this)">
                                    <i class="fas fa-trash mr-1"></i> Remove
                                </button>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service Name</label>
                                <input type="text" name="services[{{ $index }}][name]"
                                    value="{{ $service ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                          
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Service Areas -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-lg font-semibold">Service Areas</h3>
                <button type="button" id="add-area" 
                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Add Area
                </button>
            </div>
            
            <div id="areas-container" class="space-y-2">
                @if ($client->areas)
                    @php
                        $areas = is_array($client->areas) ? $client->areas : (is_string($client->areas) ? json_decode($client->areas, true) : []);
                        $areas = $areas ?: [];
                    @endphp
                    @foreach ($areas as $index => $area)
                        <div class="area-item flex items-center">
                            <input type="text" name="areas[]" value="{{ $area }}"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="button" class="ml-2 text-red-600 hover:text-red-800"
                                onclick="removeArea(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    
    <!-- Extra Services -->
    <div class="bg-white rounded-lg border border-gray-200 p-5 mt-6">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Extra Services</h3>
        <div>
            <label for="extra_service" class="block text-sm font-medium text-gray-700">Additional Service Information (JSON)</label>
            <textarea name="extra_service" id="extra_service"
                class="mt-1 block w-full h-32 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono"
                placeholder="Enter extra services in JSON format...">{{ $client->extra_service }}</textarea>
        </div>
    </div>
</div>