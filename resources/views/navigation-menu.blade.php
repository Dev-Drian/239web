<div x-data="{
    open: true,
    mobileOpen: false,
    activeSection: '{{ request()->route()->getName() }}',
    toggleSidebar() { this.open = !this.open },
    toggleMobile() { this.mobileOpen = !this.mobileOpen },
    todoDropdown: {{ in_array(request()->route()->getName(), ['board.index', 'board.all']) ? 'true' : 'false' }}
}" class="relative">
    <!-- Mobile Menu Trigger -->
    <div class="fixed top-4 left-4 z-50 md:hidden">
        <button @click="toggleMobile"
            class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-indigo-600 shadow-lg transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none"
            aria-label="Toggle Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <div :class="{
        'translate-x-0': mobileOpen,
        '-translate-x-full md:translate-x-0': !mobileOpen,
        'w-72': open,
        'w-20': !open
    }"
        class="fixed left-0 top-0 z-40 h-screen bg-white transition-all duration-300 ease-in-out shadow-xl">
        <!-- Sidebar Header -->
        <div class="flex h-20 items-center justify-between px-5 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-white transition-all duration-300 hover:bg-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100" class="text-xl font-bold text-gray-800">
                    SEO Tool
                </span>
            </a>
            <button @click="toggleSidebar"
                class="hidden md:flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-indigo-600 transition-all duration-300 focus:outline-none"
                aria-label="Toggle Sidebar">
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="flex flex-col h-[calc(100vh-10rem)] overflow-y-auto py-6 px-4">
            <nav class="flex-grow">
                <div x-show="open" class="mb-4 px-2">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Main Navigation</h3>
                </div>

                <ul class="space-y-1.5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'dashboard' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'dashboard'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'dashboard' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Dashboard') }}
                            </span>

                            <span x-show="open && activeSection === 'dashboard'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>

                    <!-- Manage Client -->
                    <li>
                        <a href="{{ route('client.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'client.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'client.index'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'client.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Manage Clients') }}
                            </span>

                            <span x-show="open && activeSection === 'client.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>

                    <!-- Manage Users -->
                    @role('Admin')
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                                :class="activeSection === 'users.index' ? 'bg-indigo-50 text-indigo-700' :
                                    'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                                @click="activeSection = 'users.index'">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                    :class="activeSection === 'users.index' ? 'bg-indigo-100 text-indigo-600' :
                                        'text-gray-500 group-hover:text-indigo-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    class="ml-3 font-medium whitespace-nowrap">
                                    {{ __('Manage Users') }}
                                </span>

                                <span x-show="open && activeSection === 'users.index'"
                                    class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                            </a>
                        </li>
                    @endrole

                    <!-- Blogs -->
                    <li>
                        <a href="{{ route('blog.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'blog.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'blog.index'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'blog.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Blogs') }}
                            </span>

                            <span x-show="open && activeSection === 'blog.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('imagesUser.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'imagesUser.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'imagesUser.index'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'imagesUser.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4-4a3 3 0 014 0l4 4M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 16V6a2 2 0 012-2h12a2 2 0 012 2v10" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Images') }}
                            </span>

                            <span x-show="open && activeSection === 'imagesUser.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li> --}}

                    <!-- Citations -->

                    @role('Admin')
                        <li>
                            <a href="{{ route('citations.index') }}"
                                class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                                :class="activeSection === 'citations.index' ? 'bg-indigo-50 text-indigo-700' :
                                    'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                                @click="activeSection = 'citations.index'">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                    :class="activeSection === 'citations.index' ? 'bg-indigo-100 text-indigo-600' :
                                        'text-gray-500 group-hover:text-indigo-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    class="ml-3 font-medium whitespace-nowrap">
                                    {{ __('Citations') }}
                                </span>

                                <span x-show="open && activeSection === 'citations.index'"
                                    class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                            </a>
                        </li>
                    @endrole

                    <!-- Chat -->
                    <li>
                        <a href="{{ route('chat.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'chat.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'chat.index'">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md"
                                :class="activeSection === 'chat.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0" class="ml-3 font-medium">
                                {{ __('Chat') }}
                            </span>

                            <span x-show="open && activeSection === 'chat.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>

                    <!-- Indexer -->
                    <li>
                        <a href="{{ route('indexer.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'indexer.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'indexer.index'">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md"
                                :class="activeSection === 'indexer.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0" class="ml-3 font-medium">
                                {{ __('Indexer') }}
                            </span>

                            <span x-show="open && activeSection === 'indexer.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('google.index',1) }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'google.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'google.index'">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md"
                                :class="activeSection === 'google.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0" class="ml-3 font-medium">
                                {{ __('Google Ads') }}
                            </span>

                            <span x-show="open && activeSection === 'google.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li>
                    <!-- To-Do List -->
                    <li>
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <!-- Main menu item -->
                            <button @click="todoDropdown = !todoDropdown"
                                class="group flex w-full items-center rounded-lg px-3 py-3 transition-all duration-300"
                                :class="activeSection === 'board.index' || activeSection === 'board.all' ?
                                    'bg-indigo-50 text-indigo-700' :
                                    'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                    :class="activeSection === 'board.index' || activeSection === 'board.all' ?
                                        'bg-indigo-100 text-indigo-600' :
                                        'text-gray-500 group-hover:text-indigo-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    class="ml-3 font-medium whitespace-nowrap">
                                    {{ __('To-Do List') }}
                                </span>

                                <!-- Only show dropdown arrow when sidebar is open -->
                                <span x-show="open" class="ml-auto">
                                    <svg class="h-4 w-4 transform transition-transform duration-200"
                                        :class="{ 'rotate-180': todoDropdown }" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="todoDropdown" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                :class="[
                                    open ? 'ml-4 mt-1 space-y-1' :
                                    'absolute left-20 top-0 z-50 mt-0 w-48 rounded-md bg-white shadow-lg',
                                    'origin-top-right'
                                ]"
                                @click.away="if(!open) todoDropdown = false">

                                <a href="{{ route('board.index') }}"
                                    class="group flex items-center rounded-lg px-3 py-2 transition-all duration-300 text-sm"
                                    :class="[
                                        activeSection === 'board.index' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                        !open ? 'border-b border-gray-100 shadow-sm' : ''
                                    ]"
                                    @click="activeSection = 'board.index'; if(!open) todoDropdown = false">
                                    <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-md"
                                        :class="activeSection === 'board.index' ? 'bg-indigo-100 text-indigo-600' :
                                            'text-gray-500 group-hover:text-indigo-600'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="ml-3 whitespace-nowrap">{{ __('Client Tasks') }}</span>
                                </a>

                                <a href="{{ route('board.all') }}"
                                    class="group flex items-center rounded-lg px-3 py-2 transition-all duration-300 text-sm"
                                    :class="[
                                        activeSection === 'board.all' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                        !open ? 'shadow-sm' : ''
                                    ]"
                                    @click="activeSection = 'board.all'; if(!open) todoDropdown = false">
                                    <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-md"
                                        :class="activeSection === 'board.all' ? 'bg-indigo-100 text-indigo-600' :
                                            'text-gray-500 group-hover:text-indigo-600'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </div>
                                    <span class="ml-3 whitespace-nowrap">{{ __('View All Tasks') }}</span>
                                </a>
                            </div>
                        </div>
                    </li>

                    <!-- Images -->
                    <li>
                        <div class="relative" x-data="{ generateDropdown: false }">
                            <!-- Main menu item -->
                            <button @click="generateDropdown = !generateDropdown"
                                class="group flex w-full items-center rounded-lg px-3 py-3 transition-all duration-300"
                                :class="activeSection === 'imagesUser.index' || activeSection === 'generate.index' ?
                                    'bg-indigo-50 text-indigo-700' :
                                    'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                    :class="activeSection === 'imagesUser.index' || activeSection === 'generate.index' ?
                                        'bg-indigo-100 text-indigo-600' :
                                        'text-gray-500 group-hover:text-indigo-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4-4a3 3 0 014 0l4 4M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 16V6a2 2 0 012-2h12a2 2 0 012 2v10" />
                                    </svg>
                                </div>
                                <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    class="ml-3 font-medium whitespace-nowrap">
                                    {{ __('Generate') }}
                                </span>

                                <!-- Only show dropdown arrow when sidebar is open -->
                                <span x-show="open" class="ml-auto">
                                    <svg class="h-4 w-4 transform transition-transform duration-200"
                                        :class="{ 'rotate-180': generateDropdown }" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="generateDropdown" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                :class="[
                                    open ? 'ml-4 mt-1 space-y-1' :
                                    'absolute left-20 top-0 z-50 mt-0 w-48 rounded-md bg-white shadow-lg',
                                    'origin-top-right'
                                ]"
                                @click.away="if(!open) generateDropdown = false">

                                <a href="{{ route('imagesUser.index') }}"
                                    class="group flex items-center rounded-lg px-3 py-2 transition-all duration-300 text-sm"
                                    :class="[
                                        activeSection === 'imagesUser.index' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                        !open ? 'border-b border-gray-100 shadow-sm' : ''
                                    ]"
                                    @click="activeSection = 'imagesUser.index'; if(!open) generateDropdown = false">
                                    <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-md"
                                        :class="activeSection === 'imagesUser.index' ? 'bg-indigo-100 text-indigo-600' :
                                            'text-gray-500 group-hover:text-indigo-600'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4-4a3 3 0 014 0l4 4M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 16V6a2 2 0 012-2h12a2 2 0 012 2v10" />
                                        </svg>
                                    </div>
                                    <span class="ml-3 whitespace-nowrap">{{ __('Images') }}</span>
                                </a>

                                <a href="{{ route('generate.index') }}"
                                    class="group flex items-center rounded-lg px-3 py-2 transition-all duration-300 text-sm"
                                    :class="[
                                        activeSection === 'generate.index' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                        !open ? 'shadow-sm' : ''
                                    ]"
                                    @click="activeSection = 'generate.index'; if(!open) generateDropdown = false">
                                    <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-md"
                                        :class="activeSection === 'generate.index' ? 'bg-indigo-100 text-indigo-600' :
                                            'text-gray-500 group-hover:text-indigo-600'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <span class="ml-3 whitespace-nowrap">{{ __('Prompts') }}</span>
                                </a>
                            </div>
                        </div>
                    </li>

                    {{-- <!-- Airport & Requests Section -->
                    <li class="mt-6">
                        <div x-show="open" class="mb-3 px-2">
                            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Airport & Requests
                            </h3>
                        </div>

                        <!-- Airport Consult -->
                        <a href="{{ route('airlabs.index') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'airlabs.index' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'airlabs.index'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'airlabs.index' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Airport Consult') }}
                            </span>

                            <span x-show="open && activeSection === 'airlabs.index'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>

                        <!-- Request -->
                        <a href="{{ route('show.request') }}"
                            class="group flex items-center rounded-lg px-3 py-3 transition-all duration-300"
                            :class="activeSection === 'show.request' ? 'bg-indigo-50 text-indigo-700' :
                                'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'"
                            @click="activeSection = 'show.request'">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md"
                                :class="activeSection === 'show.request' ? 'bg-indigo-100 text-indigo-600' :
                                    'text-gray-500 group-hover:text-indigo-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-2"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="ml-3 font-medium whitespace-nowrap">
                                {{ __('Request') }}
                            </span>

                            <span x-show="open && activeSection === 'show.request'"
                                class="ml-auto h-2 w-2 rounded-full bg-indigo-500"></span>
                        </a>
                    </li> --}}
                </ul>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="absolute bottom-0 left-0 right-0 border-t border-gray-100 bg-white p-4">
            <div class="flex items-center">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100 transition-all duration-300 hover:ring-indigo-300"
                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 transition-all duration-300 hover:bg-indigo-200">
                        <span class="text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif

                <div x-show="open" class="ml-3 transition-all duration-300">
                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <div class="flex space-x-3 text-xs">
                        <a href="{{ route('profile.show') }}"
                            class="text-indigo-600 hover:text-indigo-800 transition-all duration-300 hover:underline">
                            {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" @click.prevent="$root.submit();"
                                class="text-gray-500 hover:text-gray-700 transition-all duration-300 hover:underline">
                                {{ __('Log Out') }}
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
        class="fixed inset-0 z-30 bg-gray-600 bg-opacity-75 md:hidden"></div>
</div>
