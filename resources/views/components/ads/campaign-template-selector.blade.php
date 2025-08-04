<div class="mb-8">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    <div class="relative group">
        <select name="campaign_template"
            class="w-full glass border border-white/20 p-4 rounded-2xl appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 text-white bg-transparent backdrop-blur-xl shadow-lg hover:shadow-xl">
            <option value="" disabled selected class="bg-slate-800 text-white">Select a campaign template</option>
            @foreach($groups as $group => $options)
                <optgroup label="{{ $group }}" class="font-medium text-slate-300 bg-slate-700">
                    @foreach($options as $value => $label)
                        <option value="{{ $value }}" class="py-2 bg-slate-800 text-white">{{ $label }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
        <!-- Enhanced focus ring -->
        <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent group-focus-within:ring-blue-500/30 transition-all duration-300 pointer-events-none"></div>
    </div>
    <!-- Hidden field to store the descriptive name for display -->
    <input type="hidden" name="campaign_template_display" id="campaign_template_display">
</div>
