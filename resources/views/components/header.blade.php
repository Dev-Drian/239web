<div class="w-full bg-white ">
    <!-- Versión desktop y tablet -->
    <div class="hidden sm:flex items-center justify-between py-3 px-6 max-w-7xl mx-auto">
        <!-- Logo y nombre en el lado izquierdo -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="h-8 md:h-9 rounded-md transition-transform duration-300 hover:scale-105">
            <div class="text-gray-300 font-light">|</div>
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 truncate">
                {{ __($name) }}
            </h2>
        </div>
        
        <!-- Notificaciones y perfil de usuario en el lado derecho -->
        <div class="flex items-center space-x-4 md:space-x-5">
            <!-- Botón de notificaciones -->
            <div class="relative">
                @livewire('app-notification-component')
            </div>
            
            <!-- Separador vertical -->
            <div class="text-gray-300 font-light">|</div>
            
            <!-- Menú desplegable de usuario -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" type="button" 
                    class="flex items-center space-x-3 text-sm group transition-all duration-300 pl-2"
                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <img class="h-9 w-9 rounded-full object-cover shadow-sm group-hover:shadow-md transition-all duration-300"
                        src="{{ auth()->user()->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="User profile">
                    <div class="flex flex-col text-left ml-1">
                        <span class="font-medium text-gray-700 group-hover:text-gray-900 hidden md:inline transition-colors duration-300">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-gray-500 hidden md:inline">{{ auth()->user()->email }}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                
                <!-- Menú desplegable -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-3 w-60 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="px-4 py-2 md:hidden border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Tu Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
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
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="h-7 rounded-md transition-transform duration-300 hover:scale-105">
                <div class="mx-2 text-gray-300 font-light">|</div>
                <h2 class="text-base font-semibold text-gray-800 truncate max-w-[150px]">
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
                <div class="text-gray-300 font-light">|</div>
                
                <!-- Menú desplegable de usuario -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button" 
                        class="flex items-center text-sm focus:outline-none pl-2 transition-all duration-300"
                        id="mobile-user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <img class="h-8 w-8 rounded-full object-cover shadow-sm hover:shadow-md transition-all duration-300"
                            src="{{ auth()->user()->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="User profile">
                    </button>
                    
                    <!-- Menú desplegable móvil -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-60 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                        role="menu" aria-orientation="vertical" aria-labelledby="mobile-user-menu-button" tabindex="-1">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Tu Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                                role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
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