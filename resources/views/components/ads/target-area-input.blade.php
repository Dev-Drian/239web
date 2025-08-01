<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    
    <div class="relative">
        <input type="number" value="{{ $value }}" name="target_area"
            class="w-full border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center">
            <i class="fas fa-info-circle text-gray-400 hover:text-gray-600 cursor-pointer" 
               title="Enter the target area in miles"></i>
        </div>
    </div>
    <p class="text-sm text-gray-500 mt-1">Please specify the target area in miles</p>
</div>
