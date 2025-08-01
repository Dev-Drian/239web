<div class="flex items-center mb-3">
    <!-- Step indicator with subtle shadow and gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-full w-7 h-7 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
        <span class="text-sm font-medium">{{ $step }}</span>
    </div>
    
    <!-- Title with better visual hierarchy -->
    <div class="flex flex-col">
        <h2 class="text-lg font-bold text-gray-800">{{ $name }}</h2>
        @if(isset($subtitle))
            <p class="text-xs text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>
    
    <!-- Optional help tooltip -->
    @if(isset($hint))
        <div class="ml-auto flex items-center">
            <div class="relative group">
                <button type="button" class="inline-flex text-gray-400 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
                <div class="hidden group-hover:block absolute z-10 right-0 w-64 p-2 mt-1 text-xs text-gray-600 bg-white rounded-md shadow-lg border border-gray-200">
                    {{ $hint }}
                </div>
            </div>
        </div>
    @endif
</div>