<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Ranking</h1>

        @if (session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        <section class="mb-12">
            <!-- Card Principal -->
            <div class="bg-gradient-to-br from-indigo-50 to-white overflow-hidden shadow-xl sm:rounded-xl border border-indigo-100">
                <div class="p-8">
                    <!-- Título con badge -->
                    <div class="flex justify-center items-center gap-3 mb-10">
                        <h1 class="text-3xl font-bold text-gray-800">Keyword Position Finder</h1>
                        <span class="px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">SEO Tool</span>
                    </div>

                    <!-- Formulario principal con diseño moderno -->
                    <div class="space-y-8">
                        <!-- Fila de inputs -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Input Website con icono -->
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website URL</label>
                                </div>
                                <input type="url" id="website" name="website" placeholder="https://example.com"
                                       class="block w-full rounded-lg border-gray-300 bg-white/50 shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                            </div>

                            <!-- Location con icono -->
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                </div>
                                <input type="text" id="location" name="location" placeholder="Enter location"
                                       class="block w-full rounded-lg border-gray-300 bg-white/50 shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                            </div>

                            <!-- Manual Keyword Input con icono y botón -->
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                    </svg>
                                    <label for="manualKeyword" class="block text-sm font-medium text-gray-700">Manual Keyword Input</label>
                                </div>
                                <div class="flex space-x-2">
                                    <input type="text" id="manualKeyword" wire:model="inputAdd" name="manualKeyword" placeholder="Enter your keyword"
                                           class="flex-grow rounded-lg border-gray-300 bg-white/50 shadow-sm
                                                  focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                                    <button type="button" wire:click="addKeyword"
                                            class="px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg
                                                   hover:from-purple-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500
                                                   focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- CSV Upload con icono -->
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <label for="csv_file" class="block text-sm font-medium text-gray-700">Upload CSV</label>
                                </div>
                                <div class="relative">
                                    <input type="file" id="csv_file" name="csv_file" accept=".csv" class="sr-only"
                                           aria-label="Upload CSV" wire:model="file">
                                    <label for="csv_file"
                                           class="flex items-center justify-center w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-lg
                                                  hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500
                                                  focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm cursor-pointer">
                                        Choose CSV File
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Keyword Input Options -->
                        <div class="bg-white/70 p-6 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <h2 class="text-lg font-semibold text-gray-700">Keyword Input Options</h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button type="button"
                                        class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg
                                               hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500
                                               focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm">
                                    1. Top Keywords
                                </button>
                                <button type="button"
                                        class="w-full px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-semibold rounded-lg
                                               hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                               focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm">
                                    2. Top Keywords + City
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" wire:click="readExcel"
                                    class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-base font-semibold rounded-lg
                                           hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                           focus:ring-opacity-50 transition duration-300 ease-in-out shadow-md
                                           transform hover:scale-[1.02]">
                                Analyze Keywords
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keyword</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rank</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    CPC</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    URL</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                        <a href="https://ejemplo.com" target="_blank"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
