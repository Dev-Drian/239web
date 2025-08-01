<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Ranking</h1>

            @if (session('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Subir Datos</h2>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('client.ranking') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">Archivo CSV
                                    de keywords</label>
                                <input type="file" id="csv_file" name="csv_file" accept=".csv" required
                                    class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100">
                            </div>
                            <div class="mb-6">
                                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                                <input type="url" id="url" name="url" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition duration-300 ease-in-out transform hover:scale-105">
                                    Procesar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Resultadossadasd</h2>
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
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ejemplo
                                        Keyword</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$0.50</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                        <a href="https://ejemplo.com" target="_blank">https://ejemplo.com</a>
                                    </td>
                                </tr>
                                <!-- Puedes agregar más filas de ejemplo o dejar vacío -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
