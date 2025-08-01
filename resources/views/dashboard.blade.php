<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Dashboard'])
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome 
                    :clients="$clients" 
                    :blogs="$blogs" 
                    :tasks="$tasks" 
                />
            </div>
        </div>
    </div>
</x-app-layout>