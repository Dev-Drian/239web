<x-app-layout>

    <x-slot name="header">
        @include('components.header', ['name' => 'All Task Board'])
    </x-slot>
    @livewire('board.showall')

</x-app-layout>
