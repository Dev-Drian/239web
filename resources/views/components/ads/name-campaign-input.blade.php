<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    <div class="relative">
        <input type="text"
            name="name_campaign" 
            id="name_campaign"
            class="w-full border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
            placeholder="{{ $placeholder }}" 
            required>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
    </div>
    <p class="mt-2 text-sm text-gray-500">Ingresa un nombre descriptivo para tu campaña</p>
</div>