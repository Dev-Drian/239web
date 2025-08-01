<div class="mb-6">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />

    <!-- Location Selector -->
    <select id="location" name="user_location"
        class="block w-full pl-10 pr-10 py-3 text-base text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm appearance-none transition-all hover:border-gray-400">
        <option value="" selected disabled>Select a location</option>
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#location').select2({
            placeholder: "Search for a city or airport...",
            allowClear: true,
            width: '100%',
            minimumInputLength: 3,
            theme: "classic",
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
