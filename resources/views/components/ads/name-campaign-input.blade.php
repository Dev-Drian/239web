<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    <div class="relative group">
        <input type="text"
            name="name_campaign" 
            id="name_campaign"
            class="w-full glass border border-white/20 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 text-white placeholder-slate-400 bg-transparent backdrop-blur-xl shadow-lg hover:shadow-xl"
            placeholder="{{ $placeholder }}" 
            required>
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <!-- Enhanced focus ring -->
        <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent group-focus-within:ring-blue-500/30 transition-all duration-300 pointer-events-none"></div>
    </div>
    <p class="mt-3 text-sm text-slate-400 flex items-center">
        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Enter a descriptive name for your campaign.
    </p>
</div>
