<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .container {
            height: 100vh;
            overflow-y: auto;
        }
        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Leads Dashboard</h1>
            <p class="text-gray-600">Client leads management and tracking</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Leads</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $leads->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow">
            @if ($leads->isEmpty())
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="rounded-full bg-gray-100 p-6 mb-4">
                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No leads available</h3>
                    <p class="text-gray-500">No leads have been registered in the system yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($leads as $lead)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $lead->first_name }} {{ $lead->last_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lead->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lead->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lead->address }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick='showMore(@json($lead->more))' 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View more
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Optimizado y Más Ancho -->
    <div id="moreModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-hidden">
        <div class="flex items-center justify-center min-h-screen p-2">
            <div class="bg-white w-full max-w-3xl rounded-lg shadow-xl transform transition-all modal-content">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-3 border-b bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        Detailed Lead Information
                    </h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Modal Content -->
                <div class="p-6" id="moreContent">
                    <ul class="text-sm"> 
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMore(moreData) {
            const contentList = document.querySelector('#moreContent ul');
            contentList.innerHTML = ''; // Clear previous content

            if (typeof moreData === 'string') {
                moreData = JSON.parse(moreData);
            }

            for (const key in moreData) {
                if (moreData.hasOwnProperty(key) && moreData[key]) { // Check for truthy value
                    const value = moreData[key];
                    const listItem = document.createElement('li');
                    listItem.classList.add('border', 'rounded-lg', 'p-3', 'bg-gray-50', 'hover:bg-gray-100', 'transition-colors', 'mb-2'); // Add Tailwind CSS classes for styling

                    const keyElement = document.createElement('dt');
                    keyElement.classList.add('text-xs', 'font-medium', 'text-gray-500', 'uppercase', 'tracking-wide');
                    keyElement.textContent = key;

                    const valueElement = document.createElement('dd');
                    valueElement.classList.add('text-sm', 'text-gray-900', 'mt-1', 'break-words');
                    valueElement.textContent = value;

                    listItem.appendChild(keyElement);
                    listItem.appendChild(valueElement);
                    contentList.appendChild(listItem);
                }
            }

            document.getElementById('moreModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('moreModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('moreModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('moreModal').classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>
</body>

</html>

