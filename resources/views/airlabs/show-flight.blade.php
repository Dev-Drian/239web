<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Information Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-down {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .status-en-route {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-delayed {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">Flight Information</h1>
            <p class="text-center text-gray-600">Real-time flight tracking</p>
        </div>

        <!-- Flight Details -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden animate-slide-down p-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Basic Flight Information -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <!-- Flight Numbers Section -->
                            <div class="flex items-start">
                                <i class="fas fa-plane text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Flight Numbers</p>
                                    <p class="text-lg font-semibold text-gray-900">AAL2825</p>
                                    <div class="text-sm text-gray-500">
                                        <p>IATA: AA2825</p>
                                        <p>ICAO: AAL2825</p>
                                        <p>Flight Number: 2825</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Route Information -->
                            <div class="flex items-start">
                                <i class="fas fa-exchange-alt text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Route Details</p>
                                    <p class="text-lg font-semibold text-gray-900">CLT → DCA</p>
                                    <div class="text-sm text-gray-500">
                                        <p>From: Charlotte (IATA: CLT, ICAO: KCLT)</p>
                                        <p>To: Washington (IATA: DCA, ICAO: KDCA)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Terminal Information -->
                            <div class="flex items-start">
                                <i class="fas fa-building text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Terminal Info</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="font-medium">Departure</p>
                                            <p class="text-sm text-gray-500">Terminal: B</p>
                                            <p class="text-sm text-gray-500">Gate: B7</p>
                                        </div>
                                        <div>
                                            <p class="font-medium">Arrival</p>
                                            <p class="text-sm text-gray-500">Terminal: C</p>
                                            <p class="text-sm text-gray-500">Gate: C15</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Time Information -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-plane-departure text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Departure</p>
                                    <p class="text-lg font-semibold text-gray-900">10:30 AM</p>
                                    <p class="text-sm text-gray-500">Estimated: 10:45 AM</p>
                                    <p class="text-xs text-amber-600">Delayed: 15 min</p>
                                    <p class="text-sm text-gray-500">Local Time (EST)</p>
                                    <p class="text-sm text-gray-500">UTC: 15:30</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-plane-arrival text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Arrival</p>
                                    <p class="text-lg font-semibold text-gray-900">11:45 AM</p>
                                    <p class="text-sm text-gray-500">Estimated: 12:05 PM</p>
                                    <p class="text-xs text-amber-600">Delayed: 20 min</p>
                                    <p class="text-sm text-gray-500">Local Time (EST)</p>
                                    <p class="text-sm text-gray-500">UTC: 16:45</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-clock text-blue-500 w-5 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Flight Time</p>
                                    <p class="text-lg font-semibold text-gray-900">1h 20m</p>
                                    <p class="text-sm text-gray-500">Block Time: 1h 45m</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Flight Details -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Airline Information -->
                        <div class="flex items-start">
                            <i class="fas fa-airline text-blue-500 w-5 mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-600">Airline</p>
                                <p class="text-lg font-semibold text-gray-900">American Airlines</p>
                                <p class="text-sm text-gray-500">IATA: AA</p>
                                <p class="text-sm text-gray-500">ICAO: AAL</p>
                            </div>
                        </div>

                        <!-- Codeshare Information -->
                        <div class="flex items-start">
                            <i class="fas fa-code-branch text-blue-500 w-5 mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-600">Codeshare</p>
                                <p class="text-lg font-semibold text-gray-900">British Airways</p>
                                <p class="text-sm text-gray-500">Flight: BA6170</p>
                            </div>
                        </div>

                        <!-- Flight Status -->
                        <div class="flex items-start">
                            <i class="fas fa-signal text-blue-500 w-5 mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="text-lg font-semibold text-gray-900 status-en-route px-3 py-1 rounded-full">En Route</p>
                                <p class="text-sm text-gray-500">On Schedule</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>