<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
        </div>
        
        <input type="number" 
               value="{{ $value }}" 
               name="target_area"
               min="1"
               max="500"
               class="w-full pl-12 pr-20 glass-dark border border-white/20 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 text-white placeholder-slate-400 transition-all duration-300 backdrop-blur-xl shadow-lg hover:shadow-blue-500/10"
               placeholder="25">
        
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center space-x-2">
            <span class="text-slate-300 font-medium bg-white/10 px-2 py-1 rounded-lg backdrop-blur-xl">miles</span>
            <div class="relative group/tooltip">
                <svg class="h-5 w-5 text-slate-400 hover:text-blue-400 cursor-help transition-colors" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="hidden group-hover/tooltip:block absolute z-20 right-0 w-72 p-4 mt-2 text-sm text-slate-300 glass-dark rounded-2xl shadow-2xl border border-white/20 backdrop-blur-xl">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white mb-1">💡 Target Area Tips</p>
                            <p class="text-slate-300 mb-2">Enter the radius in miles around your selected location where you want your ads to appear.</p>
                            <ul class="text-xs text-slate-400 space-y-1">
                                <li>• Local business: 5-15 miles</li>
                                <li>• Regional service: 25-50 miles</li>
                                <li>• Wide coverage: 100+ miles</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Range Slider Visual -->
    <div class="mt-4 px-2">
        <div class="flex justify-between text-xs text-slate-500 mb-2">
            <span>Local (5mi)</span>
            <span>Regional (25mi)</span>
            <span>Wide (100mi+)</span>
        </div>
        <div class="relative h-2 bg-white/10 rounded-full">
            <div id="range-indicator" class="absolute top-0 left-0 h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-300" style="width: 25%"></div>
        </div>
    </div>
    
    <p class="text-sm text-slate-400 mt-3 flex items-center">
        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Specify the target area radius in miles around your selected location
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="target_area"]');
    const rangeIndicator = document.getElementById('range-indicator');
    
    function updateRangeIndicator() {
        const value = parseInt(input.value) || 0;
        const maxValue = 200; // Max value for visual representation
        const percentage = Math.min((value / maxValue) * 100, 100);
        rangeIndicator.style.width = percentage + '%';
        
        // Change color based on range
        if (value <= 15) {
            rangeIndicator.className = 'absolute top-0 left-0 h-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full transition-all duration-300';
        } else if (value <= 50) {
            rangeIndicator.className = 'absolute top-0 left-0 h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-300';
        } else {
            rangeIndicator.className = 'absolute top-0 left-0 h-2 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full transition-all duration-300';
        }
    }
    
    input.addEventListener('input', updateRangeIndicator);
    
    // Initialize
    updateRangeIndicator();
});
</script>
