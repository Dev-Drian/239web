<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Texto a la izquierda -->
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('SEO Analysis') }}
            </h2>

            <!-- Imagen a la derecha -->
            <div class="flex items-center">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="w-52">
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        SEO Analysis Tool
                    </div>
                    <form id="keywordForm" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="searchUrl" class="block text-sm font-medium text-gray-700">Site URL</label>
                                <input type="text" id="searchUrl" name="searchUrl" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" id="location" name="location" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                        </div>


                        <div class="flex justify-between items-center">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Process Keywords
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
