<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />

    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="text-gray-500 font-medium">$</span>
        </div>
        <input type="number" 
            value="{{ $value }}" 
            min="{{ $min }}" 
            name="daily_budget"
            class="w-full pl-8 pr-4 border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
            placeholder="0.00">
    </div>
    @isset($recommendation)
        <div class="mt-2 flex items-center text-sm text-gray-500">
            <svg class="h-4 w-4 mr-1 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $recommendation }}</span>
        </div>
    @endisset
</div>
