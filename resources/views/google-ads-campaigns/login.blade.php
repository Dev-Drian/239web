<x-guest-layout>
    <div class="min-h-screen main-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 glass-dark p-8 rounded-2xl shadow-2xl border border-white/15 backdrop-blur-xl">
            <div>
                <div class="flex justify-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-blue-500/30">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" />
                        </svg>
                    </div>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                    Connect Your Google Ads Account
                </h2>
                <p class="mt-2 text-center text-sm text-slate-400">
                    To create and manage campaigns, we need access to your Google Ads account
                </p>
            </div>

            @if (session('error'))
                <div class="mb-4 p-4 glass border border-red-400/30 text-red-300 rounded-2xl backdrop-blur-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0M12 8v4m0 4h.01" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="mt-8 space-y-6">
                <div class="flex flex-col space-y-4">
                    <a href="{{ route('google.login', ['id' => $client->highlevel_id]) }}"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-2xl text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-colors duration-200">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" />
                                </svg>
                            </div>
                        </span>
                        <span class="ml-8">Sign in with Google Ads</span>
                    </a>
                    <p class="text-xs text-center text-slate-500">
                        By connecting your account, you agree to our 
                        <span class="text-blue-400 hover:text-blue-300 transition-colors duration-200">Terms of Service</span> 
                        and 
                        <span class="text-blue-400 hover:text-blue-300 transition-colors duration-200">Privacy Policy</span>
                    </p>
                </div>

                <!-- Enhanced Features Section -->
                <div class="mt-8 space-y-4">
                    <h3 class="text-lg font-semibold text-white text-center">What you'll get:</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm">Create and manage campaigns</span>
                        </div>
                        <div class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-sm">Track performance metrics</span>
                        </div>
                        <div class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                                </svg>
                            </div>
                            <span class="text-sm">Optimize ad spending</span>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 p-4 glass border border-green-400/30 rounded-2xl backdrop-blur-xl">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-green-500/20 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-green-300">Secure Connection</h4>
                            <p class="text-xs text-green-400/80 mt-1">Your data is encrypted and protected. We only access what's necessary for campaign management.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
