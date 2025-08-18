<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Client List'])
    </x-slot>

    @push('styles')
    <style>
        /* Dark theme background */
        .main-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .main-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Glass effect */
        .glass-dark {
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Client item hover effects */
        .client-item:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.3),
                0 10px 10px -5px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(99, 102, 241, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
    </style>
    @endpush

    <div class="min-h-screen main-bg py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-dark overflow-hidden shadow-2xl sm:rounded-2xl transition-all duration-300 hover:shadow-3xl border border-white/15 backdrop-blur-xl">
                <div class="p-6">
                    <!-- Campo de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="client-search" 
                                class="w-full px-4 py-3 pl-12 glass border border-white/20 rounded-xl focus:ring-4 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all duration-300 text-white placeholder:text-slate-400" 
                                placeholder="Search client...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de clientes -->
                    <div class="space-y-4" id="client-list">
                        @foreach ($clients as $client)
                            <div
                                class="client-item flex items-center justify-between p-6 glass-dark border border-white/20 rounded-xl hover:bg-white/10 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl group backdrop-blur-xl"
                                data-name="{{ strtolower($client->name) }}"
                                data-email="{{ strtolower($client->email) }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110">
                                        <div
                                            class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-600/20 flex items-center justify-center text-indigo-300 font-bold text-lg transition-all duration-300 group-hover:from-indigo-500/30 group-hover:to-purple-600/30 group-hover:text-indigo-200 border border-indigo-500/30">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="transition-all duration-300 group-hover:translate-x-1">
                                        <h3
                                            class="font-semibold text-white text-lg transition-colors duration-300 group-hover:text-indigo-300">
                                            {{ $client->name }}</h3>
                                        <p
                                            class="text-sm text-slate-400 transition-colors duration-300 group-hover:text-slate-300">
                                            {{ $client->email }}</p>
                                    </div>
                                </div>
                                <div class="transition-transform duration-300 hover:scale-105">
                                    <a href="{{ route('board.show', $client->highlevel_id) }}"
                                        class="inline-flex items-center px-6 py-3 text-sm font-semibold rounded-xl shadow-lg text-white bg-gradient-to-r from-indigo-600/80 to-purple-600/80 hover:from-indigo-700/80 hover:to-purple-700/80 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5 backdrop-blur-xl border border-indigo-500/30">
                                        View Dashboard
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-0.5 h-4 w-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Mensaje de no resultados -->
                    <div id="no-results" class="hidden py-12 text-center">
                        <div class="glass-dark rounded-xl p-8 border border-white/20 backdrop-blur-xl">
                            <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-white mb-2">No clients found</h3>
                            <p class="text-slate-400">Try adjusting your search terms</p>
                        </div>
                    </div>

                    <!-- Paginación con transición -->
                    @if ($clients->hasPages())
                        <div class="mt-8 transition-opacity duration-500" id="pagination-container">
                            <div class="glass-dark rounded-xl p-4 border border-white/20 backdrop-blur-xl">
                                {{ $clients->onEachSide(1)->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script para el filtro de búsqueda -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('client-search');
            const clientItems = document.querySelectorAll('.client-item');
            const noResults = document.getElementById('no-results');
            const paginationContainer = document.getElementById('pagination-container');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let hasVisibleItems = false;

                // Filtrar los elementos de la lista
                clientItems.forEach(function(item) {
                    const name = item.getAttribute('data-name');
                    const email = item.getAttribute('data-email');
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        item.classList.remove('hidden');
                        hasVisibleItems = true;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Mostrar mensaje de no resultados si no hay coincidencias
                if (hasVisibleItems) {
                    noResults.classList.add('hidden');
                } else {
                    noResults.classList.remove('hidden');
                }

                // Ocultar/mostrar paginación
                if (paginationContainer) {
                    if (searchTerm === '') {
                        paginationContainer.classList.remove('hidden');
                    } else {
                        paginationContainer.classList.add('hidden');
                    }
                }
            });

            // Limpiar búsqueda al cargar la página
            searchInput.value = '';
        });
    </script>
</x-app-layout>