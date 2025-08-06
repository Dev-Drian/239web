<div id="basic-tab" class="tab-content p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Client Info -->
        <div class="glass-dark rounded-2xl border border-white/15 p-6 backdrop-blur-xl">
            <h3 class="text-xl font-semibold mb-6 pb-3 border-b border-white/15 text-white flex items-center">
                <div class="w-2 h-6 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full mr-3"></div>
                Client Information
            </h3>

            <div class="space-y-5">
                <div class="group">
                    <label for="name"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-blue-300 transition-colors duration-200">
                        Client Name*
                    </label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ $client->name ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="highlevel_id" class="block text-sm font-medium text-slate-300 mb-2">
                        Highlevel ID
                    </label>
                    <div class="relative">
                        <input type="text" id="highlevel_id" name="highlevel_id" disabled
                            value="{{ $client->highlevel_id }}"
                            class="w-full px-4 py-3 glass border border-white/10 rounded-xl bg-slate-700/50 text-slate-400 backdrop-blur-xl cursor-not-allowed">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="email"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-blue-300 transition-colors duration-200">
                        Email Address*
                    </label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ $client->email ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="website"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-blue-300 transition-colors duration-200">
                        Website
                    </label>
                    <div class="relative">
                        <input type="text" id="website" name="website" value="{{ $client->website ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="premium"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-blue-300 transition-colors duration-200">
                        Account Type
                    </label>
                    <div class="relative">
                        <select id="premium" name="premium"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl appearance-none cursor-pointer">
                            <option value="1" {{ $client->premium ? 'selected' : '' }}
                                class="bg-slate-800 text-white">Premium</option>
                            <option value="0" {{ !$client->premium ? 'selected' : '' }}
                                class="bg-slate-800 text-white">Standard</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact & Additional Info -->
        <div class="glass-dark rounded-2xl border border-white/15 p-6 backdrop-blur-xl">
            <h3 class="text-xl font-semibold mb-6 pb-3 border-b border-white/15 text-white flex items-center">
                <div class="w-2 h-6 bg-gradient-to-b from-green-500 to-emerald-500 rounded-full mr-3"></div>
                Contact & Additional Info
            </h3>

            <div class="space-y-5">
                <div class="group">
                    <label for="full_name"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                        Contact Name
                    </label>
                    <div class="relative">
                        <input type="text" id="full_name" name="details[full_name]"
                            value="{{ $client->ClientDetails->full_name ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="phone"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                        Phone Number
                    </label>
                    <div class="relative">
                        <input type="text" id="phone" name="details[phone]"
                            value="{{ $client->clientLocations->formatted_phone_number ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="address"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                        Address
                    </label>
                    <div class="relative">
                        <input type="text" id="address" name="address" value="{{ $client->address ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="city"
                        class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                        City
                    </label>
                    <div class="relative">
                        <input type="text" id="city" name="city" value="{{ $client->city ?? '' }}"
                            class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2m0 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="primary_city" class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">Primary City (for
                        articles)</label>
                    <input type="text" id="primary_city" name="primary_city"
                        value="{{ $client->primary_city ?? '' }}" placeholder="e.g., Cleveland (instead of Wyckiff)"
                       class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                    <p class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">This city will be used in AI-generated articles and content
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="group">
                        <label for="year_found"
                            class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                            Year Founded
                        </label>
                        <div class="relative">
                            <input type="number" id="year_found" name="details[year_found]"
                                value="{{ $client->ClientDetails->year_found ?? '' }}"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl"
                                min="1000" max="9999"
                                oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4)">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <label for="employees"
                            class="block text-sm font-medium text-slate-300 mb-2 group-hover:text-green-300 transition-colors duration-200">
                            Employees
                        </label>
                        <div class="relative">
                            <input type="number" id="employees" name="details[employees]"
                                value="{{ $client->ClientDetails->employees ?? '' }}"
                                class="w-full px-4 py-3 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
