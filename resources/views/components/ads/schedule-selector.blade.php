<div class="mb-6">
    <x-ads.header-ad step="{{ $step }}" name="{{ $name }}" />
    
    <!-- Schedule Selector Container -->
    <div class="glass-dark border border-white/20 rounded-2xl p-6 backdrop-blur-xl shadow-lg">
        <div class="space-y-6">
            <!-- Day Selection -->
            <div>
                <label class="block text-sm font-medium text-white mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Select Days
                </label>
                
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_mon" name="ad_schedule[days][]" value="MONDAY"
                            class="sr-only peer" checked>
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Mon</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_tue" name="ad_schedule[days][]" value="TUESDAY"
                            class="sr-only peer" checked>
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Tue</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_wed" name="ad_schedule[days][]" value="WEDNESDAY"
                            class="sr-only peer" checked>
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Wed</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_thu" name="ad_schedule[days][]" value="THURSDAY"
                            class="sr-only peer" checked>
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Thu</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_fri" name="ad_schedule[days][]" value="FRIDAY"
                            class="sr-only peer" checked>
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Fri</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_sat" name="ad_schedule[days][]" value="SATURDAY"
                            class="sr-only peer">
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Sat</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-3 glass-dark border border-white/20 rounded-xl cursor-pointer hover:border-white/30 transition-all group backdrop-blur-xl">
                        <input type="checkbox" id="schedule_sun" name="ad_schedule[days][]" value="SUNDAY"
                            class="sr-only peer">
                        <div class="text-center peer-checked:text-blue-300 group-hover:text-blue-400 transition-colors">
                            <div class="w-8 h-8 mx-auto mb-1 rounded-full border-2 border-white/30 flex items-center justify-center peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-white">Sun</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Time Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-white mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Start Time
                    </label>
                    <div class="relative">
                        <select id="start_time" name="ad_schedule[start_time]"
                            class="block w-full glass-dark border border-white/20 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 text-white backdrop-blur-xl appearance-none">
                        @foreach (range(0, 23) as $hour)
                            <option value="{{ sprintf('%02d:00', $hour) }}" {{ $hour == 8 ? 'selected' : '' }} class="bg-slate-800 text-white">
                                {{ sprintf('%02d:00', $hour) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <label for="end_time" class="block text-sm font-medium text-white mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    End Time
                </label>
                <div class="relative">
                    <select id="end_time" name="ad_schedule[end_time]"
                        class="block w-full glass-dark border border-white/20 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 text-white backdrop-blur-xl appearance-none">
                        @foreach (range(1, 24) as $hour)
                            <option value="{{ $hour == 24 ? '23:59' : sprintf('%02d:00', $hour) }}"
                                {{ $hour == 20 ? 'selected' : '' }} class="bg-slate-800 text-white">
                                {{ $hour == 24 ? '23:59' : sprintf('%02d:00', $hour) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Select Buttons -->
        <div class="flex flex-wrap gap-2 pt-4 border-t border-white/20">
            <button type="button" onclick="selectWeekdays()"
                class="px-4 py-2 text-sm font-medium rounded-xl glass-dark border border-white/20 text-slate-300 hover:text-white hover:border-white/30 transition-all backdrop-blur-xl">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6" />
                </svg>
                Weekdays
            </button>
            <button type="button" onclick="selectWeekend()"
                class="px-4 py-2 text-sm font-medium rounded-xl glass-dark border border-white/20 text-slate-300 hover:text-white hover:border-white/30 transition-all backdrop-blur-xl">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15" />
                </svg>
                Weekend
            </button>
            <button type="button" onclick="selectAllDays()"
                class="px-4 py-2 text-sm font-medium rounded-xl glass-dark border border-white/20 text-slate-300 hover:text-white hover:border-white/30 transition-all backdrop-blur-xl">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                All Days
            </button>
        </div>
    </div>
    
    <div class="mt-4 flex items-start space-x-2 text-sm text-slate-400">
        <svg class="w-4 h-4 mt-0.5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="font-medium text-slate-300 mb-1">Ad Schedule Tips:</p>
            <ul class="text-xs space-y-1">
                <li>• Your ads will only show during the selected days and times</li>
                <li>• Consider your target audience's active hours</li>
                <li>• Business hours typically work best for B2B campaigns</li>
            </ul>
        </div>
    </div>
</div>

<script>
    function selectWeekdays() {
        const weekdays = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'];
        document.querySelectorAll('input[name="ad_schedule[days][]"]').forEach(checkbox => {
            checkbox.checked = weekdays.includes(checkbox.value);
        });
    }

    function selectWeekend() {
        const weekend = ['SATURDAY', 'SUNDAY'];
        document.querySelectorAll('input[name="ad_schedule[days][]"]').forEach(checkbox => {
            checkbox.checked = weekend.includes(checkbox.value);
        });
    }

    function selectAllDays() {
        document.querySelectorAll('input[name="ad_schedule[days][]"]').forEach(checkbox => {
            checkbox.checked = true;
        });
    }
</script>
