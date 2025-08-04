<div id="services-tab" class="tab-content p-6 hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Services -->
        <div class="glass-dark rounded-2xl border border-white/15 p-5 backdrop-blur-xl">
            <div class="flex justify-between items-center mb-4 border-b border-white/15 pb-2">
                <h3 class="text-lg font-semibold text-white">Services</h3>
                <button type="button" id="add-service" 
                    class="px-3 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg">
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
                        <div class="service-item glass rounded-xl p-3 border border-white/20 backdrop-blur-xl">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-white">Service #{{ $index + 1 }}</h4>
                                <button type="button" class="remove-service text-red-400 hover:text-red-300 text-sm transition-colors duration-200"
                                    onclick="removeService(this)">
                                    <i class="fas fa-trash mr-1"></i> Remove
                                </button>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300">Service Name</label>
                                <input type="text" name="services[{{ $index }}][name]"
                                    value="{{ $service ?? '' }}"
                                    class="mt-1 block w-full glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-xl">
                            </div>
                          
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Service Areas -->
        <div class="glass-dark rounded-2xl border border-white/15 p-5 backdrop-blur-xl">
            <div class="flex justify-between items-center mb-4 border-b border-white/15 pb-2">
                <h3 class="text-lg font-semibold text-white">Service Areas</h3>
                <button type="button" id="add-area" 
                    class="px-3 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg">
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
                                class="block w-full glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-xl">
                            <button type="button" class="ml-2 text-red-400 hover:text-red-300 transition-colors duration-200 p-1 rounded-lg hover:bg-red-500/10"
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
    <div class="glass-dark rounded-2xl border border-white/15 p-5 mt-6 backdrop-blur-xl">
        <h3 class="text-lg font-semibold mb-4 border-b border-white/15 pb-2 text-white">Extra Services</h3>
        <div>
            <label for="extra_service" class="block text-sm font-medium text-slate-300">Additional Service Information (JSON)</label>
            <textarea name="extra_service" id="extra_service"
                class="mt-1 block w-full h-32 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 font-mono backdrop-blur-xl"
                placeholder="Enter extra services in JSON format...">{{ $client->extra_service }}</textarea>
        </div>
    </div>
</div>