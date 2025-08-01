<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Google Ads'])
    </x-slot>

    <div class="py-12 bg-blue-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg transition-all duration-300 hover:shadow-2xl">
                <!-- Stats Overview -->
                <div class="flex flex-wrap border-b border-blue-100">
                    <div class="w-full md:w-1/4 p-6 border-r border-blue-100 transition-all duration-300 hover:bg-blue-50">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-bullhorn text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Active Campaigns</p>
                                <p class="text-2xl font-bold text-blue-700">2</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 p-6 border-r border-blue-100 transition-all duration-300 hover:bg-blue-50">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Accounts</p>
                                <p class="text-2xl font-bold text-blue-700">
                                    {{ $clients->flatMap->googleAdsAccounts->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 p-6 border-r border-blue-100 transition-all duration-300 hover:bg-blue-50">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Clients</p>
                                <p class="text-2xl font-bold text-blue-700">{{ $clients->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Campaigns Table -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-blue-700 text-left text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg">Account Name</th>
                                <th class="px-6 py-3 bg-blue-700 text-left text-xs font-medium text-white uppercase tracking-wider">Customer ID</th>
                                <th class="px-6 py-3 bg-blue-700 text-left text-xs font-medium text-white uppercase tracking-wider rounded-tr-lg">Client Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($clients as $client)
                                @foreach($client->googleAdsAccounts as $account)
                                    <tr class="hover:bg-blue-50 transition-colors duration-300 cursor-pointer" onclick="toggleCampaigns('row-{{ $account->id }}')">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $account->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $account->customer_id }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $client->name }}</td>
                                    </tr>
                                    <tr id="row-{{ $account->id }}" class="hidden campaign-details bg-blue-50">
                                        <td colspan="3" class="px-6 py-4">
                                            <div class="ml-8 animate-fadeIn">
                                                <div class="flex justify-between items-center mb-3">
                                                    <h4 class="font-semibold text-blue-800">Campaigns</h4>
                                                </div>
                                                <div class="bg-white rounded-lg shadow-sm">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead>
                                                            <tr class="bg-blue-100">
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-800">Campaign Name</th>
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-800">Template Type</th>
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-800">Target City</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($client->campaigns as $campaign)
                                                                <tr class="hover:bg-blue-50 transition-all duration-300">
                                                                    <td class="px-4 py-2">{{ $campaign->campaign_name }}</td>
                                                                    <td class="px-4 py-2">{{ $campaign->template_type }}</td>
                                                                    <td class="px-4 py-2">{{ $campaign->target_city }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                                                        <div class="flex flex-col items-center justify-center">
                                                                            <i class="fas fa-exclamation-circle text-blue-300 text-4xl mb-3"></i>
                                                                            <p>No campaigns available for this account</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-search text-blue-300 text-5xl mb-4"></i>
                                            <p class="text-xl mb-2">No Google Ads accounts available</p>
                                            <p class="text-gray-400 mb-6">Connect your first Google Ads account to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        /* Smooth transition for hover effects */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Custom scrollbar for a nicer look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>

    <script>
        function toggleCampaigns(rowId) {
            const detailsRow = document.getElementById(rowId);
            if (detailsRow) {
                // Toggle visibility with animation
                if (detailsRow.classList.contains('hidden')) {
                    detailsRow.classList.remove('hidden');
                    // Trigger animation restart
                    const content = detailsRow.querySelector('.animate-fadeIn');
                    if (content) {
                        content.style.animation = 'none';
                        content.offsetHeight; // Trigger reflow
                        content.style.animation = 'fadeIn 0.3s ease-out forwards';
                    }
                } else {
                    // Add fade out animation before hiding
                    const content = detailsRow.querySelector('.animate-fadeIn');
                    if (content) {
                        content.style.animation = 'none';
                        content.offsetHeight; // Trigger reflow
                        content.style.animation = 'fadeIn 0.3s ease-out reverse';
                        
                        setTimeout(() => {
                            detailsRow.classList.add('hidden');
                        }, 300);
                    } else {
                        detailsRow.classList.add('hidden');
                    }
                }
            }
        }

        // Add ripple effect to buttons
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const x = e.clientX - e.target.getBoundingClientRect().left;
                    const y = e.clientY - e.target.getBoundingClientRect().top;

                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.width = '1px';
                    ripple.style.height = '1px';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.pointerEvents = 'none';

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Enhanced hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr:not(.campaign-details)');
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</x-app-layout>