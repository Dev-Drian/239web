<div id="subscription-tab" class="tab-content hidden">
    <div class="p-6 space-y-6">
        @php
            $services = [
                'marketing' => [
                    [
                        'id' => 'seo',
                        'name' => 'SEO',
                        'description' => 'Search Engine Optimization services',
                        'icon' =>
                            '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>',
                    ],
                    [
                        'id' => 'ppc',
                        'name' => 'PPC',
                        'description' => 'Pay-Per-Click advertising campaigns',
                        'icon' =>
                            '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>',
                    ],
                    [
                        'id' => 'newsletter',
                        'name' => 'Newsletter',
                        'description' => 'Email marketing and newsletter management',
                        'icon' =>
                            '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                    ],
                ],
                'development' => [
                    [
                        'id' => 'website',
                        'name' => 'Website',
                        'description' => 'Website development and maintenance',
                        'icon' =>
                            '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>',
                    ],
                ],
                'infrastructure' => [
                    [
                        'id' => 'hosting',
                        'name' => 'Hosting',
                        'description' => 'Web hosting and server management',
                        'icon' =>
                            '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>',
                    ],
                ],
            ];

            $categoryColors = [
                'marketing' => 'bg-blue-50 text-blue-700 border-blue-200',
                'development' => 'bg-green-50 text-green-700 border-green-200',
                'infrastructure' => 'bg-purple-50 text-purple-700 border-purple-200',
            ];

            $categoryLabels = [
                'marketing' => 'Marketing',
                'development' => 'Development',
                'infrastructure' => 'Infrastructure',
            ];

            $selected = old('subscriptions', $client->subscriptions ?? []);
        @endphp

        @foreach ($services as $category => $categoryServices)
            @php
                $selectedInCategory = collect($categoryServices)
                    ->filter(function ($service) use ($selected) {
                        return in_array($service['id'], $selected);
                    })
                    ->count();
            @endphp

            <div class="space-y-3">
                <!-- Category Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold capitalize">{{ $categoryLabels[$category] }}</h3>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $categoryColors[$category] }}">
                        {{ $selectedInCategory }}/{{ count($categoryServices) }} selected
                    </span>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($categoryServices as $service)
                        <div class="service-card relative p-4 rounded-lg border-2 transition-all duration-200 cursor-pointer hover:shadow-md hover:border-blue-300 {{ in_array($service['id'], $selected) ? 'border-blue-500 bg-blue-50 shadow-sm' : 'border-gray-200' }}"
                            onclick="toggleService('{{ $service['id'] }}')">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" name="subscriptions[]" value="{{ $service['id'] }}"
                                    id="{{ $service['id'] }}"
                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ in_array($service['id'], $selected) ? 'checked' : '' }}
                                    onchange="updateCounter()">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        {!! $service['icon'] !!}
                                        <label for="{{ $service['id'] }}" class="text-sm font-medium cursor-pointer">
                                            {{ $service['name'] }}
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 leading-relaxed">{{ $service['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function toggleService(serviceId) {
        const checkbox = document.getElementById(serviceId);
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    }
    function updateCounter() {
        document.querySelectorAll('[data-category]').forEach(function(categoryHeader) {
            const category = categoryHeader.getAttribute('data-category');
            const checkboxes = document.querySelectorAll('.service-card input[type="checkbox"][data-category="' + category + '"]');
            let checked = 0;
            checkboxes.forEach(cb => { if (cb.checked) checked++; });
            const counter = categoryHeader.querySelector('.category-counter');
            if (counter) {
                counter.textContent = checked + '/' + checkboxes.length + ' selected';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateCounter();
        document.querySelectorAll('.service-card input[type="checkbox"]').forEach(function(cb) {
            cb.addEventListener('change', updateCounter);
        });
    });
</script>
