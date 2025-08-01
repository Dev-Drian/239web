@props(['percentage'])

<div class="mb-6 bg-white rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-300">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-medium text-gray-800 text-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
            </svg>
            Progress
        </h3>
        <span class="bg-green-100 text-green-800 text-sm font-medium px-2 py-1 rounded-md">
            {{ $percentage }}%
        </span>
    </div>
    
    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
        <div 
            class="h-2 rounded-full transition-all duration-700 ease-out"
            style="width: {{ $percentage }}%; background: linear-gradient(90deg, #34d399, #10b981);"
            x-data="{}" 
            x-init="setTimeout(() => $el.style.width = '{{ $percentage }}%', 100)"
        ></div>
    </div>
    
    <div class="flex justify-end mt-3 text-sm text-gray-500">
        @if($percentage < 30)
            <span class="text-gray-500">Getting started</span>
        @elseif($percentage < 70)
            <span class="text-blue-500">In progress</span>
        @elseif($percentage < 100)
            <span class="text-orange-500">Almost there</span>
        @else
            <span class="text-green-500">Completed!</span>
        @endif
    </div>
</div>