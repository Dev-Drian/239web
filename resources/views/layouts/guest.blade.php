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

    <!-- Include Tailwind CSS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="text/tailwindcss">
        @theme {
            --color-clifford: #da373d;
        }

        @layer base {
            body {
                @apply bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 min-h-screen;
            }
        }

        @layer components {
            .glass {
                @apply bg-white/10 backdrop-blur-md border border-white/20;
            }

            .glass-dark {
                @apply bg-slate-900/80 backdrop-blur-xl border border-white/10;
            }

            .btn-primary {
                @apply inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold text-xs uppercase tracking-wider rounded-lg border-none shadow-lg transition-all duration-300 hover:from-indigo-600 hover:to-purple-600 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/50;
            }

            .form-input-dark {
                @apply w-full rounded-lg border border-white/20 bg-white/10 backdrop-blur-md text-white placeholder-slate-400 px-3 py-2 shadow-sm outline-none transition-all duration-200 focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 focus:bg-white/15;
            }

            .select2-dark .select2-selection--single {
                @apply bg-white/10 border border-white/20 rounded-lg text-white;
            }

            .select2-dark .select2-selection--single .select2-selection__rendered {
                @apply text-white;
            }

            .select2-dark .select2-selection--single .select2-selection__placeholder {
                @apply text-slate-400;
            }

            .select2-dark .select2-dropdown {
                @apply bg-slate-900/95 border border-white/20 backdrop-blur-md;
            }

            .select2-dark .select2-results__option {
                @apply text-white;
            }

            .select2-dark .select2-results__option--highlighted[aria-selected] {
                @apply bg-indigo-500/50;
            }

            .scrollbar-dark {
                @apply scrollbar-thin scrollbar-track-slate-900/30 scrollbar-thumb-indigo-500/50 scrollbar-thumb-rounded-full hover:scrollbar-thumb-indigo-500/70;
            }
        }

        @layer utilities {
            .main-bg {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            }
        }
    </script>

    <!-- Styles -->
    @livewireStyles
    
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
        
        /* Fix for regular select elements */
        select {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #e2e8f0 !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
        }
        
        select option {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
        }
        
        select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 1px #6366f1 !important;
        }
        
        /* Ensure buttons work properly */
        button {
            cursor: pointer !important;
        }
        
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
        }
    </style>
</head>

<body class="main-bg font-sans antialiased min-h-screen text-slate-100">
    <div class="font-sans text-white antialiased">
        {{ $slot }}
    </div>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.iife.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

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
            $('input, textarea, select').not('.select2-selection').addClass('bg-white/5 border-white/15 text-slate-100 placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 smooth');
            
            // Fix select options color
            $('select option').css({
                'background-color': '#1e293b',
                'color': '#e2e8f0'
            });
            
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
            
            // Fix button functionality by ensuring proper event handling
            $('button[type="submit"], button[type="button"]').off('click').on('click', function(e) {
                // Allow default behavior for form submissions
                if ($(this).attr('type') === 'submit') {
                    return true;
                }
                // For other buttons, prevent default only if needed
                if ($(this).hasClass('prevent-default')) {
                    e.preventDefault();
                }
            });
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
