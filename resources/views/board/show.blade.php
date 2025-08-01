<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Task'])
    </x-slot>

    @livewire('board.index', ['client' => $client])

</x-app-layout>
