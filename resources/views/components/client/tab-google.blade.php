<div class="hidden tab-content" id="google-tab">
    <div class="bg-white rounded-lg border border-gray-200 p-5">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Google Ads Information</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Account Information -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-700">Account Information</h4>

                <div>
                    <label for="google_ads_id" class="block text-sm font-medium text-gray-700">Google Ads ID</label>
                    <input type="text" id="google_ads_id" name="google_ads[id]"
                        value="{{ $client->googleAds->google_ads_id ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="google_ads_budget" class="block text-sm font-medium text-gray-700">Monthly Budget</label>
                    <input type="number" id="google_ads_budget" name="google_ads[budget]"
                        value="{{ $client->googleAds->budget ?? '' }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Campaign Status -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-700">Campaign Status</h4>

                <div>
                    <label for="campaign_status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="campaign_status" name="google_ads[status]"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ ($client->googleAds->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ ($client->googleAds->status ?? '') == 'paused' ? 'selected' : '' }}>Paused</option>
                        <option value="ended" {{ ($client->googleAds->status ?? '') == 'ended' ? 'selected' : '' }}>Ended</option>
                    </select>
                </div>

                <div>
                    <label for="last_updated" class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <input type="text" id="last_updated" name="google_ads[last_updated]"
                        value="{{ $client->googleAds->last_updated ?? '' }}"
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm" disabled>
                </div>
            </div>
        </div>

        <!-- Active Campaigns -->
        <div class="mt-6">
            <h4 class="font-medium text-gray-700 mb-3">Active Campaigns</h4>
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="space-y-4">
                    @if(isset($client->googleAds->campaigns) && !empty($client->googleAds->campaigns))
                        @foreach(json_decode($client->googleAds->campaigns, true) as $campaign)
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <h5 class="font-medium text-gray-800">{{ $campaign['name'] }}</h5>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $campaign['status'] }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <span class="text-gray-600">Budget:</span>
                                        <span class="font-medium">${{ $campaign['budget'] }}/day</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Impressions:</span>
                                        <span class="font-medium">{{ $campaign['impressions'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Clicks:</span>
                                        <span class="font-medium">{{ $campaign['clicks'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">CTR:</span>
                                        <span class="font-medium">{{ $campaign['ctr'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 py-4">
                            No active campaigns found
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Keywords -->
        <div class="mt-6">
            <h4 class="font-medium text-gray-700 mb-3">Target Keywords</h4>
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="flex flex-wrap gap-2">
                    @if(isset($client->googleAds->keywords) && !empty($client->googleAds->keywords))
                        @foreach(json_decode($client->googleAds->keywords, true) as $keyword)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $keyword }}</span>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 w-full">
                            No keywords found
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
