@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 py-6">
        
        <!-- Results Info with Icon -->
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500/20 to-purple-600/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-blue-500/30">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="text-sm text-white/70">
                Showing 
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                    {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }}
                </span>
                of 
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    {{ $paginator->total() }}
                </span>
                results
            </div>
        </div>
        
        <!-- Circular Pagination Controls -->
        <div class="flex items-center space-x-2">
            
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <div class="w-10 h-10 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center cursor-not-allowed opacity-50">
                    <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center hover:border-blue-500/50 hover:bg-blue-500/20 transition-all duration-300 group shadow-lg hover:shadow-blue-500/25">
                    <svg class="w-4 h-4 text-white/70 group-hover:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif
            
            <!-- Page Numbers in Circles -->
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($start + 4, $paginator->lastPage());
                $start = max($end - 4, 1);
            @endphp
            
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-sm font-medium text-white/70 hover:border-blue-500/50 hover:bg-blue-500/20 hover:text-blue-300 transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                    1
                </a>
                @if($start > 2)
                    <div class="flex items-center space-x-1 px-2">
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                    </div>
                @endif
            @endif
            
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-sm font-bold text-white shadow-2xl shadow-blue-500/50 ring-4 ring-blue-500/20 transform scale-110 backdrop-blur-sm">
                        {{ $i }}
                    </div>
                @else
                    <a href="{{ $paginator->url($i) }}" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-sm font-medium text-white/70 hover:border-blue-500/50 hover:bg-blue-500/20 hover:text-blue-300 transition-all duration-300 shadow-lg hover:shadow-blue-500/25 hover:scale-105">
                        {{ $i }}
                    </a>
                @endif
            @endfor
            
            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <div class="flex items-center space-x-1 px-2">
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/30 rounded-full"></div>
                    </div>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-sm font-medium text-white/70 hover:border-blue-500/50 hover:bg-blue-500/20 hover:text-blue-300 transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                    {{ $paginator->lastPage() }}
                </a>
            @endif
            
            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center hover:border-blue-500/50 hover:bg-blue-500/20 transition-all duration-300 group shadow-lg hover:shadow-blue-500/25">
                    <svg class="w-4 h-4 text-white/70 group-hover:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <div class="w-10 h-10 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center cursor-not-allowed opacity-50">
                    <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            @endif
        </div>
        
        <!-- Page Progress Indicator -->
        <div class="hidden sm:flex items-center space-x-2">
            <span class="text-xs text-white/60">Page</span>
            <div class="flex items-center space-x-1">
                @for ($i = 1; $i <= min($paginator->lastPage(), 5); $i++)
                    @if ($i == $paginator->currentPage())
                        <div class="w-2 h-2 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50"></div>
                    @elseif ($i <= $paginator->currentPage())
                        <div class="w-2 h-2 bg-blue-400/60 rounded-full"></div>
                    @else
                        <div class="w-2 h-2 bg-white/20 rounded-full"></div>
                    @endif
                @endfor
                @if ($paginator->lastPage() > 5)
                    <span class="text-xs text-white/50 ml-1">+{{ $paginator->lastPage() - 5 }}</span>
                @endif
            </div>
            <span class="text-xs text-white/60">{{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}</span>
        </div>
    </div>
    
    <!-- Mobile Simplified View -->
    <div class="sm:hidden flex items-center justify-center space-x-4 py-2">
        <div class="flex items-center space-x-2 px-3 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
            <div class="w-2 h-2 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50"></div>
            <span class="text-sm text-white/80">{{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>
        </div>
        
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-2xl shadow-blue-500/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif
        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-2xl shadow-blue-500/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @endif
    </div>
@endif
