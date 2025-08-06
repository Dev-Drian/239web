<div class="glass-card p-6 mb-8 animate-slide-up">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white">Create Blog Post</h1>
                <p class="text-slate-400 mt-1">Generate engaging content for your audience</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-right">
                <p class="text-sm text-slate-400">Client</p>
                <p class="font-semibold text-white">{{ $client->name ?? 'Unknown' }}</p>
            </div>
            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-sm">{{ substr($client->name ?? 'U', 0, 1) }}</span>
            </div>
        </div>
    </div>
</div>
