<div class="flex items-center mb-3">
    <!-- Enhanced step indicator with glassmorphism -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-4 flex-shrink-0 shadow-lg ring-2 ring-blue-500/30 backdrop-blur-xl">
        <span class="text-sm font-bold">{{ $step }}</span>
    </div>
    
    <!-- Title with enhanced visual hierarchy -->
    <div class="flex flex-col flex-1">
        <h2 class="text-lg font-bold text-white flex items-center">
            {{ $name }}
            <div class="ml-2 w-2 h-2 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full animate-pulse"></div>
        </h2>
        @if(isset($subtitle))
            <p class="text-xs text-slate-400 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    
    <!-- Enhanced help tooltip with glassmorphism -->
    @if(isset($hint))
        <div class="ml-auto flex items-center">
            <div class="relative group">
                <button type="button" class="inline-flex text-slate-400 hover:text-blue-400 transition-colors duration-300 p-2 rounded-full hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
                <div class="hidden group-hover:block absolute z-20 right-0 w-72 p-4 mt-2 text-sm text-slate-300 glass-dark rounded-2xl shadow-2xl border border-white/20 backdrop-blur-xl transform transition-all duration-300">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white mb-1">💡 Tip</p>
                            <p class="text-slate-300">{{ $hint }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
