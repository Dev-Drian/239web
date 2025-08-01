<!-- resources/views/citations/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Citations'])
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('citations.show') }}" method="GET" class="mb-8">
                        <div class="flex gap-4 items-end">
                            <div class="w-full md:w-1/3">
                                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Client
                                </label>
                                <select id="client_id" name="client_id" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300
                                     focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                                     rounded-md">
                                    <option value="">-- Select a client --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->website }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md
                                 transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>
                                View Client Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
