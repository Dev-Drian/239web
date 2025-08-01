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