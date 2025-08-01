<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Client List'])
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg transition-all duration-300 hover:shadow-2xl">
                <div class="p-6">
                    <!-- Campo de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="client-search" 
                                class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                                placeholder="Search client...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                            </div>
                        </div>
                    </div>

                    <!-- Lista de clientes -->
                    <div class="space-y-3" id="client-list">
                        @foreach ($clients as $client)
                            <div
                                class="client-item flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-indigo-50 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md group"
                                data-name="{{ strtolower($client->name) }}"
                                data-email="{{ strtolower($client->email) }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110">
                                        <div
                                            class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium transition-colors duration-300 group-hover:bg-indigo-200 group-hover:text-indigo-800">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="transition-all duration-300 group-hover:translate-x-1">
                                        <h3
                                            class="font-medium text-gray-900 transition-colors duration-300 group-hover:text-indigo-700">
                                            {{ $client->name }}</h3>
                                        <p
                                            class="text-sm text-gray-500 transition-colors duration-300 group-hover:text-gray-700">
                                            {{ $client->email }}</p>
                                    </div>
                                </div>
                                <div class="transition-transform duration-300 hover:scale-105">
                                    <a href="{{ route('board.show', $client->highlevel_id) }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
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
                    <div id="no-results" class="hidden py-8 text-center">
                        <p class="text-gray-500">not found</p>
                    </div>

                    <!-- Paginación con transición -->
                    @if ($clients->hasPages())
                        <div class="mt-6 transition-opacity duration-500" id="pagination-container">
                            {{ $clients->onEachSide(1)->links() }}
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