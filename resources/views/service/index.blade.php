<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Services'])
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900                                                                <div class="service-toggle w-6 h-6 border-2 border-gray-600/50 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg {{ $client->status == 'inactive' ? 'bg-red-600 border-red-600 shadow-red-500/30' : 'hover:border-red-400' }}">                                    <div class="service-toggle w-6 h-6 border-2 border-gray-600/50 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg {{ in_array($service, $subscriptions) ? 'bg-' . $serviceColors[$service] . '-600 border-' . $serviceColors[$service] . '-600 shadow-' . $serviceColors[$service] . '-500/30' : 'hover:border-' . $serviceColors[$service] . '-400' }}">ia-slate-900 to-black py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filter Bar -->
            <div class="mb-6 bg-gray-800/40 backdrop-blur-lg rounded-xl shadow-2xl border border-gray-700/50 p-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" id="clientSearch" placeholder="Search clients..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-700/50 border border-gray-600/50 text-white placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-200">
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Botón Show Hidden actualizado --}}
                        <button id="showHiddenBtn" type="button" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-300 bg-gray-700/60 hover:bg-gray-600/60 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m3.878-3.122L21 21m-6.122-6.122L12 12"></path>
                            </svg>
                            {{ $showHidden ? 'Show Active' : 'Show Hidden' }}
                        </button>
                        <div class="bg-blue-500/20 text-blue-300 px-3 py-2.5 rounded-lg font-medium text-sm border border-blue-400/30">
                            <span id="clientCount">{{ count($clients) }}</span> clients
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <form action="{{ route('service.save') }}" method="POST" class="bg-gray-800/40 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-700/50 overflow-hidden">
                @csrf
                <!-- Enhanced Header -->
                <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-white">Client Services Management</h2>
                                <p class="text-blue-100 text-sm mt-0.5">Manage and track all client subscriptions</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-white font-medium">Active Services</div>
                                <div class="text-blue-100 text-sm" id="activeServicesCount">Loading...</div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all duration-200 border border-white/20 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
    <div class="overflow-x-auto">
                    <table class="w-full" id="clientsTable">
                        <thead class="bg-gradient-to-r from-gray-800/60 to-gray-700/60 border-b border-gray-600/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Client
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        SEO
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                        </svg>
                                        PPC
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                        </svg>
                                        Website
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                        </svg>
                                        Hosting
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Newsletter
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        CRM
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex flex-col items-center gap-1">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m3.878-3.122L21 21m-6.122-6.122L12 12"></path>
                                        </svg>
                                        Hide
                                    </div>
                                </th>
                </tr>
            </thead>
                        <tbody class="bg-gray-800/30 backdrop-blur-sm divide-y divide-gray-600/30">
                            @forelse($clients as $client)
                                <tr class="hover:bg-gray-700/40 transition-all duration-300 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-600/20 flex items-center justify-center border border-gray-600/30">
                                                    <span class="text-sm font-bold text-gray-200">
                                                        {{ strtoupper(substr($client->company_name ?? $client->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-200">
                                                    {{ $client->company_name ?? $client->name }}
                                                </div>
                                                <div class="text-xs text-gray-400 flex items-center gap-2">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                    </svg>
                                                    {{ $client->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Service Checkboxes with enhanced styling -->
                                    @foreach($services as $service)
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex justify-center">
                                                <label class="relative inline-flex items-center cursor-pointer group/checkbox">
                                                    <input
                                                        type="checkbox"
                                                        class="sr-only service-checkbox"
                                                        data-client="{{ $client->id ?? $index }}"
                                                        data-service="{{ $service }}"
                                                        name="subscriptions[{{ $client->id ?? $index }}][]"
                                                        value="{{ $service }}"
                                                        {{ in_array($service, $subscriptions) ? 'checked' : '' }}
                                                    >
                                                    <div class="service-toggle w-6 h-6 border-2 border-gray-300 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg {{ in_array($service, $subscriptions) ? 'bg-' . $serviceColors[$service] . '-500 border-' . $serviceColors[$service] . '-500 shadow-' . $serviceColors[$service] . '-200' : 'hover:border-' . $serviceColors[$service] . '-300' }}">
                                                        <svg class="w-4 h-4 text-white transition-all duration-200 {{ in_array($service, $subscriptions) ? 'scale-100' : 'scale-0' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </label>
                                            </div>
                                    </td>
                                    @endforeach

                                    <!-- Enhanced Hide Toggle -->
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer group/checkbox">
                                                <input type="checkbox" class="sr-only hide-row" data-client-id="{{ $client->id }}" {{ $client->status == 'inactive' ? 'checked' : '' }}>
                                                <div class="service-toggle w-6 h-6 border-2 border-gray-300 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg {{ $client->status == 'inactive' ? 'bg-red-500 border-red-500 shadow-red-200' : 'hover:border-red-300' }}">
                                                    <svg class="w-4 h-4 text-white transition-all duration-200 {{ $client->status == 'inactive' ? 'scale-100' : 'scale-0' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
            </tbody>
        </table>
    </div>

                @if($clients && $clients->hasPages())
                    <div class="px-4 py-3 border-t border-gray-600/30 bg-gradient-to-r from-gray-800/60 to-gray-700/60 backdrop-blur-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                            <div class="text-xs text-gray-300">
                                Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
                            </div>
                            <div class="transform transition-all duration-300 hover:scale-105">
                                {{ $clients->links() }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Enhanced Footer -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-t border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-6 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full shadow-sm"></div>
                                <span class="text-gray-600 font-medium">Active Service</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                <span class="text-gray-600 font-medium">Inactive Service</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                <span class="text-gray-600 font-medium">Hidden Client</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Last updated: {{ now()->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('clientSearch');
            const clientRows = document.querySelectorAll('.client-row');
            const clientCountElement = document.getElementById('clientCount');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                clientRows.forEach(function(row) {
                    const clientName = row.getAttribute('data-client-name');
                    if (clientName.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                clientCountElement.textContent = visibleCount;
            });

            // Show/Hide hidden clients functionality
            let showingHidden = false;
            const showHiddenBtn = document.getElementById('showHiddenBtn');

            showHiddenBtn.addEventListener('click', function() {
                const url = new URL(window.location.href);
                if ({{ $showHidden ? 'true' : 'false' }}) {
                    url.searchParams.delete('show_hidden');
                } else {
                    url.searchParams.set('show_hidden', '1');
                }
                window.location.href = url.toString();
            });

            // Hide row functionality with enhanced animations
            document.querySelectorAll('.hide-row').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const clientId = this.getAttribute('data-client-id');
                    const row = this.closest('tr');
                    fetch(`/limo-partner/service/${clientId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Si el estado ya no corresponde al filtro, ocultar la fila
                            const showHidden = {{ $showHidden ? 'true' : 'false' }};
                            if ((showHidden && data.status === 'active') || (!showHidden && data.status === 'inactive')) {
                                row.style.display = 'none';
                            } else {
                                // Actualiza el check visual
                                const toggle = this.nextElementSibling;
                                const svg = toggle.querySelector('svg');
                                if (data.status === 'inactive') {
                                    toggle.className = 'service-toggle w-6 h-6 border-2 border-red-600 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg bg-red-600 shadow-red-500/30';
                                    svg.classList.remove('scale-0');
                                    svg.classList.add('scale-100');
                                } else {
                                    toggle.className = 'service-toggle w-6 h-6 border-2 border-gray-600/50 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg hover:border-red-400';
                                    svg.classList.remove('scale-100');
                                    svg.classList.add('scale-0');
                                }
                            }
                        }
                    });
                });
            });

            // Enhanced service checkbox functionality
            document.querySelectorAll('.service-checkbox').forEach(function(checkbox) {
                const serviceToggle = checkbox.nextElementSibling;
                const svg = serviceToggle.querySelector('svg');

                checkbox.addEventListener('change', function() {
                    const service = this.getAttribute('data-service');
                    const serviceColors = {
                        'seo': 'green',
                        'ppc': 'blue',
                        'website': 'purple',
                        'hosting': 'orange',
                        'newsletter': 'pink',
                        'crm': 'indigo'
                    };

                    const color = serviceColors[service];

                    if (this.checked) {
                        serviceToggle.className = `service-toggle w-6 h-6 border-2 border-${color}-600 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg bg-${color}-600 shadow-${color}-500/30`;
                        svg.classList.remove('scale-0');
                        svg.classList.add('scale-100');
                    } else {
                        serviceToggle.className = `service-toggle w-6 h-6 border-2 border-gray-600/50 rounded-lg flex items-center justify-center transition-all duration-300 group-hover/checkbox:scale-110 group-hover/checkbox:shadow-lg hover:border-${color}-400`;
                        svg.classList.remove('scale-100');
                        svg.classList.add('scale-0');
                    }

                    // Log the change (you can replace this with an API call)
                    const clientId = this.getAttribute('data-client');
                    const isChecked = this.checked;

                    console.log(`Client ${clientId}: ${service} ${isChecked ? 'activated' : 'deactivated'}`);

                    // Example AJAX call (uncomment and adapt according to your backend)
                    /*
                    fetch('/update-service', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            client_id: clientId,
                            service: service,
                            active: isChecked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Service updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert checkbox on error
                        this.checked = !isChecked;
                        // Update visual state accordingly
                    });
                    */

                    updateActiveServicesCount();
                });
            });

            // Enhanced row hover effects
            document.querySelectorAll('.client-row').forEach(function(row) {
                row.addEventListener('mouseenter', function() {
                    if (this.style.opacity !== '0.3') {
                        this.style.transform = 'translateY(-2px)';
                        this.style.boxShadow = '0 8px 25px -8px rgba(0, 0, 0, 0.15)';
                        this.style.zIndex = '10';
                    }
                });

                row.addEventListener('mouseleave', function() {
                    if (this.style.opacity !== '0.3') {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                        this.style.zIndex = 'auto';
                    }
                });
            });

            // Calculate and display active services count
            function updateActiveServicesCount() {
                const activeCheckboxes = document.querySelectorAll('.service-checkbox:checked');
                const activeServicesCount = document.getElementById('activeServicesCount');
                const totalServices = document.querySelectorAll('.service-checkbox').length;

                if (activeServicesCount) {
                    activeServicesCount.textContent = `${activeCheckboxes.length} of ${totalServices}`;
                }
            }

            // Initial count update
            updateActiveServicesCount();
        });
    </script>

    <style>
        .client-row {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-checkbox:checked + .service-toggle {
            transform: scale(1.05);
        }

        .service-checkbox:focus + .service-toggle {
            ring: 2px;
            ring-opacity: 50;
        }

        .service-toggle:hover {
            transform: translateY(-1px);
        }

        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animation for loading states */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Gradient text effect */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced shadows */
        .shadow-service {
            box-shadow: 0 4px 14px 0 rgba(0, 118, 255, 0.39);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .client-row td {
                padding: 12px 8px;
            }

            .service-toggle {
                width: 20px;
                height: 20px;
            }

            .service-toggle svg {
                width: 12px;
                height: 12px;
            }
        }

        /* Focus states for accessibility */
        .service-checkbox:focus + .service-toggle,
        .hide-row:focus + div {
            outline: 2px solid #60a5fa;
            outline-offset: 2px;
        }

        /* Smooth state transitions */
        .service-toggle,
        .service-toggle svg {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Table row striping with better contrast */
        .client-row:nth-child(even) {
            background: linear-gradient(90deg, rgba(55, 65, 81, 0.3) 0%, rgba(75, 85, 99, 0.2) 100%);
        }

        /* Enhanced hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        /* Loading skeleton styles for dark theme */
        .skeleton {
            background: linear-gradient(90deg, rgba(55, 65, 81, 0.4) 25%, rgba(75, 85, 99, 0.6) 50%, rgba(55, 65, 81, 0.4) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
    </style>
</x-app-layout>
