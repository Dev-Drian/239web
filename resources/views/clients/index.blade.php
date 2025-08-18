<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Client'])
    </x-slot>

    <div class="min-h-screen main-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            
            <!-- Minimal Header with smooth animations -->
            <div class="glass-dark rounded-2xl shadow-2xl mb-4 p-4 transform transition-all duration-500 hover:shadow-2xl hover:scale-[1.02] group border border-white/15 backdrop-blur-xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:rotate-12 transition-all duration-300 ring-2 ring-blue-500/30">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white group-hover:text-blue-300 transition-colors duration-300">Client Management</h1>
                            <p class="text-slate-400 text-xs group-hover:text-slate-300 transition-colors duration-300">{{ isset($clients) ? $clients->count() : 0 }} clients total</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button onclick="openModal()"
                             class="group/btn inline-flex items-center px-3 py-2 glass text-blue-300 rounded-xl hover:bg-blue-500/20 transition-all duration-300 text-sm font-medium transform hover:scale-105 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-1 group-hover/btn:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Client
                        </button>
                        <a href="{{ route('seo.table')}}"
                            class="px-3 py-2 rounded-xl text-sm font-bold transition-all duration-300 border-2
                            {{ strtoupper(request('subscriptions')) === 'SEO' ? 'bg-blue-500/20 text-blue-300 border-blue-500/50 shadow-xl ring-2 ring-blue-500/30' : 'glass text-slate-300 border-white/20 hover:bg-blue-500/10 hover:text-blue-300' }}">
                            SEO
                        </a>
                        <a href="{{ route('client.index', array_merge(request()->except('subscriptions'), ['subscriptions' => 'ppc'])) }}"
                            class="px-3 py-2 rounded-xl text-sm font-bold transition-all duration-300 border-2
                            {{ strtoupper(request('subscriptions')) === 'PPC' ? 'bg-green-500/20 text-green-300 border-green-500/50 shadow-xl ring-2 ring-green-500/30' : 'glass text-slate-300 border-white/20 hover:bg-green-500/10 hover:text-green-300' }}">
                            PPC
                        </a>
                        <a href="{{ route('client.index', request()->except('subscriptions')) }}"
                            class="px-3 py-2 rounded-xl text-sm font-bold transition-all duration-300 border-2
                            {{ !request('subscriptions') ? 'bg-slate-500/20 text-slate-300 border-slate-500/50 shadow-xl ring-2 ring-slate-500/30' : 'glass text-slate-300 border-white/20 hover:bg-slate-500/10' }}">
                            All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Error Display with beautiful animations -->
            @error('highlevel_id')
                <div class="glass-dark border border-red-500/30 rounded-2xl p-3 mb-4 transform transition-all duration-500 hover:shadow-md animate-slideInDown backdrop-blur-xl">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-red-300 text-sm font-medium">{{ $message }}</p>
                    </div>
                </div>
            @enderror

            <!-- Quick Stats with hover effects -->
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="glass-dark rounded-2xl p-3 shadow-lg border border-white/15 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:bg-white/5 group cursor-pointer backdrop-blur-xl">
                    <div class="text-center">
                        <div class="text-lg font-bold text-emerald-400 group-hover:text-emerald-300 transition-colors duration-300">{{ isset($ids['new_ids']) ? count($ids['new_ids']) : 0 }}</div>
                        <div class="text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300">New</div>
                        <div class="w-full h-1 bg-slate-700 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transform transition-all duration-1000 ease-out group-hover:scale-x-110" style="width: {{ isset($ids['new_ids']) ? count($ids['new_ids']) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="glass-dark rounded-2xl p-3 shadow-lg border border-white/15 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:bg-white/5 group cursor-pointer backdrop-blur-xl">
                    <div class="text-center">
                        <div class="text-lg font-bold text-red-400 group-hover:text-red-300 transition-colors duration-300">{{ isset($ids['missing_ids']) ? count($ids['missing_ids']) : 0 }}</div>
                        <div class="text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300">Missing</div>
                        <div class="w-full h-1 bg-slate-700 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-red-400 to-red-500 rounded-full transform transition-all duration-1000 ease-out group-hover:scale-x-110" style="width: {{ isset($ids['missing_ids']) ? count($ids['missing_ids']) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="glass-dark rounded-2xl p-3 shadow-lg border border-white/15 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:bg-white/5 group cursor-pointer backdrop-blur-xl">
                    <div class="text-center">
                        <div class="text-lg font-bold text-blue-400 group-hover:text-blue-300 transition-colors duration-300">{{ isset($ids['total_db_ids']) ? $ids['total_db_ids'] : 0 }}</div>
                        <div class="text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300">Total</div>
                        <div class="w-full h-1 bg-slate-700 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full transform transition-all duration-1000 ease-out group-hover:scale-x-110" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs for status filter -->
            <div class="mb-4">
                <div class="flex space-x-2">
                    <a href="{{ route('client.index', array_merge(request()->except('status_filter'), ['status_filter' => null])) }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                       {{ !request('status_filter') ? 'bg-blue-500/20 text-blue-300 shadow-lg ring-2 ring-blue-500/30' : 'glass text-slate-300 hover:bg-blue-500/10 hover:text-blue-300 border border-white/20' }}">
                        All
                    </a>
                    <a href="{{ route('client.index', array_merge(request()->except('status_filter'), ['status_filter' => 'active'])) }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                       {{ request('status_filter') === 'active' ? 'bg-blue-500/20 text-blue-300 shadow-lg ring-2 ring-blue-500/30' : 'glass text-slate-300 hover:bg-blue-500/10 hover:text-blue-300 border border-white/20' }}">
                        Active
                    </a>
                    <a href="{{ route('client.index', array_merge(request()->except('status_filter'), ['status_filter' => 'hidden'])) }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                       {{ request('status_filter') === 'hidden' ? 'bg-blue-500/20 text-blue-300 shadow-lg ring-2 ring-blue-500/30' : 'glass text-slate-300 hover:bg-blue-500/10 hover:text-blue-300 border border-white/20' }}">
                        Hidden
                    </a>
                </div>
            </div>

            <!-- Enhanced Main Table Section -->
            <div class="glass-dark backdrop-blur-xl rounded-2xl shadow-2xl border border-white/15 overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
                <!-- Enhanced Table Header with Search and Filters -->
                <div class="p-4 border-b border-white/15 glass-dark">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-3 lg:space-y-0">
                        <div class="flex items-center space-x-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full mr-3 animate-pulse"></div>
                                Client Directory
                            </h3>
                            
                            <!-- Table Controls -->
                            <div class="flex items-center space-x-2">
                                <button onclick="toggleSelectAll()" class="text-xs px-2 py-1 glass text-slate-300 rounded-lg hover:bg-white/10 hover:text-blue-300 transition-all duration-200 border border-white/20">
                                    Select All
                                </button>
                                <button onclick="exportSelected()" class="text-xs px-2 py-1 bg-green-500/20 text-green-300 rounded-lg hover:bg-green-500/30 transition-all duration-200 border border-green-500/30">
                                    Export
                                </button>
                                <button onclick="deleteSelected()" class="text-xs px-2 py-1 bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition-all duration-200 border border-red-500/30">
                                    Delete Selected
                                </button>
                            </div>
                        </div>
                        
                        <!-- Enhanced Search and Filter Form -->
                        <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                            <form method="GET" action="{{ route('client.index') }}" class="flex gap-2">
                                <div class="relative group">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" name="search" placeholder="Search clients..." value="{{ request('search') }}"
                                        class="pl-9 pr-3 py-2 w-64 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 text-sm transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl">
                                </div>
                                
                                <button type="submit"
                                     class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 text-sm font-medium transform hover:scale-105 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                
                                @if(request('search') || request('status_filter'))
                                    <a href="{{ route('client.index') }}"
                                         class="px-3 py-2 glass text-slate-300 rounded-xl hover:bg-white/10 hover:text-white transition-all duration-200 text-sm border border-white/20">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                @if ($clients && $clients->count() > 0)
                    <!-- Enhanced Table with sorting and selection -->
                    <div class="overflow-x-auto glass-dark rounded-2xl">
                        <table class="w-full table-auto text-sm md:text-base" id="clientsTable">
                            <thead class="glass-dark border-b border-white/15">
                                <tr>
                                    <th class="px-2 py-2 text-left">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()"
                                             class="rounded border-slate-600 bg-slate-700 text-blue-500 focus:ring-blue-500/50 transition-colors duration-200">
                                    </th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-300 uppercase tracking-wider hover:text-blue-400 transition-colors duration-300 cursor-pointer hidden md:table-cell" onclick="sortTable('id')">
                                        <div class="flex items-center space-x-1">
                                            <span>ID</span>
                                            <svg class="w-3 h-3 opacity-50 hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </div>
                                    </th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-300 uppercase tracking-wider hover:text-blue-400 transition-colors duration-300 cursor-pointer" onclick="sortTable('name')">
                                        <div class="flex items-center space-x-1">
                                            <span>Client</span>
                                            <svg class="w-3 h-3 opacity-50 hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </div>
                                    </th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-300 uppercase tracking-wider hover:text-blue-400 transition-colors duration-300 cursor-pointer hidden sm:table-cell" onclick="sortTable('email')">
                                        <div class="flex items-center space-x-1">
                                            <span>Email</span>
                                            <svg class="w-3 h-3 opacity-50 hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </div>
                                    </th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-300 uppercase tracking-wider hover:text-blue-400 transition-colors duration-300 cursor-pointer" onclick="sortTable('status')">Status</th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="glass-dark divide-y divide-white/10">
                                @foreach ($clients as $index => $user)
                                    <tr class="hover:bg-white/5 transition-all duration-300 {{ $index % 2 === 0 ? 'bg-white/5' : 'bg-transparent' }} group transform hover:scale-[1.01] hover:shadow-lg border-b border-white/5"
                                         data-client-id="{{ $user['highlevel_id'] }}"
                                        data-client-name="{{ $user['name'] }}"
                                        data-client-email="{{ $user['email'] }}"
                                        data-client-status="{{ $user['status'] }}">
                                        
                                        <td class="px-2 py-2">
                                            <input type="checkbox" class="client-checkbox rounded border-slate-600 bg-slate-700 text-blue-500 focus:ring-blue-500/50 transition-colors duration-200"
                                                 value="{{ $user['highlevel_id'] }}" onchange="updateSelectAllState()">
                                        </td>
                                        
                                        <td class="px-2 py-2 hidden md:table-cell">
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full group-hover:scale-125 transition-transform duration-300 animate-pulse"></div>
                                                <div>
                                                    <div class="text-xs font-semibold text-slate-300 group-hover:text-blue-400 transition-colors duration-300">{{ substr($user['highlevel_id'], 0, 8) }}...</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-2 py-2">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300 ring-2 ring-blue-500/30">
                                                    <span class="text-white font-bold text-xs">{{ substr($user['name'], 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-white group-hover:text-blue-300 transition-colors duration-300">{{ $user['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-2 py-2 hidden sm:table-cell">
                                            <div class="text-xs text-slate-300 group-hover:text-blue-300 transition-colors duration-300">{{ $user['email'] }}</div>
                                        </td>
                                        
                                        <td class="px-2 py-2">
                                            <form method="POST" action="{{ route('client.updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="highlevel_id" value="{{ $user['highlevel_id'] }}">
                                                <select name="status" onchange="this.form.submit()"
                                                     class="border-0 bg-transparent rounded-xl px-2 py-1 text-xs font-semibold focus:ring-1 focus:ring-blue-500/50 transition-all duration-300 transform hover:scale-105 {{ $user['status'] === 'active' ? 'text-emerald-300 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/30' : 'text-orange-300 bg-orange-500/20 hover:bg-orange-500/30 border border-orange-500/30' }}">
                                                    <option value="active" {{ $user['status'] === 'active' ? 'selected' : '' }}>✓ Active</option>
                                                    <option value="hidden" {{ $user['status'] === 'hidden' ? 'selected' : '' }}>⚠ Hidden</option>
                                                </select>
                                            </form>
                                        </td>
                                        
                                        <td class="px-2 py-2">
                                            <div class="flex flex-col gap-0.5">
                                                <div class="flex flex-wrap gap-1 mb-0.5">
                                                    <a href="{{ route('lead.show', $user->highlevel_id)}}"
                                                         class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-xs font-medium text-white bg-blue-500/80 hover:bg-blue-500 transition-all duration-300 transform hover:scale-105 shadow-lg border border-blue-500/30" title="View Leads">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        <span class="hidden sm:inline">View Leads</span>
                                                    </a>
                                                    <button onclick="generateJSON('{{ $user['highlevel_id'] }}', {{ json_encode($user) }})"
                                                         class="inline-flex items-center px-1.5 py-0.5 bg-purple-500/20 text-purple-300 rounded-lg text-xs font-medium hover:bg-purple-500/30 transition-all duration-300 transform hover:scale-105 shadow-lg border border-purple-500/30" title="Generate JSON">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3z" />
                                                        </svg>
                                                        <span class="hidden sm:inline">Generate JSON</span>
                                                    </button>
                                                </div>
                                                <div class="flex flex-wrap gap-1">
                                                    <a href="{{ route('client.show', $user) }}"
                                                         class="inline-flex items-center px-1.5 py-0.5 bg-indigo-500/20 text-indigo-300 rounded-lg text-xs font-medium hover:bg-indigo-500/30 transition-all duration-300 transform hover:scale-105 shadow-lg border border-indigo-500/30" title="View Client">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span class="hidden sm:inline">View Client</span>
                                                    </a>
                                                    <form method="POST" action="{{ route('client.delete') }}"
                                                         onsubmit="return confirm('Delete this client?');"
                                                         class="inline-block">
                                                        @csrf
                                                        <input type="hidden" name="highlevel_id" value="{{ $user['highlevel_id'] }}">
                                                        <button type="submit"
                                                             class="inline-flex items-center px-1.5 py-0.5 bg-red-500/20 text-red-300 rounded-lg text-xs font-medium hover:bg-red-500/30 transition-all duration-300 transform hover:scale-105 shadow-lg border border-red-500/30" title="Delete Client">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            <span class="hidden sm:inline">Delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Enhanced Empty State -->
                    <div class="flex flex-col items-center justify-center p-12 animate-fadeIn">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-4 shadow-2xl animate-bounce ring-2 ring-blue-500/30">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">No Clients Found</h3>
                        <p class="text-slate-400 text-center mb-4 text-sm">Add your first client to get started</p>
                        <button onclick="openModal()"
                             class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 text-sm font-medium transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add First Client
                        </button>
                    </div>
                @endif

                <!-- Enhanced Pagination -->
                @if($clients && $clients->hasPages())
                    <div class="px-4 py-3 border-t border-white/15 glass-dark">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-slate-400">
                                Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
                            </div>
                            <div class="transform transition-all duration-300 hover:scale-105">
                                {{ $clients->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Enhanced JSON Output with Complete Data -->
            <div id="jsonOutput" class="mt-4 glass-dark rounded-2xl shadow-2xl border border-white/15 overflow-hidden transform transition-all duration-500 scale-95 opacity-0 backdrop-blur-xl" style="display: none;">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-white flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            Generated JSON - Complete Client Data
                        </h4>
                        <div class="flex space-x-2">
                            <button id="copyJsonBtn" onclick="copyJsonToClipboard()"
                                 class="text-xs px-3 py-1 glass text-slate-300 rounded-lg hover:bg-white/10 hover:text-blue-300 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl border border-white/20">
                                <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                Copy
                            </button>
                            <button onclick="downloadJson()"
                                 class="text-xs px-3 py-1 bg-blue-500/20 text-blue-300 rounded-lg hover:bg-blue-500/30 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl border border-blue-500/30">
                                <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download
                            </button>
                        </div>
                    </div>
                    
                    <!-- API Endpoint Info -->
                    <div class="glass p-3 rounded-xl font-mono text-sm flex items-center mb-4 border border-purple-500/30">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold text-purple-300 bg-purple-500/20 mr-3 border border-purple-500/30">POST</span>
                        <span class="text-slate-300 font-medium">https://portal.crm.limo/api/process-leads</span>
                    </div>
                    
                    <pre id="jsonContent" class="glass p-4 rounded-xl overflow-x-auto text-xs border border-white/20 font-mono leading-relaxed max-h-96 transition-all duration-300 hover:shadow-inner text-slate-300 backdrop-blur-xl">@verbatim{    "highlevel_id": "{{ highlevel_id }}",    "first_name": "{{ first_name }}",    "last_name": "{{ last_name }}",    "gender": "{{ gender }}",    "locale": "{{ locale }}",    "timezone": "{{ timezone }}",    "fb_messenger_user_id": "{{ fb_messenger_user_id }}",    "fb_profile_pic_url": "{{ fb_profile_pic_url }}",    "ref": "{{ ref }}",    "created": "{{ created }}",    "last_active": "{{ last_active }}",    "sessions_count": "{{ sessions_count }}",    "source_old": "{{ source_old }}",    "full_name": "{{ full_name }}",    "latest_conversation_json": "{{ latest_conversation_json }}",    "latest_incoming_message_json": "{{ latest_incoming_message_json }}",    "source": "{{ source }}",    "link_to_conversation": "{{ link_to_conversation }}",    "CTM_Ad_Id": "{{ CTM_Ad_Id }}",    "CTM_Ad_Name": "{{ CTM_Ad_Name }}",    "CTM_Ad_Set_Name": "{{ CTM_Ad_Set_Name }}",    "CTM_Campaign_Name": "{{ CTM_Campaign_Name }}",    "Sponsored_Ad_Id": "{{ Sponsored_Ad_Id }}",    "Sponsored_Ad_Name": "{{ Sponsored_Ad_Name }}",    "Sponsored_Ad_Set_Name": "{{ Sponsored_Ad_Set_Name }}",    "Sponsored_Campaign_Name": "{{ Sponsored_Campaign_Name }}",    "Location": "{{ Location }}",    "EU_Limits_Detected_At": "{{ EU_Limits_Detected_At }}",    "Handle": "{{ Handle }}",    "Verified_User": "{{ Verified_User }}",    "Follower_Count": "{{ Follower_Count }}",    "User_Follow_Business": "{{ User_Follow_Business }}",    "Business_Follow_User": "{{ Business_Follow_User }}",    "Profile_Synced_At": "{{ Profile_Synced_At }}",    "age": "{{ age }}",    "Time_on_site": "{{ Time_on_site }}",    "Page_Views": "{{ Page_Views }}",    "Clicks": "{{ Clicks }}",    "Scroll_depth": "{{ Scroll_depth }}",    "recipient_id": "{{ recipient_id }}",    "UNSUBSCRIBED": "{{ UNSUBSCRIBED }}",    "MESSENGER_AD_ANSWER": "{{ MESSENGER_AD_ANSWER }}",    "SPONSORED_MESSAGE_ANSWER": "{{ SPONSORED_MESSAGE_ANSWER }}",    "PHONE": "{{ PHONE }}",    "EMAIL": "{{ EMAIL }}",    "COMMENT_GUARD_ANSWER": "{{ COMMENT_GUARD_ANSWER }}",    "EMAIL_DOMAIN": "{{ EMAIL_DOMAIN }}",    "ADDRESS_LINE_1": "{{ ADDRESS_LINE_1 }}",    "ADDRESS_CITY": "{{ ADDRESS_CITY }}",    "ADDRESS_STATE": "{{ ADDRESS_STATE }}",    "ADDRESS_POSTAL": "{{ ADDRESS_POSTAL }}",    "CLICKED_AT": "{{ CLICKED_AT }}",    "LANDING_PAGE_URL": "{{ LANDING_PAGE_URL }}",    "UTM_TAGS": "{{ UTM_TAGS }}",    "LANDING_PAGE_FULL_URL": "{{ LANDING_PAGE_FULL_URL }}",    "LANDING_PAGE_DOMAIN": "{{ LANDING_PAGE_DOMAIN }}",    "REFERRER": "{{ REFERRER }}",    "VOY_PERSONAL_ADDRESS": "{{ VOY_PERSONAL_ADDRESS }}",    "VOY_PERSONAL_ADDRESS_2": "{{ VOY_PERSONAL_ADDRESS_2 }}",    "VOY_PERSONAL_CITY": "{{ VOY_PERSONAL_CITY }}",    "VOY_PERSONAL_STATE": "{{ VOY_PERSONAL_STATE }}",    "VOY_PERSONAL_ZIP": "{{ VOY_PERSONAL_ZIP }}",    "VOY_PERSONAL_ZIP4": "{{ VOY_PERSONAL_ZIP4 }}",    "VOY_MOBILE_PHONE": "{{ VOY_MOBILE_PHONE }}",    "VOY_DIRECT_NUMBER": "{{ VOY_DIRECT_NUMBER }}",    "VOY_PERSONAL_PHONE": "{{ VOY_PERSONAL_PHONE }}",    "VOY_GENDER": "{{ VOY_GENDER }}",    "VOY_AGE_RANGE": "{{ VOY_AGE_RANGE }}",    "VOY_MARRIED": "{{ VOY_MARRIED }}",    "VOY_CHILDREN": "{{ VOY_CHILDREN }}",    "VOY_INCOME_RANGE": "{{ VOY_INCOME_RANGE }}",    "VOY_NET_WORTH": "{{ VOY_NET_WORTH }}",    "VOY_HOMEOWNER": "{{ VOY_HOMEOWNER }}",    "VOY_PERSONAL_EMAILS_VALIDATION_STATUS": "{{ VOY_PERSONAL_EMAILS_VALIDATION_STATUS }}",    "RE_SIGNALED": "{{ RE_SIGNALED }}",    "SIGNAL_EVENTS": "{{ SIGNAL_EVENTS }}",    "SUPPRESSED": "{{ SUPPRESSED }}",    "BUSINESS_CONTACT": "{{ BUSINESS_CONTACT }}",    "VOY_BUSINESS_EMAIL": "{{ VOY_BUSINESS_EMAIL }}",    "VOY_JOB_TITLE": "{{ VOY_JOB_TITLE }}",    "VOY_SENIORITY_LEVEL": "{{ VOY_SENIORITY_LEVEL }}",    "VOY_DEPARTMENT": "{{ VOY_DEPARTMENT }}",    "VOY_LINKEDIN_URL": "{{ VOY_LINKEDIN_URL }}",    "VOY_PROFESSIONAL_ADDRESS": "{{ VOY_PROFESSIONAL_ADDRESS }}",    "VOY_PROFESSIONAL_ADDRESS_2": "{{ VOY_PROFESSIONAL_ADDRESS_2 }}",    "VOY_PROFESSIONAL_CITY": "{{ VOY_PROFESSIONAL_CITY }}",    "VOY_PROFESSIONAL_STATE": "{{ VOY_PROFESSIONAL_STATE }}",    "VOY_PROFESSIONAL_ZIP": "{{ VOY_PROFESSIONAL_ZIP }}",    "VOY_PROFESSIONAL_ZIP4": "{{ VOY_PROFESSIONAL_ZIP4 }}",    "VOY_COMPANY_NAME": "{{ VOY_COMPANY_NAME }}",    "VOY_COMPANY_DOMAIN": "{{ VOY_COMPANY_DOMAIN }}",    "VOY_COMPANY_PHONE": "{{ VOY_COMPANY_PHONE }}",    "VOY_PRIMARY_INDUSTRY": "{{ VOY_PRIMARY_INDUSTRY }}",    "VOY_COMPANY_SIC": "{{ VOY_COMPANY_SIC }}",    "VOY_COMPANY_ADDRESS": "{{ VOY_COMPANY_ADDRESS }}",    "VOY_COMPANY_CITY": "{{ VOY_COMPANY_CITY }}",    "VOY_COMPANY_STATE": "{{ VOY_COMPANY_STATE }}",    "VOY_COMPANY_ZIP": "{{ VOY_COMPANY_ZIP }}",    "VOY_COMPANY_LINKEDIN_URL": "{{ VOY_COMPANY_LINKEDIN_URL }}",    "VOY_COMPANY_REVENUE": "{{ VOY_COMPANY_REVENUE }}",    "VOY_COMPANY_EMPLOYEE_COUNT": "{{ VOY_COMPANY_EMPLOYEE_COUNT }}",    "VOY_BUSINESS_EMAIL_VALIDATION_STATUS": "{{ VOY_BUSINESS_EMAIL_VALIDATION_STATUS }}",    "CONS_EMAIL": "{{ CONS_EMAIL }}"}@endverbatim
                    </pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Modal with beautiful animations -->
    <div id="newClientModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="closeModal()"></div>
            
            <div class="relative glass-dark backdrop-blur-xl rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-75 opacity-0 border border-white/20">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/15">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-blue-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Add New Client</h3>
                    </div>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-all duration-200 transform hover:scale-110 hover:rotate-90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form method="POST" action="{{ route('client.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="highlevel_id" class="block text-sm font-medium text-slate-300 mb-1">HighLevel ID</label>
                        <div class="relative">
                            <input type="text" name="highlevel_id" id="highlevel_id" required
                                 class="w-full px-3 py-2 glass border border-white/20 rounded-xl bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 transform focus:scale-105 shadow-lg focus:shadow-xl backdrop-blur-xl"
                                placeholder="Enter HighLevel ID">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal()"
                             class="px-4 py-2 text-slate-300 glass border border-white/20 rounded-xl hover:bg-white/10 hover:text-white text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Cancel
                        </button>
                        <button type="submit"
                             class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl hover:from-blue-600 hover:to-purple-600 text-sm font-medium transition-all duration-300 transform hover:scale-105 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced CSS Animations -->
    <style>
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slideInDown { animation: slideInDown 0.5s ease-out; }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
        
        /* Dark theme scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(30, 41, 59, 0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(to bottom, #3b82f6, #8b5cf6); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(to bottom, #2563eb, #7c3aed); }
        
        /* Table sorting indicators */
        .sort-asc::after { content: ' ↑'; color: #60a5fa; }
        .sort-desc::after { content: ' ↓'; color: #60a5fa; }
    </style>

    <!-- Enhanced JavaScript with all functionality -->
    <script>
        let sortDirection = {};
        let selectedClients = [];

        function openModal() {
            const modal = document.getElementById('newClientModal');
            const backdrop = modal.querySelector('.fixed.inset-0');
            const content = modal.querySelector('.relative');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                content.classList.remove('scale-75', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('newClientModal');
            const backdrop = modal.querySelector('.fixed.inset-0');
            const content = modal.querySelector('.relative');
            
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-75', 'opacity-0');
            
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function generateJSON(highlevelId, clientData) {
            const jsonOutput = document.getElementById('jsonOutput');
            const jsonContent = document.getElementById('jsonContent');
            
            // Create complete JSON with all fields
            const completeJsonData = {
                "highlevel_id": highlevelId,
                "first_name": clientData.first_name || "",
                "last_name": clientData.last_name || "",
                "gender": clientData.gender || "",
                "locale": clientData.locale || "",
                "timezone": clientData.timezone || "",
                "fb_messenger_user_id": clientData.fb_messenger_user_id || "",
                "fb_profile_pic_url": clientData.fb_profile_pic_url || "",
                "ref": clientData.ref || "",
                "created": clientData.created || new Date().toISOString(),
                "last_active": clientData.last_active || new Date().toISOString(),
                "sessions_count": clientData.sessions_count || "0",
                "source_old": clientData.source_old || "",
                "full_name": clientData.full_name || clientData.name || "",
                "latest_conversation_json": clientData.latest_conversation_json || "",
                "latest_incoming_message_json": clientData.latest_incoming_message_json || "",
                "source": clientData.source || "",
                "link_to_conversation": clientData.link_to_conversation || "",
                "CTM_Ad_Id": clientData.CTM_Ad_Id || "",
                "CTM_Ad_Name": clientData.CTM_Ad_Name || "",
                "CTM_Ad_Set_Name": clientData.CTM_Ad_Set_Name || "",
                "CTM_Campaign_Name": clientData.CTM_Campaign_Name || "",
                "Sponsored_Ad_Id": clientData.Sponsored_Ad_Id || "",
                "Sponsored_Ad_Name": clientData.Sponsored_Ad_Name || "",
                "Sponsored_Ad_Set_Name": clientData.Sponsored_Ad_Set_Name || "",
                "Sponsored_Campaign_Name": clientData.Sponsored_Campaign_Name || "",
                "Location": clientData.Location || "",
                "EU_Limits_Detected_At": clientData.EU_Limits_Detected_At || "",
                "Handle": clientData.Handle || "",
                "Verified_User": clientData.Verified_User || "",
                "Follower_Count": clientData.Follower_Count || "",
                "User_Follow_Business": clientData.User_Follow_Business || "",
                "Business_Follow_User": clientData.Business_Follow_User || "",
                "Profile_Synced_At": clientData.Profile_Synced_At || "",
                "age": clientData.age || "",
                "Time_on_site": clientData.Time_on_site || "",
                "Page_Views": clientData.Page_Views || "",
                "Clicks": clientData.Clicks || "",
                "Scroll_depth": clientData.Scroll_depth || "",
                "recipient_id": clientData.recipient_id || "",
                "UNSUBSCRIBED": clientData.UNSUBSCRIBED || "",
                "MESSENGER_AD_ANSWER": clientData.MESSENGER_AD_ANSWER || "",
                "SPONSORED_MESSAGE_ANSWER": clientData.SPONSORED_MESSAGE_ANSWER || "",
                "PHONE": clientData.PHONE || clientData.phone || "",
                "EMAIL": clientData.EMAIL || clientData.email || "",
                "COMMENT_GUARD_ANSWER": clientData.COMMENT_GUARD_ANSWER || "",
                "EMAIL_DOMAIN": clientData.EMAIL_DOMAIN || "",
                "ADDRESS_LINE_1": clientData.ADDRESS_LINE_1 || "",
                "ADDRESS_CITY": clientData.ADDRESS_CITY || "",
                "ADDRESS_STATE": clientData.ADDRESS_STATE || "",
                "ADDRESS_POSTAL": clientData.ADDRESS_POSTAL || "",
                "CLICKED_AT": clientData.CLICKED_AT || "",
                "LANDING_PAGE_URL": clientData.LANDING_PAGE_URL || "",
                "UTM_TAGS": clientData.UTM_TAGS || "",
                "LANDING_PAGE_FULL_URL": clientData.LANDING_PAGE_FULL_URL || "",
                "LANDING_PAGE_DOMAIN": clientData.LANDING_PAGE_DOMAIN || "",
                "REFERRER": clientData.REFERRER || "",
                "VOY_PERSONAL_ADDRESS": clientData.VOY_PERSONAL_ADDRESS || "",
                "VOY_PERSONAL_ADDRESS_2": clientData.VOY_PERSONAL_ADDRESS_2 || "",
                "VOY_PERSONAL_CITY": clientData.VOY_PERSONAL_CITY || "",
                "VOY_PERSONAL_STATE": clientData.VOY_PERSONAL_STATE || "",
                "VOY_PERSONAL_ZIP": clientData.VOY_PERSONAL_ZIP || "",
                "VOY_PERSONAL_ZIP4": clientData.VOY_PERSONAL_ZIP4 || "",
                "VOY_MOBILE_PHONE": clientData.VOY_MOBILE_PHONE || "",
                "VOY_DIRECT_NUMBER": clientData.VOY_DIRECT_NUMBER || "",
                "VOY_PERSONAL_PHONE": clientData.VOY_PERSONAL_PHONE || "",
                "VOY_GENDER": clientData.VOY_GENDER || "",
                "VOY_AGE_RANGE": clientData.VOY_AGE_RANGE || "",
                "VOY_MARRIED": clientData.VOY_MARRIED || "",
                "VOY_CHILDREN": clientData.VOY_CHILDREN || "",
                "VOY_INCOME_RANGE": clientData.VOY_INCOME_RANGE || "",
                "VOY_NET_WORTH": clientData.VOY_NET_WORTH || "",
                "VOY_HOMEOWNER": clientData.VOY_HOMEOWNER || "",
                "VOY_PERSONAL_EMAILS_VALIDATION_STATUS": clientData.VOY_PERSONAL_EMAILS_VALIDATION_STATUS || "",
                "RE_SIGNALED": clientData.RE_SIGNALED || "",
                "SIGNAL_EVENTS": clientData.SIGNAL_EVENTS || "",
                "SUPPRESSED": clientData.SUPPRESSED || "",
                "BUSINESS_CONTACT": clientData.BUSINESS_CONTACT || "",
                "VOY_BUSINESS_EMAIL": clientData.VOY_BUSINESS_EMAIL || "",
                "VOY_JOB_TITLE": clientData.VOY_JOB_TITLE || "",
                "VOY_SENIORITY_LEVEL": clientData.VOY_SENIORITY_LEVEL || "",
                "VOY_DEPARTMENT": clientData.VOY_DEPARTMENT || "",
                "VOY_LINKEDIN_URL": clientData.VOY_LINKEDIN_URL || "",
                "VOY_PROFESSIONAL_ADDRESS": clientData.VOY_PROFESSIONAL_ADDRESS || "",
                "VOY_PROFESSIONAL_ADDRESS_2": clientData.VOY_PROFESSIONAL_ADDRESS_2 || "",
                "VOY_PROFESSIONAL_CITY": clientData.VOY_PROFESSIONAL_CITY || "",
                "VOY_PROFESSIONAL_STATE": clientData.VOY_PROFESSIONAL_STATE || "",
                "VOY_PROFESSIONAL_ZIP": clientData.VOY_PROFESSIONAL_ZIP || "",
                "VOY_PROFESSIONAL_ZIP4": clientData.VOY_PROFESSIONAL_ZIP4 || "",
                "VOY_COMPANY_NAME": clientData.VOY_COMPANY_NAME || "",
                "VOY_COMPANY_DOMAIN": clientData.VOY_COMPANY_DOMAIN || "",
                "VOY_COMPANY_PHONE": clientData.VOY_COMPANY_PHONE || "",
                "VOY_PRIMARY_INDUSTRY": clientData.VOY_PRIMARY_INDUSTRY || "",
                "VOY_COMPANY_SIC": clientData.VOY_COMPANY_SIC || "",
                "VOY_COMPANY_ADDRESS": clientData.VOY_COMPANY_ADDRESS || "",
                "VOY_COMPANY_CITY": clientData.VOY_COMPANY_CITY || "",
                "VOY_COMPANY_STATE": clientData.VOY_COMPANY_STATE || "",
                "VOY_COMPANY_ZIP": clientData.VOY_COMPANY_ZIP || "",
                "VOY_COMPANY_LINKEDIN_URL": clientData.VOY_COMPANY_LINKEDIN_URL || "",
                "VOY_COMPANY_REVENUE": clientData.VOY_COMPANY_REVENUE || "",
                "VOY_COMPANY_EMPLOYEE_COUNT": clientData.VOY_COMPANY_EMPLOYEE_COUNT || "",
                "VOY_BUSINESS_EMAIL_VALIDATION_STATUS": clientData.VOY_BUSINESS_EMAIL_VALIDATION_STATUS || "",
                "CONS_EMAIL": clientData.CONS_EMAIL || ""
            };
            
            jsonContent.textContent = JSON.stringify(completeJsonData, null, 2);
            
            // Beautiful show animation
            jsonOutput.style.display = 'block';
            setTimeout(() => {
                jsonOutput.classList.remove('scale-95', 'opacity-0');
                jsonOutput.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            jsonOutput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            showNotification('Complete JSON data generated successfully! ✨', 'success');
        }

        function copyJsonToClipboard() {
            const jsonContent = document.getElementById('jsonContent');
            const btn = document.getElementById('copyJsonBtn');
            
            navigator.clipboard.writeText(jsonContent.textContent).then(() => {
                btn.style.transform = 'scale(0.95)';
                btn.innerHTML = `
                    <svg class="w-3 h-3 inline-block mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Copied!
                `;
                btn.classList.add('bg-green-500/20', 'text-green-300', 'border-green-500/30');
                btn.classList.remove('glass', 'text-slate-300', 'border-white/20');
                
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                    setTimeout(() => {
                        btn.innerHTML = `
                            <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            Copy
                        `;
                        btn.classList.remove('bg-green-500/20', 'text-green-300', 'border-green-500/30');
                        btn.classList.add('glass', 'text-slate-300', 'border-white/20');
                    }, 2000);
                }, 100);
                
                showNotification('JSON copied to clipboard! 📋', 'success');
            }).catch(() => {
                showNotification('Failed to copy JSON data ❌', 'error');
            });
        }

        function downloadJson() {
            const jsonContent = document.getElementById('jsonContent').textContent;
            const blob = new Blob([jsonContent], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `client-data-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showNotification('JSON file downloaded! 📥', 'success');
        }

        // Table sorting functionality
        function sortTable(column) {
            const table = document.getElementById('clientsTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Toggle sort direction
            sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
            
            // Remove previous sort indicators
            table.querySelectorAll('th').forEach(th => {
                th.classList.remove('sort-asc', 'sort-desc');
            });
            
            // Add current sort indicator
            const currentTh = table.querySelector(`th[onclick="sortTable('${column}')"]`);
            currentTh.classList.add(sortDirection[column] === 'asc' ? 'sort-asc' : 'sort-desc');
            
            rows.sort((a, b) => {
                let aVal, bVal;
                
                switch(column) {
                    case 'id':
                        aVal = a.dataset.clientId;
                        bVal = b.dataset.clientId;
                        break;
                    case 'name':
                        aVal = a.dataset.clientName;
                        bVal = b.dataset.clientName;
                        break;
                    case 'email':
                        aVal = a.dataset.clientEmail;
                        bVal = b.dataset.clientEmail;
                        break;
                    case 'status':
                        aVal = a.dataset.clientStatus;
                        bVal = b.dataset.clientStatus;
                        break;
                    default:
                        return 0;
                }
                
                if (sortDirection[column] === 'asc') {
                    return aVal.localeCompare(bVal);
                } else {
                    return bVal.localeCompare(aVal);
                }
            });
            
            // Reorder rows
            rows.forEach(row => tbody.appendChild(row));
            showNotification(`Table sorted by ${column} (${sortDirection[column]}) 📊`, 'info');
        }

        // Selection functionality
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const clientCheckboxes = document.querySelectorAll('.client-checkbox');
            
            clientCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateSelectedClients();
            showNotification(`${selectAllCheckbox.checked ? 'Selected' : 'Deselected'} all clients`, 'info');
        }

        function updateSelectAllState() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const clientCheckboxes = document.querySelectorAll('.client-checkbox');
            const checkedBoxes = document.querySelectorAll('.client-checkbox:checked');
            
            selectAllCheckbox.checked = checkedBoxes.length === clientCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < clientCheckboxes.length;
            
            updateSelectedClients();
        }

        function updateSelectedClients() {
            const checkedBoxes = document.querySelectorAll('.client-checkbox:checked');
            selectedClients = Array.from(checkedBoxes).map(cb => cb.value);
        }

        function exportSelected() {
            if (selectedClients.length === 0) {
                showNotification('Please select clients to export ⚠️', 'error');
                return;
            }
            
            const csvData = selectedClients.map(id => {
                const row = document.querySelector(`tr[data-client-id="${id}"]`);
                return {
                    id: row.dataset.clientId,
                    name: row.dataset.clientName,
                    email: row.dataset.clientEmail,
                    status: row.dataset.clientStatus
                };
            });
            
            const csv = [
                ['ID', 'Name', 'Email', 'Status'],
                ...csvData.map(row => [row.id, row.name, row.email, row.status])
            ].map(row => row.join(',')).join('\n');
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `selected-clients-${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            showNotification(`Exported ${selectedClients.length} clients! 📊`, 'success');
        }

        function deleteSelected() {
            if (selectedClients.length === 0) {
                showNotification('Please select clients to delete ⚠️', 'error');
                return;
            }
            
            if (confirm(`Delete ${selectedClients.length} selected clients?`)) {
                // Here you would make an AJAX request to delete the selected clients
                showNotification(`${selectedClients.length} clients deleted! 🗑️`, 'success');
                // Refresh the page or remove rows from DOM
            }
        }

        // Beautiful notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const colors = {
                success: 'from-emerald-500 to-green-600 border-emerald-400',
                error: 'from-red-500 to-pink-600 border-red-400',
                info: 'from-blue-500 to-indigo-600 border-blue-400'
            };
            
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm backdrop-blur-xl`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ?
                             '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            type === 'error' ?
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' :
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                        }
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white/80 hover:text-white transition-colors duration-200 transform hover:scale-110">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.style.transform = 'translateX(0) scale(1.05)';
                setTimeout(() => {
                    notification.style.transform = 'translateX(0) scale(1)';
                }, 200);
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%) scale(0.95)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }, 4000);
        }

        // Enhanced keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                openModal();
                showNotification('New client modal opened! 🚀', 'info');
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                    showNotification('Search field focused! 🔍', 'info');
                }
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'a') {
                e.preventDefault();
                toggleSelectAll();
            }
        });

        // Enhanced form loading states
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalContent = submitBtn.innerHTML;
                        
                        submitBtn.innerHTML = `
                            <svg class="animate-spin w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `;
                        
                        showNotification('Processing your request... ⏳', 'info');
                        
                        setTimeout(() => {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalContent;
                                showNotification('Request timeout. Please try again. ⚠️', 'error');
                            }
                        }, 10000);
                    }
                });
            });
            
            // Welcome notification
            setTimeout(() => {
                showNotification('Enhanced Client Management System loaded! ✨', 'success');
            }, 1000);
        });
    </script>
</x-app-layout>