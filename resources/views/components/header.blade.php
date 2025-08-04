<div class="w-full glass-dark border-b border-white/15 backdrop-blur-xl relative z-50">
    <!-- Versión desktop y tablet -->
    <div class="hidden sm:flex items-center justify-between py-4 px-6 max-w-7xl mx-auto">
        <!-- Logo y nombre en el lado izquierdo -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" 
                class="h-9 md:h-10 rounded-xl transition-all duration-300 hover:scale-105 shadow-lg ring-2 ring-white/20">
            <div class="text-slate-500 font-light text-lg">|</div>
            <h2 class="text-xl md:text-2xl font-bold text-white truncate bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
                {{ __($name) }}
            </h2>
        </div>
        
        <!-- Notificaciones y perfil de usuario en el lado derecho -->
        <div class="flex items-center space-x-6">
            <!-- Botón de notificaciones -->
            <div class="relative">
                @livewire('app-notification-component')
            </div>
            
            <!-- Separador vertical -->
            <div class="text-slate-500 font-light text-lg">|</div>
            
            <!-- Menú desplegable de usuario -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" type="button"
                     class="flex items-center space-x-3 text-sm group transition-all duration-300 pl-2 hover:bg-white/10 rounded-xl p-2"
                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <img class="h-10 w-10 rounded-xl object-cover shadow-lg ring-2 ring-white/20 group-hover:ring-blue-400/50 transition-all duration-300"
                        src="{{ auth()->user()->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="User profile">
                    <div class="flex flex-col text-left ml-1">
                        <span class="font-semibold text-white group-hover:text-blue-300 hidden md:inline transition-colors duration-300">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-slate-400 hidden md:inline">{{ auth()->user()->email }}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 group-hover:text-blue-300 transition-all duration-300" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                
                <!-- Menú desplegable -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-3 w-64 origin-top-right rounded-2xl glass-dark py-2 shadow-2xl ring-1 ring-white/20 focus:outline-none z-[9999] backdrop-blur-xl border border-white/15"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="px-4 py-3 md:hidden border-b border-white/15">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:bg-white/10 hover:text-blue-300 transition-all duration-200 rounded-xl mx-2"
                        role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Tu Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200 rounded-xl mx-2"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm12 12H5V5h10v10z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M16 8a1 1 0 00-1-1h-4a1 1 0 100 2h2.586l-3.293 3.293a1 1 0 001.414 1.414L15 10.414V13a1 1 0 102 0V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Versión móvil -->
    <div class="sm:hidden">
        <!-- Barra principal con logo y botones de acción -->
        <div class="flex items-center justify-between py-3 px-4">
            <!-- Logo y nombre colapsable -->
            <div class="flex items-center flex-shrink-0">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" 
                    class="h-8 rounded-lg transition-all duration-300 hover:scale-105 shadow-md ring-2 ring-white/20">
                <div class="mx-3 text-slate-500 font-light">|</div>
                <h2 class="text-lg font-bold text-white truncate max-w-[150px] bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
                    {{ __($name) }}
                </h2>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex items-center space-x-4">
                <!-- Botón de notificaciones -->
                <div class="relative">
                    @livewire('app-notification-component')
                </div>
                
                <!-- Separador vertical -->
                <div class="text-slate-500 font-light">|</div>
                
                <!-- Menú desplegable de usuario -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                         class="flex items-center text-sm focus:outline-none p-1 hover:bg-white/10 rounded-xl transition-all duration-300"
                        id="mobile-user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <img class="h-9 w-9 rounded-xl object-cover shadow-lg ring-2 ring-white/20 hover:ring-blue-400/50 transition-all duration-300"
                            src="{{ auth()->user()->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="User profile">
                    </button>
                    
                    <!-- Menú desplegable móvil -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-64 origin-top-right rounded-2xl glass-dark py-2 shadow-2xl ring-1 ring-white/20 focus:outline-none z-[9999] backdrop-blur-xl border border-white/15"
                        role="menu" aria-orientation="vertical" aria-labelledby="mobile-user-menu-button" tabindex="-1">
                        <div class="px-4 py-3 border-b border-white/15">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:bg-white/10 hover:text-blue-300 transition-all duration-200 rounded-xl mx-2"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Tu Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200 rounded-xl mx-2"
                                role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm12 12H5V5h10v10z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M16 8a1 1 0 00-1-1h-4a1 1 0 100 2h2.586l-3.293 3.293a1 1 0 001.414 1.414L15 10.414V13a1 1 0 102 0V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>