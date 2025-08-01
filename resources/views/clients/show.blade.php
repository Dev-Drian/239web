<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Edit Client'])
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="client-form" action="{{ route('client.update', $client) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="active_tab" id="active_tab" value="{{ request()->get('tab', 'basic') }}">

                <!-- Sticky action bar -->
                <x-client.action-bar :client="$client" />

                <!-- Client Information Tabs -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <x-client.tabs />
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
                    {{-- <x-client.tab-google :client="$client" /> --}}
                </div>
            </form>

            @if(session('message'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated Successfully',
                            text: "{{ session('message') }}",
                            confirmButtonColor: '#3085d6'
                        });
                    });
                </script>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('client-form');
                    const saveButton = document.querySelector('button[type="submit"]');

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(form);
                        
                        // Mostrar indicador de carga
                        saveButton.disabled = true;
                        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while saving the changes.',
                                confirmButtonColor: '#3085d6'
                            });
                        })
                        .finally(() => {
                            // Restaurar el botón
                            saveButton.disabled = false;
                            saveButton.innerHTML = '<i class="fas fa-save mr-2"></i> Save Changes';
                        });
                    });
                });
            </script>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            function activateTab(tabName) {
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                const activeTabButton = document.querySelector(`[data-tab="${tabName}"]`);
                const activeTabContent = document.getElementById(`${tabName}-tab`);

                if (activeTabButton && activeTabContent) {
                    activeTabButton.classList.add('text-blue-600', 'border-blue-600');
                    activeTabContent.classList.remove('hidden');
                }
            }

            // Leer la URL para saber qué pestaña activar
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'basic'; // Por defecto, 'basic'
            activateTab(activeTab);

            // Asignar eventos de clic a los botones
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.dataset.tab;
                    activateTab(tabName);
                    document.getElementById('active_tab').value = tabName;

                    // Actualizar la URL sin recargar la página
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('tab', tabName);
                    window.history.pushState({}, '', newUrl);
                });
            });
        });
    </script>
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-blue-600', 'border-blue-600');
                        btn.classList.add('text-gray-500', 'border-transparent');
                    });

                    // Add active class to clicked button
                    button.classList.remove('text-gray-500', 'border-transparent');
                    button.classList.add('text-blue-600', 'border-blue-600');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show the selected tab content
                    document.getElementById(`${button.dataset.tab}-tab`).classList.remove('hidden');
                });
            });
        });

        // Add new service
        document.getElementById('add-service').addEventListener('click', function() {
            const servicesContainer = document.getElementById('services-container');
            const serviceCount = servicesContainer.querySelectorAll('.service-item').length;

            const serviceItem = document.createElement('div');
            serviceItem.className = 'service-item bg-gray-50 p-3 rounded-lg border border-gray-200';
            serviceItem.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-medium text-gray-700">Service #${serviceCount + 1}</h4>
                    <button type="button" class="remove-service text-red-600 hover:text-red-800 text-sm" onclick="removeService(this)">
                        <i class="fas fa-trash mr-1"></i> Remove
                    </button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Service Name</label>
                    <input type="text" name="services[${serviceCount}][name]" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            `;

            servicesContainer.appendChild(serviceItem);
        });

        // Remove service
        function removeService(button) {
            if (confirm('Are you sure you want to remove this service?')) {
                button.closest('.service-item').remove();
                updateServiceIndices();
            }
        }

        // Update service indices after removal
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

        // Add service area
        document.getElementById('add-area').addEventListener('click', function() {
            const areasContainer = document.getElementById('areas-container');

            const areaItem = document.createElement('div');
            areaItem.className = 'area-item flex items-center';
            areaItem.innerHTML = `
                <input type="text" name="areas[]" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeArea(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;

            areasContainer.appendChild(areaItem);
        });

        // Remove service area
        function removeArea(button) {
            button.closest('.area-item').remove();
        }
    </script>
</x-app-layout>
