<x-guest-layout>
    <!-- Loader Screen -->
    <div id="loader" class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900">
        <div class="text-center">
            <!-- Animated Logo -->
            <div class="relative mb-8">
                <div class="w-24 h-24 mx-auto relative">
                    <!-- Outer rotating ring -->
                    <div class="absolute inset-0 border-4 border-transparent border-t-blue-500 border-r-purple-500 rounded-full animate-spin"></div>
                    <!-- Inner pulsing ring -->
                    <div class="absolute inset-2 border-2 border-transparent border-b-cyan-400 border-l-pink-400 rounded-full animate-spin animate-reverse"></div>
                    <!-- Logo center -->
                    <div class="absolute inset-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center animate-pulse">
                        <span class="text-white font-bold text-xl">239</span>
                    </div>
                </div>
            </div>
            
            <!-- Loading text with typewriter effect -->
            <div class="text-white text-xl font-semibold mb-4">
                <span id="loading-text">Loading</span>
                <span class="animate-pulse">...</span>
            </div>
            
            <!-- Progress bar -->
            <div class="w-64 h-2 bg-white/10 rounded-full overflow-hidden mx-auto">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
            </div>
            
            <!-- Loading percentage -->
            <div class="text-slate-300 text-sm mt-4">
                <span id="loading-percentage">0%</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen relative overflow-hidden bg-slate-900 opacity-0">
        <!-- Enhanced animated background -->
        <div class="absolute inset-0">
            <!-- Gradient overlay with animation -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 via-purple-900/20 to-slate-900 animate-gradient"></div>
            
            <!-- Multiple floating elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-full blur-3xl animate-float-slow"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl animate-float-medium"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-full blur-3xl animate-float-fast"></div>
                <div class="absolute top-10 right-1/3 w-48 h-48 bg-gradient-to-r from-pink-500/10 to-red-500/10 rounded-full blur-3xl animate-bounce-slow"></div>
                <div class="absolute bottom-10 left-1/3 w-56 h-56 bg-gradient-to-r from-green-500/10 to-teal-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
            </div>

            <!-- Animated particles -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="particle absolute w-2 h-2 bg-blue-400/30 rounded-full animate-particle-1"></div>
                <div class="particle absolute w-1 h-1 bg-purple-400/40 rounded-full animate-particle-2"></div>
                <div class="particle absolute w-3 h-3 bg-cyan-400/20 rounded-full animate-particle-3"></div>
                <div class="particle absolute w-1.5 h-1.5 bg-pink-400/35 rounded-full animate-particle-4"></div>
                <div class="particle absolute w-2.5 h-2.5 bg-yellow-400/25 rounded-full animate-particle-5"></div>
            </div>

            <!-- Enhanced grid pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="h-full w-full animate-grid" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 50px 50px;"></div>
            </div>
        </div>

        <!-- Main content with stagger animations -->
        <div class="relative z-10 flex min-h-screen">
            <!-- Left side - Enhanced branding -->
            <div class="hidden lg:flex lg:w-1/2 flex-col justify-center items-center p-12 relative">
                <!-- Company branding with entrance animation -->
                <div class="text-center mb-12 animate-slide-in-left">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl mb-6 shadow-2xl animate-logo-bounce">
                        <span class="text-white font-bold text-3xl animate-pulse">239</span>
                    </div>
                    <h1 class="text-6xl font-bold text-white mb-4 tracking-tight animate-text-glow">
                        239 <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-gradient-text">WEB</span>
                    </h1>
                    <p class="text-xl text-slate-300 max-w-md leading-relaxed animate-fade-in-up">
                        Transforming digital experiences with innovative web solutions
                    </p>
                </div>

                <!-- Enhanced feature highlights -->
                <div class="space-y-8 max-w-md">
                    <div class="flex items-center space-x-4 text-slate-300 animate-slide-in-left animation-delay-200">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10 animate-icon-float">
                            <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white text-lg">Lightning Fast</h3>
                            <p class="text-sm text-slate-400">Optimized performance for modern web</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 text-slate-300 animate-slide-in-left animation-delay-400">
                        <div class="w-14 h-14 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10 animate-icon-float animation-delay-200">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white text-lg">Secure & Reliable</h3>
                            <p class="text-sm text-slate-400">Enterprise-grade security standards</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 text-slate-300 animate-slide-in-left animation-delay-600">
                        <div class="w-14 h-14 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10 animate-icon-float animation-delay-400">
                            <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white text-lg">Responsive Design</h3>
                            <p class="text-sm text-slate-400">Perfect on every device and screen</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side - Enhanced login form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="w-full max-w-md animate-slide-in-right">
                    <!-- Enhanced glassmorphism card -->
                    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-3xl p-8 shadow-2xl animate-card-entrance hover:shadow-3xl transition-all duration-500 hover:scale-105">
                        <!-- Mobile logo with animation -->
                        <div class="lg:hidden text-center mb-8 animate-fade-in-down">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl mb-4 animate-logo-bounce">
                                <span class="text-white font-bold text-2xl">239</span>
                            </div>
                            <h2 class="text-3xl font-bold text-white animate-text-glow">239 WEB</h2>
                        </div>

                        <!-- Form header with animation -->
                        <div class="text-center mb-8 animate-fade-in-up">
                            <h2 class="text-4xl font-bold text-white mb-2 hidden lg:block animate-text-glow">Welcome Back</h2>
                            <p class="text-slate-300 text-lg">Sign in to access your dashboard</p>
                        </div>

                        <!-- Enhanced error messages -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl backdrop-blur-sm animate-shake">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-5 h-5 text-red-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-red-400 font-medium text-sm">Authentication Error</span>
                                </div>
                                <ul class="text-sm text-red-300 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="animate-fade-in-left">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Enhanced status message -->
                        @if (session('status'))
                            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-2xl backdrop-blur-sm animate-bounce-in">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-green-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-green-300 text-sm">{{ session('status') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Enhanced login form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Email field with enhanced animation -->
                            <div class="space-y-2 animate-slide-in-up animation-delay-200">
                                <label for="email" class="block text-sm font-medium text-slate-200">
                                    Email Address
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-all duration-300 group-focus-within:text-blue-400">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email') }}" 
                                        required 
                                        autofocus 
                                        autocomplete="username"
                                        class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-sm hover:bg-white/10 focus:bg-white/10 animate-input-glow"
                                        placeholder="Enter your email address"
                                    >
                                </div>
                            </div>

                            <!-- Password field with enhanced animation -->
                            <div class="space-y-2 animate-slide-in-up animation-delay-400">
                                <label for="password" class="block text-sm font-medium text-slate-200">
                                    Password
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-all duration-300 group-focus-within:text-blue-400">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        required 
                                        autocomplete="current-password"
                                        class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 backdrop-blur-sm hover:bg-white/10 focus:bg-white/10 animate-input-glow"
                                        placeholder="Enter your password"
                                    >
                                </div>
                            </div>

                            <!-- Remember me and forgot password with animation -->
                            <div class="flex items-center justify-between animate-slide-in-up animation-delay-600">
                                <label class="flex items-center group cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="remember" 
                                        id="remember_me"
                                        class="w-4 h-4 text-blue-500 bg-white/10 border-white/20 rounded focus:ring-blue-500/50 focus:ring-2 transition-all duration-300"
                                    >
                                    <span class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors duration-300">Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a 
                                        href="{{ route('password.request') }}" 
                                        class="text-sm text-blue-400 hover:text-blue-300 transition-all duration-200 font-medium hover:underline animate-pulse-subtle"
                                    >
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Enhanced login button -->
                            <button 
                                type="submit" 
                                class="group relative w-full bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white py-4 px-6 rounded-2xl font-semibold hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all duration-500 transform hover:scale-105 active:scale-95 shadow-xl hover:shadow-2xl animate-button-glow animate-slide-in-up animation-delay-800"
                            >
                                <span class="relative z-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Sign In to Dashboard
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-purple-700 to-pink-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </button>
                        </form>

                        <!-- Enhanced footer -->
                        <div class="mt-8 text-center animate-fade-in-up animation-delay-1000">
                            <p class="text-sm text-slate-400">
                                Don't have an account? 
                                <a href="#" class="text-blue-400 hover:text-blue-300 font-medium transition-all duration-200 hover:underline animate-pulse-subtle">
                                    Create one now
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Loader animations */
        @keyframes spin-reverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }
        
        .animate-reverse {
            animation-direction: reverse;
        }

        /* Enhanced floating animations */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        @keyframes float-medium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(-180deg); }
        }
        
        @keyframes float-fast {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-40px) rotate(360deg); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.1); }
        }
        
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.2); }
        }

        /* Particle animations */
        @keyframes particle-1 {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(100px); opacity: 0; }
        }
        
        @keyframes particle-2 {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(-50px); opacity: 0; }
        }
        
        @keyframes particle-3 {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(200px); opacity: 0; }
        }
        
        @keyframes particle-4 {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(-100px); opacity: 0; }
        }
        
        @keyframes particle-5 {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(150px); opacity: 0; }
        }

        /* Enhanced entrance animations */
        @keyframes slide-in-left {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slide-in-right {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slide-in-up {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes fade-in-up {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes fade-in-down {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes fade-in-left {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Special effects */
        @keyframes text-glow {
            0%, 100% { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { text-shadow: 0 0 30px rgba(147, 51, 234, 0.8), 0 0 40px rgba(59, 130, 246, 0.6); }
        }
        
        @keyframes gradient-text {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes logo-bounce {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }
        
        @keyframes icon-float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        @keyframes card-entrance {
            from { transform: translateY(50px) scale(0.9); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
        
        @keyframes button-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(147, 51, 234, 0.5), 0 0 40px rgba(236, 72, 153, 0.3); }
        }
        
        @keyframes input-glow {
            0%, 100% { box-shadow: 0 0 0 rgba(59, 130, 246, 0); }
            50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.1); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes bounce-in {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes grid {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(50px) translateY(50px); }
        }

        /* Apply animations */
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-medium { animation: float-medium 6s ease-in-out infinite; }
        .animate-float-fast { animation: float-fast 4s ease-in-out infinite; }
        .animate-bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
        
        .animate-particle-1 { animation: particle-1 15s linear infinite; }
        .animate-particle-2 { animation: particle-2 12s linear infinite 2s; }
        .animate-particle-3 { animation: particle-3 18s linear infinite 4s; }
        .animate-particle-4 { animation: particle-4 14s linear infinite 6s; }
        .animate-particle-5 { animation: particle-5 16s linear infinite 8s; }
        
        .animate-slide-in-left { animation: slide-in-left 1s ease-out forwards; }
        .animate-slide-in-right { animation: slide-in-right 1s ease-out forwards; }
        .animate-slide-in-up { animation: slide-in-up 0.8s ease-out forwards; }
        .animate-fade-in-up { animation: fade-in-up 1s ease-out forwards; }
        .animate-fade-in-down { animation: fade-in-down 1s ease-out forwards; }
        .animate-fade-in-left { animation: fade-in-left 0.5s ease-out forwards; }
        
        .animate-text-glow { animation: text-glow 3s ease-in-out infinite; }
        .animate-gradient-text { animation: gradient-text 3s ease infinite; background-size: 200% 200%; }
        .animate-logo-bounce { animation: logo-bounce 2s ease-in-out infinite; }
        .animate-icon-float { animation: icon-float 3s ease-in-out infinite; }
        .animate-card-entrance { animation: card-entrance 1s ease-out forwards; }
        .animate-button-glow { animation: button-glow 2s ease-in-out infinite; }
        .animate-input-glow { animation: input-glow 2s ease-in-out infinite; }
        .animate-shake { animation: shake 0.5s ease-in-out; }
        .animate-bounce-in { animation: bounce-in 0.6s ease-out forwards; }
        .animate-pulse-subtle { animation: pulse-subtle 2s ease-in-out infinite; }
        .animate-gradient { animation: gradient 15s ease infinite; background-size: 400% 400%; }
        .animate-grid { animation: grid 20s linear infinite; }

        /* Animation delays */
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .animation-delay-800 { animation-delay: 0.8s; }
        .animation-delay-1000 { animation-delay: 1s; }

        /* Particle positioning */
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 70%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 80%; animation-delay: 8s; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('loader');
            const mainContent = document.getElementById('main-content');
            const progressBar = document.getElementById('progress-bar');
            const loadingPercentage = document.getElementById('loading-percentage');
            const loadingText = document.getElementById('loading-text');
            
            const loadingMessages = [
                'Initializing 239 Web...',
                'Loading components...',
                'Preparing dashboard...',
                'Almost ready...',
                'Welcome!'
            ];
            
            let progress = 0;
            let messageIndex = 0;
            
            const loadingInterval = setInterval(() => {
                progress += Math.random() * 15 + 5;
                
                if (progress > 100) progress = 100;
                
                progressBar.style.width = progress + '%';
                loadingPercentage.textContent = Math.floor(progress) + '%';
                
                // Change loading message
                if (progress > messageIndex * 20 && messageIndex < loadingMessages.length - 1) {
                    messageIndex++;
                    loadingText.textContent = loadingMessages[messageIndex];
                }
                
                if (progress >= 100) {
                    clearInterval(loadingInterval);
                    
                    setTimeout(() => {
                        loader.style.opacity = '0';
                        loader.style.transform = 'scale(0.8)';
                        loader.style.transition = 'all 0.8s ease-out';
                        
                        setTimeout(() => {
                            loader.style.display = 'none';
                            mainContent.style.opacity = '1';
                            mainContent.style.transition = 'opacity 1s ease-in';
                        }, 800);
                    }, 500);
                }
            }, 100);
        });
    </script>
</x-guest-layout>