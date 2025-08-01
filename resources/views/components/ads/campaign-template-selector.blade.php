<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />

    <div class="relative">
        <select name="campaign_template"
            class="w-full border-2 border-gray-300 p-3 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white">
            <option value="" disabled selected>Select a campaign template</option>
            @foreach($groups as $group => $options)
                <optgroup label="{{ $group }}" class="font-medium text-gray-700">
                    @foreach($options as $value => $label)
                        <option value="{{ $value }}" class="py-2">{{ $label }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
    </div>

    <p class="mt-2 text-sm text-gray-500">Elige una plantilla que mejor se adapte a tu negocio</p>

    <!-- Hidden field to store the descriptive name for display -->
    <input type="hidden" name="campaign_template_display" id="campaign_template_display">
</div>
