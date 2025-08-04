<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Edit Client'])
    </x-slot>
    
    <div class="min-h-screen main-bg py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="client-form" action="{{ route('client.update', $client) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="active_tab" id="active_tab" value="{{ request()->get('tab', 'basic') }}">
                
                <!-- Sticky action bar -->
                <x-client.action-bar :client="$client" />
                
                <!-- Client Information Tabs -->
                <div class="glass-dark shadow-2xl rounded-2xl mb-6 border border-white/15 backdrop-blur-xl overflow-hidden">
                    <x-client.tabs />
                    
                    <!-- Tab Contents Container -->
                    <div class="p-6">
                        <!-- Tab Contents -->
                        <x-client.tab-basic :client="$client" />
                        <x-client.tab-media :client="$client" />
                        <x-client.tab-seo :client="$client" />
                        <x-client.tab-services :client="$client" />
                        <x-client.tab-fleet :client="$client" />
                        <x-client.tab-airports :client="$client" />
                        <x-client.tab-locationinfo :client="$client" />
                        <x-client.tab-citation :client="$client" />
                        <x-client.tab-subscription :client="$client" />
                        <x-client.tab-social :client="$client" />
                    </div>
                </div>
            </form>

            <!-- Success Message Handler -->
            @if(session('message'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification("{{ session('message') }}", 'success');
                    });
                </script>
            @endif
        </div>
    </div>

    @push('js')
        <script>
            const client = @json($client);
            const routeGenerateContentLong = "{{ route('generate.content.long') }}";
            const routeGenerateContentShort = "{{ route('generate.content.short') }}";
            const routeGenerateContentSpun = "{{ route('generate.content.spun') }}";
            const routeGenerateContentKeywords = "{{ route('generate.content.keywords') }}";
        </script>
        @include('js.citation.save')
        @include('js.citation.generate_content')
    @endpush

    <!-- Enhanced Styles -->
    <style>
        /* Dark theme scrollbar for tab navigation */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Active tab styles */
        .tab-btn.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
            color: rgb(96, 165, 250);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        /* Enhanced form animations */
        .form-group {
            transition: all 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-1px);
        }

        /* Service item animations */
        .service-item {
            animation: slideInUp 0.3s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Area item animations */
        .area-item {
            animation: fadeInLeft 0.3s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Removal animations */
        @keyframes slideOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        @keyframes fadeOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(20px);
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced form submission with loading states
            const form = document.getElementById('client-form');
            const saveButton = document.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                // Enhanced loading state
                saveButton.disabled = true;
                saveButton.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2 inline-block" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving Changes...
                `;
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('An error occurred while saving the changes.', 'error');
                })
                .finally(() => {
                    // Restore button
                    saveButton.disabled = false;
                    saveButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-medium">Save Changes</span>
                    `;
                });
            });

            // Enhanced tab functionality
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            function activateTab(tabName) {
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-400', 'border-blue-500/50', 'bg-blue-500/10', 'active');
                    btn.classList.add('text-slate-400', 'border-transparent');
                });

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Activate selected tab
                const activeTabButton = document.querySelector(`[data-tab="${tabName}"]`);
                const activeTabContent = document.getElementById(`${tabName}-tab`);

                if (activeTabButton && activeTabContent) {
                    activeTabButton.classList.remove('text-slate-400', 'border-transparent');
                    activeTabButton.classList.add('text-blue-400', 'border-blue-500/50', 'bg-blue-500/10', 'active');
                    activeTabContent.classList.remove('hidden');
                }
            }

            // Initialize tabs
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'basic';
            activateTab(activeTab);

            // Tab click handlers
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.dataset.tab;
                    activateTab(tabName);
                    document.getElementById('active_tab').value = tabName;
                    
                    // Update URL
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('tab', tabName);
                    window.history.pushState({}, '', newUrl);
                    
                  
                });
            });

            // Enhanced service management
            let serviceCount = 0;
            
            const addServiceBtn = document.getElementById('add-service');
            if (addServiceBtn) {
                addServiceBtn.addEventListener('click', function() {
                    const servicesContainer = document.getElementById('services-container');
                    const serviceItem = document.createElement('div');
                    serviceItem.className = 'service-item glass p-4 rounded-xl border border-white/20 backdrop-blur-xl';
                    serviceItem.innerHTML = `
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-white">Service #${serviceCount + 1}</h4>
                            <button type="button" class="remove-service text-red-400 hover:text-red-300 text-sm transition-colors duration-200" onclick="removeService(this)">
                                <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Remove
                            </button>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Service Name</label>
                            <input type="text" name="services[${serviceCount}][name]"
                                   class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-xl">
                        </div>
                    `;
                    servicesContainer.appendChild(serviceItem);
                    serviceCount++;
                    showNotification('Service added successfully! ✨', 'success');
                });
            }

            // Enhanced area management
            const addAreaBtn = document.getElementById('add-area');
            if (addAreaBtn) {
                addAreaBtn.addEventListener('click', function() {
                    const areasContainer = document.getElementById('areas-container');
                    const areaItem = document.createElement('div');
                    areaItem.className = 'area-item flex items-center space-x-3';
                    areaItem.innerHTML = `
                        <input type="text" name="areas[]" placeholder="Enter service area..."
                               class="flex-1 px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-xl">
                        <button type="button" class="text-red-400 hover:text-red-300 transition-colors duration-200 p-2 rounded-lg hover:bg-red-500/10" onclick="removeArea(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    areasContainer.appendChild(areaItem);
                    showNotification('Service area added! 📍', 'success');
                });
            }
        });

        // Enhanced remove functions
        function removeService(button) {
            if (confirm('Are you sure you want to remove this service?')) {
                const serviceItem = button.closest('.service-item');
                serviceItem.style.animation = 'slideOutUp 0.3s ease-in';
                setTimeout(() => {
                    serviceItem.remove();
                    updateServiceIndices();
                    showNotification('Service removed successfully! 🗑️', 'info');
                }, 300);
            }
        }

        function removeArea(button) {
            const areaItem = button.closest('.area-item');
            areaItem.style.animation = 'fadeOutRight 0.3s ease-in';
            setTimeout(() => {
                areaItem.remove();
                showNotification('Service area removed! 📍', 'info');
            }, 300);
        }

        function updateServiceIndices() {
            const services = document.querySelectorAll('.service-item');
            services.forEach((service, index) => {
                service.querySelector('h4').textContent = `Service #${index + 1}`;
                const inputs = service.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/services\[\d+\]/, `services[${index}]`);
                    input.setAttribute('name', newName);
                });
            });
        }

        // Enhanced notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const colors = {
                success: 'from-emerald-500 to-green-600 border-emerald-400',
                error: 'from-red-500 to-pink-600 border-red-400',
                info: 'from-blue-500 to-indigo-600 border-blue-400'
            };
            
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm backdrop-blur-xl`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ?
                             '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            type === 'error' ?
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                        }
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white/80 hover:text-white transition-colors duration-200 transform hover:scale-110">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.style.transform = 'translateX(0) scale(1.05)';
                setTimeout(() => {
                    notification.style.transform = 'translateX(0) scale(1)';
                }, 200);
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%) scale(0.95)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }, 4000);
        }
    </script>
</x-app-layout>