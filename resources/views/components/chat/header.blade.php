@props(['selectedChat', 'chatType', 'otherUser'])

<div class="glass-dark backdrop-blur-sm p-4 flex items-center border-b border-white/15 shadow-sm sticky top-0 z-10 transition-all duration-300">
    <!-- Avatar y Estado -->
    <div class="relative group">
        @if($chatType == 'private')
            <img src="{{ $otherUser->profile_photo_url }}" alt="{{ $otherUser->name }}" 
                 class="w-11 h-11 rounded-full object-cover mr-3 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
            <span class="absolute bottom-0 right-2 w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full ring-2 ring-green-400/30 animate-pulse"></span>
        @else
            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center mr-3 font-semibold transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                {{ substr($selectedChat->name ?? 'G', 0, 1) }}
            </div>
        @endif
    </div>

    <!-- Información del Chat -->
    <div class="flex-1 min-w-0">
        <h3 class="font-semibold text-white truncate">
            {{ $chatType == 'private' ? $otherUser->name : $selectedChat->name }}
        </h3>
        <p class="text-xs text-slate-400 truncate">
            @if($chatType == 'group')
                {{ $selectedChat->users->count() }} miembros
            @else
                En línea
            @endif
        </p>
    </div>

    <!-- Acciones del Header -->
    <div class="flex space-x-4 text-slate-400">
        {{-- <button class="hover:text-indigo-400 transition-colors" title="Menú">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
            </svg>
        </button> --}}
    </div>
</div>