<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
            <span class="text-slate-300 font-bold text-lg">$</span>
        </div>
        
        <input type="number" 
               value="{{ $value }}"
               min="{{ $min ?? 1 }}"
               step="0.01"
               name="daily_budget"
               class="w-full pl-10 pr-4 glass-dark border border-white/20 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 text-white placeholder-slate-400 transition-all duration-300 backdrop-blur-xl shadow-lg hover:shadow-emerald-500/10 text-lg font-semibold"
               placeholder="25.00">
    </div>
    
    @isset($recommendation)
        <div class="mt-3 p-3 glass-dark border border-emerald-500/30 rounded-xl backdrop-blur-xl">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-emerald-300 mb-1">💡 Budget Recommendation</p>
                    <p class="text-sm text-slate-300">{{ $recommendation }}</p>
                </div>
            </div>
        </div>
    @endisset
    
    <!-- Budget Range Guide -->
    <div class="mt-4 grid grid-cols-3 gap-3">
        <div class="text-center p-3 glass-dark border border-white/20 rounded-xl backdrop-blur-xl hover:border-emerald-500/30 transition-all cursor-pointer budget-suggestion" data-amount="15">
            <div class="text-emerald-400 font-bold text-lg">$15</div>
            <div class="text-xs text-slate-400 mt-1">Starter</div>
        </div>
        <div class="text-center p-3 glass-dark border border-white/20 rounded-xl backdrop-blur-xl hover:border-emerald-500/30 transition-all cursor-pointer budget-suggestion" data-amount="35">
            <div class="text-emerald-400 font-bold text-lg">$35</div>
            <div class="text-xs text-slate-400 mt-1">Recommended</div>
        </div>
        <div class="text-center p-3 glass-dark border border-white/20 rounded-xl backdrop-blur-xl hover:border-emerald-500/30 transition-all cursor-pointer budget-suggestion" data-amount="75">
            <div class="text-emerald-400 font-bold text-lg">$75</div>
            <div class="text-xs text-slate-400 mt-1">Aggressive</div>
        </div>
    </div>
    
    <div class="mt-4 flex items-start space-x-2 text-sm text-slate-400">
        <svg class="w-4 h-4 mt-0.5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
        </svg>
        <div>
            <p class="font-medium text-slate-300 mb-1">Daily Budget Guidelines:</p>
            <ul class="text-xs space-y-1">
                <li>• Your ads will stop showing when the daily budget is reached</li>
                <li>• Google may spend up to 2x your daily budget on high-traffic days</li>
                <li>• Monthly spend will not exceed daily budget × 30.4 days</li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="daily_budget"]');
    const budgetSuggestions = document.querySelectorAll('.budget-suggestion');
    
    // Handle budget suggestion clicks
    budgetSuggestions.forEach(suggestion => {
        suggestion.addEventListener('click', function() {
            const amount = this.dataset.amount;
            input.value = amount;
            input.focus();
            
            // Visual feedback
            budgetSuggestions.forEach(s => s.classList.remove('border-emerald-500/50', 'ring-2', 'ring-emerald-500/30'));
            this.classList.add('border-emerald-500/50', 'ring-2', 'ring-emerald-500/30');
            
            setTimeout(() => {
                this.classList.remove('border-emerald-500/50', 'ring-2', 'ring-emerald-500/30');
            }, 2000);
        });
    });
    
    // Format input value
    input.addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);
        }
    });
});
</script>
