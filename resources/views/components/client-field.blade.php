@props(['label', 'name', 'value' => ''])

<div class="editable-field">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <div class="relative">
        <div class="field-value p-2 border border-gray-300 rounded-md bg-white min-h-[42px] cursor-pointer hover:bg-gray-50 transition-colors">
            {{ $value }}
        </div>
        <div class="field-edit hidden">
            <input 
                type="text" 
                name="{{ $name }}" 
                id="{{ $name }}" 
                value="{{ $value }}" 
                class="block w-full p-2 border border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
        </div>
    </div>
</div>