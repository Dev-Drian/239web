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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    <!-- Include Tailwind CSS via CDN -->
    
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

<body class="main-bg bg-pattern">
    <div class="font-sans text-slate-100 antialiased min-h-screen">
        <!-- Background decoration -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-cyan-500/20 to-blue-500/20 rounded-full blur-3xl"></div>
        </div>
        
        <!-- Main content -->
        <div class="relative z-10 animate-fade-in">
            {{ $slot }}
        </div>
    </div>
    
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
    @stack('js')
    @livewireScripts
    <script>
      
        
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