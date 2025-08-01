<div x-data="{
    open: true,
    mobileOpen: false,
    activeSection: '{{ request()->route()->getName() }}',
    toggleSidebar() { this.open = !this.open },
    toggleMobile() { this.mobileOpen = !this.mobileOpen },
    todoDropdown: {{ in_array(request()->route()->getName(), ['board.index', 'board.all']) ? 'true' : 'false' }},
    generateDropdown: {{ in_array(request()->route()->getName(), ['imagesUser.index', 'generate.index']) ? 'true' : 'false' }}
}" class="relative">
    <!-- Mobile Menu Trigger - Más compacto -->
    <div class="fixed top-4 left-4 z-50 md:hidden">
        <button @click="toggleMobile"
            class="flex h-10 w-10 items-center justify-center rounded-xl glass text-white shadow-lg transition-all duration-300 hover:scale-105 focus:outline-none"
            aria-label="Toggle Menu">
            <div class="relative w-5 h-5">
                <span :class="mobileOpen ? 'rotate-45 translate-y-2 bg-blue-400' : 'bg-white'"
                    class="absolute top-0 left-0 w-5 h-0.5 rounded-full transition-all duration-300 transform origin-center"></span>
                <span :class="mobileOpen ? 'opacity-0 scale-0' : 'opacity-100 scale-100 bg-white'"
                    class="absolute top-2 left-0 w-5 h-0.5 rounded-full transition-all duration-300"></span>
                <span :class="mobileOpen ? '-rotate-45 -translate-y-2 bg-blue-400' : 'bg-white'"
                    class="absolute top-4 left-0 w-5 h-0.5 rounded-full transition-all duration-300 transform origin-center"></span>
            </div>
        </button>
    </div>

    <!-- Sidebar más compacto y profesional -->
    <div :class="{
        'translate-x-0': mobileOpen,
        '-translate-x-full md:translate-x-0': !mobileOpen,
        'w-64': open,
        'w-16': !open
    }"
        class="fixed left-0 top-0 z-40 h-screen glass-dark transition-all duration-300 ease-in-out shadow-xl border-r border-white/15 backdrop-blur-xl">
        
        <!-- Sidebar Header más compacto -->
        <div class="flex h-16 items-center justify-between px-4 border-b border-white/15">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white transition-all duration-300 hover:scale-105 shadow-md">
                    <span class="font-bold text-sm">239</span>
                </div>
                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                    x-transition:enter-end="opacity-100 transform translate-x-0" 
                    class="text-lg font-semibold text-white">
                    239 <span class="text-blue-400">WEB</span>
                </span>
            </a>
            <button @click="toggleSidebar"
                class="hidden md:flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-white/10 hover:text-blue-400 transition-all duration-300 focus:outline-none"
                aria-label="Toggle Sidebar">
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Content más compacto -->
        <div class="flex flex-col h-[calc(100vh-8rem)] overflow-y-auto py-4 px-3 beautiful-scrollbar">
            <nav class="flex-grow space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'dashboard' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'dashboard'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Dashboard') }}</span>
                    <!-- Tooltip para sidebar cerrado -->
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Dashboard') }}
                    </div>
                    <!-- Indicador activo más pequeño -->
                    <span x-show="open && activeSection === 'dashboard'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- Manage Clients -->
                <a href="{{ route('client.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'client.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'client.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Clients') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Clients') }}
                    </div>
                    <span x-show="open && activeSection === 'client.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- Manage Users -->
                @role('Admin')
                <a href="{{ route('users.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'users.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'users.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Users') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Users') }}
                    </div>
                    <span x-show="open && activeSection === 'users.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>
                @endrole

                <!-- Blog -->
                <a href="{{ route('blog.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'blog.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'blog.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Blog') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Blog') }}
                    </div>
                    <span x-show="open && activeSection === 'blog.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- Citations -->
                @role('Admin')
                <a href="{{ route('citations.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'citations.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'citations.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Citations') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Citations') }}
                    </div>
                    <span x-show="open && activeSection === 'citations.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>
                @endrole

                <!-- Chat -->
                <a href="{{ route('chat.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'chat.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'chat.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-1M5 8h2m0 0V6a2 2 0 012-2h6a2 2 0 012 2v2m-8 0h8" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Chat') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Chat') }}
                    </div>
                    <span x-show="open && activeSection === 'chat.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- Indexer -->
                <a href="{{ route('indexer.index') }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'indexer.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'indexer.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Search') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Search') }}
                    </div>
                    <span x-show="open && activeSection === 'indexer.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- Google Ads -->
                <a href="{{ route('google.index',1) }}"
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative"
                    :class="activeSection === 'google.index' ? 
                        'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                        'text-slate-300 hover:bg-white/10 hover:text-blue-300'"
                    @click="activeSection = 'google.index'">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="open ? 'mr-3' : 'mx-auto'">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                        </svg>
                    </div>
                    <span x-show="open" class="font-medium truncate">{{ __('Google Ads') }}</span>
                    <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        {{ __('Google Ads') }}
                    </div>
                    <span x-show="open && activeSection === 'google.index'"
                        class="ml-auto h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                </a>

                <!-- To-Do List con dropdown compacto -->
                <div class="relative">
                    <button @click="todoDropdown = !todoDropdown"
                        class="group flex w-full items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200"
                        :class="(activeSection === 'board.index' || activeSection === 'board.all') ? 
                            'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                            'text-slate-300 hover:bg-white/10 hover:text-blue-300'">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                            :class="open ? 'mr-3' : 'mx-auto'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <span x-show="open" class="font-medium truncate flex-1 text-left">{{ __('Tasks') }}</span>
                        <svg x-show="open" class="ml-2 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': todoDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                            {{ __('Tasks') }}
                        </div>
                    </button>
                    
                    <!-- Dropdown compacto -->
                    <div x-show="todoDropdown && open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('board.index') }}"
                            class="group flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200"
                            :class="activeSection === 'board.index' ? 
                                'bg-blue-500/20 text-blue-300' : 
                                'text-slate-400 hover:bg-white/10 hover:text-blue-300'"
                            @click="activeSection = 'board.index'">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Client Tasks') }}
                        </a>
                        <a href="{{ route('board.all') }}"
                            class="group flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200"
                            :class="activeSection === 'board.all' ? 
                                'bg-blue-500/20 text-blue-300' : 
                                'text-slate-400 hover:bg-white/10 hover:text-blue-300'"
                            @click="activeSection = 'board.all'">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14-7H3a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2z" />
                            </svg>
                            {{ __('All Tasks') }}
                        </a>
                    </div>
                </div>

                <!-- Generate con dropdown compacto -->
                <div class="relative">
                    <button @click="generateDropdown = !generateDropdown"
                        class="group flex w-full items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200"
                        :class="(activeSection === 'imagesUser.index' || activeSection === 'generate.index') ? 
                            'bg-blue-600/20 text-blue-300 border border-blue-500/30 shadow-lg' : 
                            'text-slate-300 hover:bg-white/10 hover:text-blue-300'">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                            :class="open ? 'mr-3' : 'mx-auto'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span x-show="open" class="font-medium truncate flex-1 text-left">{{ __('Generate') }}</span>
                        <svg x-show="open" class="ml-2 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': generateDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div x-show="!open" class="absolute left-14 bg-slate-800 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                            {{ __('Generate') }}
                        </div>
                    </button>
                    
                    <!-- Dropdown compacto -->
                    <div x-show="generateDropdown && open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('imagesUser.index') }}"
                            class="group flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200"
                            :class="activeSection === 'imagesUser.index' ? 
                                'bg-blue-500/20 text-blue-300' : 
                                'text-slate-400 hover:bg-white/10 hover:text-blue-300'"
                            @click="activeSection = 'imagesUser.index'">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.707-4.707a1 1 0 011.414 0L16 17m-2-5a1 1 0 011.414 0L20 17M6 2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
                            </svg>
                            {{ __('Images') }}
                        </a>
                        <a href="{{ route('generate.index') }}"
                            class="group flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200"
                            :class="activeSection === 'generate.index' ? 
                                'bg-blue-500/20 text-blue-300' : 
                                'text-slate-400 hover:bg-white/10 hover:text-blue-300'"
                            @click="activeSection = 'generate.index'">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 4v10a2 2 0 002 2h6a2 2 0 002-2V8M7 8h10M9 12h6" />
                            </svg>
                            {{ __('Prompts') }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer compacto -->
        <div class="absolute bottom-0 left-0 right-0 border-t border-white/15 glass-dark p-4">
            <div class="flex items-center">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="h-8 w-8 rounded-lg object-cover ring-2 ring-blue-500/30"
                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                        <span class="text-xs font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div x-show="open" class="ml-3 min-w-0 flex-1">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <div class="flex space-x-2 text-xs">
                        <a href="{{ route('profile.show') }}"
                            class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                            {{ __('Profile') }}
                        </a>
                        <span class="text-slate-600">•</span>
                        <form method="POST" action="{{ route('logout') }}" x-data class="inline">
                            @csrf
                            <button type="submit" @click.prevent="$root.submit();"
                                class="text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div x-cloak x-show="mobileOpen" @click="mobileOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm md:hidden"></div>
       
</div>

