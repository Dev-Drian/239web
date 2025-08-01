<div class="mb-6">
    <!-- Header with Google Ads styling -->
    <label class="block text-sm font-medium text-gray-700 mb-2">Ad Schedule</label>

    <!-- Schedule Selector Container -->
    <div class="space-y-3">
        <!-- Day Selection -->
        <div class="flex flex-wrap gap-2">
            <div class="flex items-center">
                <input type="checkbox" id="schedule_mon" name="ad_schedule[days][]" value="MONDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                <label for="schedule_mon" class="ml-2 block text-sm text-gray-700">Mon</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_tue" name="ad_schedule[days][]" value="TUESDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                <label for="schedule_tue" class="ml-2 block text-sm text-gray-700">Tue</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_wed" name="ad_schedule[days][]" value="WEDNESDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                <label for="schedule_wed" class="ml-2 block text-sm text-gray-700">Wed</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_thu" name="ad_schedule[days][]" value="THURSDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                <label for="schedule_thu" class="ml-2 block text-sm text-gray-700">Thu</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_fri" name="ad_schedule[days][]" value="FRIDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                <label for="schedule_fri" class="ml-2 block text-sm text-gray-700">Fri</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_sat" name="ad_schedule[days][]" value="SATURDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="schedule_sat" class="ml-2 block text-sm text-gray-700">Sat</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="schedule_sun" name="ad_schedule[days][]" value="SUNDAY"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="schedule_sun" class="ml-2 block text-sm text-gray-700">Sun</label>
            </div>
        </div>

        <!-- Time Selection -->
        <div class="flex items-center gap-3">
            <div class="flex-1">
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                <select id="start_time" name="ad_schedule[start_time]"
                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    @foreach (range(0, 23) as $hour)
                        <option value="{{ sprintf('%02d:00', $hour) }}" {{ $hour == 8 ? 'selected' : '' }}>
                            {{ sprintf('%02d:00', $hour) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1">
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                <select id="end_time" name="ad_schedule[end_time]"
                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    @foreach (range(1, 24) as $hour)
                        <option value="{{ $hour == 24 ? '23:59' : sprintf('%02d:00', $hour) }}"
                            {{ $hour == 20 ? 'selected' : '' }}>
                            {{ $hour == 24 ? '23:59' : sprintf('%02d:00', $hour) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Quick Select Buttons -->
        <div class="flex gap-2 pt-1">
            <button type="button" onclick="selectWeekdays()"
                class="px-3 py-1 text-xs font-medium rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                Weekdays
            </button>
            <button type="button" onclick="selectWeekend()"
                class="px-3 py-1 text-xs font-medium rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                Weekend
            </button>
            <button type="button" onclick="selectAllDays()"
                class="px-3 py-1 text-xs font-medium rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                All Days
            </button>
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
