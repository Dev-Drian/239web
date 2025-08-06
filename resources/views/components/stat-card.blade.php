@props([
    'iconColor' => 'blue', // Valor predeterminado
    'title' => 'Default Title', // Valor predeterminado
    'value' => '0', // Valor predeterminado
    'id' => null, // ID opcional para el contenedor del valor
])

@php
    // Definir colores y clases basados en el ícono
    $iconClasses = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
    ];

    $iconClass = $iconClasses[$iconColor] ?? 'bg-gray-100 text-gray-600'; // Default si no coincide
@endphp

<div class="bg-white overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-md">
    <div class="p-4 flex items-center">
        <!-- Ícono -->
        <div class="p-3 rounded-full {{ $iconClass }} mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if ($iconColor === 'blue')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                @elseif ($iconColor === 'green')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                @elseif ($iconColor === 'purple')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                @elseif ($iconColor === 'yellow')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                @endif
            </svg>
        </div>

        <!-- Título y Valor -->
        <div>
            <div class="text-sm font-medium text-gray-500">{{ $title }}</div>
            <div id="{{ $id }}" class="text-2xl font-semibold">{{ $value }}</div>
        </div>
    </div>
</div>  