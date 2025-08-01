<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identity Verification Dashboard</title>
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
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .image-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .image-container {
            position: relative;
            padding-top: 75%; /* 4:3 Aspect Ratio */
            overflow: hidden;
        }
        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-label {
            padding: 0.5rem;
            text-align: center;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            text-transform: capitalize;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Identity Verification Dashboard</h1>
            <p class="text-gray-600">Monitor and manage identity verification requests</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                        <i class="fas fa-id-card text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Verifications</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $verifications->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow">
            @if ($verifications->isEmpty())
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="rounded-full bg-gray-100 p-6 mb-4">
                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No verifications available</h3>
                    <p class="text-gray-500">No identity verifications have been submitted yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Images</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($verifications as $verification)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $verification->doc_first_name }} {{ $verification->doc_last_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $verification->doc_type }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $verification->doc_number }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($verification->status === 'APPROVED') bg-green-100 text-green-800
                                            @elseif($verification->status === 'REJECTED') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $verification->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick='showImages(@json($verification->file_urls))' 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            <i class="fas fa-images mr-2"></i> View Images
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick='showMore(@json($verification->more))' 
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

    <!-- Details Modal -->
    <div id="moreModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-hidden">
        <div class="flex items-center justify-center min-h-screen p-2">
            <div class="bg-white w-full max-w-3xl rounded-lg shadow-xl transform transition-all modal-content">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-3 border-b bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        Detailed Verification Information
                    </h3>
                    <button onclick="closeModal('moreModal')" class="text-gray-400 hover:text-gray-500">
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

    <!-- Images Modal -->
    <div id="imagesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-hidden">
        <div class="flex items-center justify-center min-h-screen p-2">
            <div class="bg-white w-full max-w-4xl rounded-lg shadow-xl transform transition-all modal-content">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-3 border-b bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        Document Images
                    </h3>
                    <button onclick="closeModal('imagesModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Modal Content -->
                <div class="p-6">
                    <div id="imageGallery" class="image-gallery">
                    </div>
                </div>
            </div>
        </div>
    </div>

 
<script>
    function showMore(moreData) {
        const contentList = document.querySelector('#moreContent ul');
        contentList.innerHTML = '';

        if (typeof moreData === 'string') {
            moreData = JSON.parse(moreData);
        }

        for (const key in moreData) {
            if (moreData.hasOwnProperty(key) && moreData[key]) {
                const value = moreData[key];
                const listItem = document.createElement('li');
                listItem.classList.add('border', 'rounded-lg', 'p-3', 'bg-gray-50', 'hover:bg-gray-100', 'transition-colors', 'mb-2');

                const keyElement = document.createElement('dt');
                keyElement.classList.add('text-xs', 'font-medium', 'text-gray-500', 'uppercase', 'tracking-wide');
                keyElement.textContent = key;

                const valueElement = document.createElement('dd');
                valueElement.classList.add('text-sm', 'text-gray-900', 'mt-1', 'break-words');
                valueElement.textContent = typeof value === 'object' ? JSON.stringify(value) : value;

                listItem.appendChild(keyElement);
                listItem.appendChild(valueElement);
                contentList.appendChild(listItem);
            }
        }

        document.getElementById('moreModal').classList.remove('hidden');
    }

    function showImages(fileUrls) {
        const gallery = document.getElementById('imageGallery');
        gallery.innerHTML = '';

        if (typeof fileUrls === 'string') {
            fileUrls = JSON.parse(fileUrls);
        }

        // Labels mapping for better display names
        const labelMapping = {
            frontside: 'Front Side',
            backside: 'Back Side',
            face: 'Face Photo'
        };

        for (const [key, url] of Object.entries(fileUrls)) {
            const card = document.createElement('div');
            card.className = 'image-card';
            
            const container = document.createElement('div');
            container.className = 'image-container';
            
            const img = document.createElement('img');
            img.src = url;
            img.alt = labelMapping[key] || key;
            img.className = 'hover:opacity-90 transition-opacity cursor-pointer';
            
            // Add click handler to open full size image
            img.onclick = function() {
                window.open(url, '_blank');
            };
            
            const label = document.createElement('div');
            label.className = 'image-label';
            label.textContent = labelMapping[key] || key;
            
            container.appendChild(img);
            card.appendChild(container);
            card.appendChild(label);
            gallery.appendChild(card);
        }

        document.getElementById('imagesModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close modals when clicking outside
    ['moreModal', 'imagesModal'].forEach(modalId => {
        document.getElementById(modalId).addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(modalId);
            }
        });
    });

    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            ['moreModal', 'imagesModal'].forEach(modalId => {
                if (!document.getElementById(modalId).classList.contains('hidden')) {
                    closeModal(modalId);
                }
            });
        }
    });
</script>
</body>

</html>