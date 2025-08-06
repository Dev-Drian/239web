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
</head>

<body class="main-bg">
    <div class="font-sans text-white antialiased">
        {{ $slot }}
    </div>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
</body>

</html>
