<div class="mb-6">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    <!-- Enhanced Location Selector -->
    <div class="relative group">
        <select id="location" name="user_location"
            class="block w-full pl-12 pr-10 py-4 text-base text-white glass border border-white/20 rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 shadow-lg appearance-none transition-all duration-300 bg-transparent backdrop-blur-xl hover:shadow-xl">
            <option value="" selected disabled class="bg-slate-800 text-white">Select a location</option>
        </select>
        <!-- Location icon -->
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <!-- Dropdown arrow -->
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#location').select2({
            placeholder: "Search for a city or airport...",
            allowClear: true,
            width: '100%',
            minimumInputLength: 3,
            theme: "classic",
            dropdownCssClass: "select2-dropdown-dark",
            ajax: {
                url: "https://portal.crm.limo/api/pruebas",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    if (!data?.data?.locations) {
                        console.error("Invalid API response");
                        return {
                            results: []
                        };
                    }
                    return {
                        results: data.data.locations.map(location => ({
                            id: location.id,
                            text: `${location.name}, ${location.state_code}`,
                            city: location.name,
                            state: location.state_code
                        })),
                        pagination: {
                            more: data.data.info?.total_locations > 30
                        }
                    };
                },
                error: function(xhr) {
                    console.error("Location API error:", xhr.responseText);
                }
            }
        });

        $('#location').on('select2:select', function(e) {
            const location = e.params.data;
            if (location?.city && location?.state) {
                window.handleLocationSelect({
                    id: location.id,
                    text: location.text,
                    city: location.city,
                    state: location.state
                });
            }
        });
    });
</script>

<style>
    .select2-dropdown-dark {
        background-color: rgba(15, 23, 42, 0.95) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 16px !important;
        backdrop-filter: blur(16px) !important;
    }
    
    .select2-dropdown-dark .select2-results__option {
        background-color: transparent !important;
        color: white !important;
        padding: 12px 16px !important;
    }
    
    .select2-dropdown-dark .select2-results__option--highlighted {
        background-color: rgba(59, 130, 246, 0.3) !important;
        color: white !important;
    }
    
    .select2-dropdown-dark .select2-search__field {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 12px !important;
        color: white !important;
        padding: 8px 12px !important;
    }
</style>
