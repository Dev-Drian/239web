<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="text-2xl font-bold text-white">Chat Management</h2>
            <span class="text-sm text-slate-400 px-2 py-1 glass-dark rounded-full">Communication System</span>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-dark overflow-hidden shadow-sm sm:rounded-lg border border-white/15">

                @livewire('chat.list-c')
            </div>
        </div>
    </div>
</x-app-layout>
