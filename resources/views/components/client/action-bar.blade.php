<div class="sticky top-0 z-40 glass-dark shadow-2xl rounded-2xl p-4 mb-6 border border-white/15 backdrop-blur-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <!-- Client Info -->
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-blue-500/30">
                <span class="text-white font-bold text-lg">{{ substr($client->name ?? 'C', 0, 1) }}</span>
            </div>
            <div>
                <h3 class="font-semibold text-xl text-white">{{ $client->name }}</h3>
                <p class="text-sm text-slate-400">ID: {{ $client->id }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Botón To-Do -->
            <a href="{{ route('board.show', $client->highlevel_id) }}"
                class="flex items-center px-4 py-2 bg-purple-500/80 text-white rounded-xl hover:bg-purple-500 transition-all duration-300 shadow-lg hover:shadow-xl group transform hover:scale-105 hover:-translate-y-0.5 border border-purple-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span class="font-medium">To-Do List</span>
            </a>

            <!-- Botón Show Boarding -->
            <a href="{{ route('area.index',$client->highlevel_id) }}"
                class="flex items-center px-4 py-2 bg-indigo-500/80 text-white rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl group transform hover:scale-105 hover:-translate-y-0.5 border border-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Show Boarding</span>
            </a>

            <!-- Botón Citations -->
            <a href="{{ route('citations.show', ['client_id' => $client->id]) }}"
                class="flex items-center px-4 py-2 bg-blue-500/80 text-white rounded-xl hover:bg-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl group transform hover:scale-105 hover:-translate-y-0.5 border border-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                </svg>
                <span class="font-medium">Citations</span>
            </a>

            <!-- Botón Cancel -->
            <a href="{{ route('client.index') }}"
                class="flex items-center px-4 py-2 glass text-slate-300 rounded-xl hover:bg-white/10 hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 hover:-translate-y-0.5 border border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="font-medium">Cancel</span>
            </a>

            <!-- Botón Save Changes -->
            <button type="submit"
                    class="flex items-center px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 shadow-lg hover:shadow-xl group transform hover:scale-105 hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">Save Changes</span>
            </button>
        </div>
    </div>
</div>