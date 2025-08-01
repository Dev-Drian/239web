<!-- resources/views/citations/form.blade.php -->
<!-- resources/views/citations/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Chat'])
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @livewire('chat.list-c')
            </div>
        </div>

    </div>
</x-app-layout>
