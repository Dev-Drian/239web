<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <style>
        /* Custom scrollbar - simple */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Simple background */
        .main-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        /* Clean glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-dark {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Simple transitions */
        .smooth {
            transition: all 0.2s ease;
        }
        
        /* Hover effects - minimal */
        .hover-lift:hover {
            transform: translateY(-1px);
        }
        

        
        /* Select2 styling - clean */
        .select2-container--default .select2-selection--single {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 8px !important;
            height: 42px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #e2e8f0 !important;
            line-height: 40px !important;
            padding-left: 12px !important;
        }
        
        .select2-dropdown {
            background: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 8px !important;
        }
        
        .select2-results__option {
            color: #e2e8f0 !important;
            padding: 10px 12px !important;
        }
        
        .select2-results__option--highlighted {
            background: #3b82f6 !important;
        }
        
        /* Button gradients - simple */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
        }
        
        /* Card styling */
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="font-sans antialiased main-bg min-h-screen text-slate-100">

    <x-banner />
    
    <div class="min-h-screen flex">
        @livewire('navigation-menu')
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Main content area -->
        <div class="flex-1 flex flex-col ml-0 md:ml-64">
            <!-- Header adaptado al sidebar -->
            @if (isset($header))
                <header class="glass-dark shadow-lg border-b border-white/10 sticky top-0 z-40">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-4">
                            <!-- Header content -->
                            <div class="flex-1 text-white">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endif
            
            <!-- Clean Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        
        <!-- Simple Footer -->
        <footer class="glass-dark border-t border-white/10 mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded flex items-center justify-center">
                            <span class="text-white font-bold text-xs">239</span>
                        </div>
                        <span class="text-slate-300 text-sm">239 WEB - Professional Solutions</span>
                    </div>
                    
                    <div class="text-slate-400 text-sm">
                        &copy; {{ date('Y') }} All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    @stack('modals')
    @stack('js')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.iife.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '5881b6482357e841e8dc',
            cluster: 'us2',
            forceTLS: true
        });
        
        // Simple SweetAlert2 theme
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            background: '#1e293b',
            color: '#e2e8f0',
            iconColor: '#3b82f6'
        });
        
        $(document).ready(function() {
            
            // Simple Select2 init
            $('.select2').select2({
                width: '100%',
                placeholder: 'Select an option...'
            });
            
            // Clean styling for elements
            $('input, textarea, select').not('.select2-selection').addClass('bg-white/5 border-white/15 text-slate-100 placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 smooth');
            
            // Button styling
            $('.btn-primary, .bg-blue-500, .bg-blue-600').removeClass('bg-blue-500 bg-blue-600').addClass('btn-primary smooth');
            $('.btn-secondary').addClass('bg-white/10 border-white/20 text-white hover:bg-white/15 smooth');
            
            // Card styling
            $('.bg-white').removeClass('bg-white').addClass('card smooth hover-lift');
            
            // Table styling
            $('table').addClass('bg-white/5 rounded-lg overflow-hidden');
            $('table thead').addClass('bg-white/10');
            $('table th').addClass('text-slate-200 font-medium');
            $('table td').addClass('text-slate-300 border-white/10');
            
            // Add smooth class to interactive elements
            $('button, a').addClass('smooth');
        });
        
        // Simple notification function
        window.notify = function(type, message) {
            Toast.fire({
                icon: type,
                title: message
            });
        };
        

    </script>
    
    @livewireScripts
</body>
</html>