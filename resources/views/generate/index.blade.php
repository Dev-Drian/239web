<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'Smart Assistant'])
    </x-slot>

    <div class="min-h-screen main-bg py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <!-- Main Chat Container -->
                <div class="flex-1 glass-dark shadow-2xl rounded-2xl border border-white/15 backdrop-blur-xl overflow-hidden transition-all duration-500 hover:shadow-3xl">
                    <!-- Enhanced Header -->
                    <div class="p-6 border-b border-white/10 bg-gradient-to-r from-blue-600/20 via-indigo-600/20 to-purple-600/20 rounded-t-2xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/10 to-purple-400/10 animate-pulse"></div>
                        <div class="relative flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl glass border border-white/20 flex items-center justify-center animate-bounce shadow-lg ring-2 ring-blue-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-ping"></div>
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full ring-2 ring-green-500/30"></div>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold tracking-tight text-white">Smart Assistant</h2>
                                    <p class="text-slate-400 mt-1 font-light">Your virtual assistant with precise and personalized responses</p>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-medium glass border border-green-500/30 text-green-300 shadow-lg backdrop-blur-xl">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Model Selector -->
                    <div class="p-4 glass border-b border-white/10 backdrop-blur-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-semibold text-slate-300 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    AI Model:
                                </label>
                                <div class="flex space-x-3">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="ai_model" value="gpt" checked
                                             class="w-4 h-4 text-indigo-500 bg-transparent border-indigo-500/50 focus:ring-indigo-500/50 focus:ring-2 transition-all duration-200">
                                        <span class="ml-2 text-sm text-slate-300 group-hover:text-indigo-400 transition-colors duration-200 font-medium">GPT-4</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="ai_model" value="perplexity"
                                             class="w-4 h-4 text-indigo-500 bg-transparent border-indigo-500/50 focus:ring-indigo-500/50 focus:ring-2 transition-all duration-200">
                                        <span class="ml-2 text-sm text-slate-300 group-hover:text-indigo-400 transition-colors duration-200 font-medium">Perplexity</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="glass px-3 py-1 rounded-xl border border-white/20 backdrop-blur-xl">
                                    <span class="text-xs text-slate-400">
                                        <span id="message-count" class="text-blue-400 font-semibold">0</span> messages
                                    </span>
                                </div>
                                <!-- Save Prompt Button -->
                                <button type="button" id="save-prompt-btn" class="bg-gradient-to-r from-emerald-500/80 to-teal-600/80 text-white px-4 py-2 rounded-xl hover:from-emerald-600/80 hover:to-teal-700/80 transition-all duration-300 font-semibold text-sm shadow-lg hover:shadow-xl transform hover:scale-105 border border-emerald-400/30 backdrop-blur-xl">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Save Prompt
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Chat Messages -->
                    <div id="chat-messages" class="h-[500px] overflow-y-auto p-6 space-y-6 glass backdrop-blur-xl custom-scrollbar">
                        <div class="flex justify-start mb-4 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s">
                            <div class="flex items-start max-w-4xl">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-3 flex-shrink-0 shadow-lg ring-2 ring-indigo-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="px-5 py-4 rounded-2xl glass border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 backdrop-blur-xl">
                                    <p class="text-xs text-indigo-400 font-semibold mb-2 flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                        Assistant
                                    </p>
                                    <div class="prose prose-sm max-w-none text-slate-300">
                                        <p class="mb-0">Hello! I'm your virtual assistant. How can I help you today?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Input Area -->
                    <div class="p-6 glass border-t border-white/10 rounded-b-2xl backdrop-blur-xl">
                        <form id="chat-form" class="space-y-4">
                            @csrf
                            
                            <!-- Enhanced Attachments Area -->
                            <div id="attachments-area" class="hidden">
                                <div class="glass rounded-2xl p-4 border border-white/20 shadow-lg backdrop-blur-xl">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-slate-300 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Attached Files
                                        </h4>
                                        <button type="button" onclick="clearAllFiles()" class="text-xs text-red-400 hover:text-red-300 transition-colors duration-200 font-medium">
                                            Clear All
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap gap-3" id="attachments-list">
                                        <!-- Files will be displayed here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Toggle Button -->
                            <div class="mb-4 lg:hidden">
                                <button type="button" id="toggle-prompts-btn" class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-5 py-2.5 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 font-semibold text-sm shadow-lg transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    Show Prompts
                                </button>
                            </div>

                            <!-- Enhanced Main Input -->
                            <div class="flex space-x-3">
                                <div class="flex-1 relative">
                                    <input type="text" id="message-input"
                                        class="w-full p-4 pr-12 glass border border-white/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300 shadow-lg hover:shadow-xl bg-transparent text-white placeholder-slate-400 backdrop-blur-xl"
                                        placeholder="Type your message here...">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <div id="char-counter" class="text-xs text-slate-500">0</div>
                                    </div>
                                </div>
                                
                                <!-- Enhanced Attach Button -->
                                <button type="button" id="attach-button"
                                    class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-5 py-5 rounded-2xl hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-3 focus:ring-gray-500/50 focus:ring-offset-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center group border border-gray-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                            
                                <!-- Enhanced Send Button -->
                                <button type="submit" id="send-button"
                                    class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-6 py-4 rounded-2xl hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center group disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span class="mr-2 font-medium">Send</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Hidden File Input -->
                            <input type="file" id="file-input" multiple accept=".txt,.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.mp3,.mp4,.zip" class="hidden">
                        </form>
                    </div>
                </div>
                
                <!-- Desktop Prompts Sidebar -->
                <div class="hidden lg:block w-80 glass-dark shadow-2xl rounded-2xl border border-white/15 backdrop-blur-xl overflow-hidden transition-all duration-500 hover:shadow-3xl">
                    <!-- Enhanced Prompts Header -->
                    <div class="p-6 border-b border-white/10 bg-gradient-to-r from-indigo-500/20 to-purple-600/20 rounded-t-2xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 glass rounded-2xl flex items-center justify-center border border-white/30">
                                <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-white">Saved Prompts</h3>
                                <p class="text-slate-400 text-sm font-medium">Quick access to your templates</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Filters -->
                    <div class="p-5 border-b border-white/10 glass">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <input type="text" id="prompt-search" placeholder="Search prompts..." 
                                       class="flex-1 px-4 py-2.5 text-sm glass border border-white/20 rounded-xl focus:ring-3 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-200 bg-transparent text-white placeholder-slate-400 shadow-sm backdrop-blur-xl">
                                <button id="clear-search" class="text-slate-400 hover:text-slate-300 transition-colors duration-200 p-2 rounded-lg hover:bg-white/10">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button class="filter-btn active px-4 py-2 text-xs font-bold rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md transition-all duration-200 hover:shadow-lg transform hover:scale-105" data-category="all">
                                    All
                                </button>
                                <button class="filter-btn px-4 py-2 text-xs font-semibold rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10 hover:shadow-md transform hover:scale-105" data-category="Content">
                                    Content
                                </button>
                                <button class="filter-btn px-4 py-2 text-xs font-semibold rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10 hover:shadow-md transform hover:scale-105" data-category="SEO">
                                    SEO
                                </button>
                                <button class="filter-btn px-4 py-2 text-xs font-semibold rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10 hover:shadow-md transform hover:scale-105" data-category="Marketing">
                                    Marketing
                                </button>
                                <button class="filter-btn px-4 py-2 text-xs font-semibold rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10 hover:shadow-md transform hover:scale-105" data-category="Social Media">
                                    Social
                                </button>
                                <button class="filter-btn px-4 py-2 text-xs font-semibold rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10 hover:shadow-md transform hover:scale-105" data-category="Email">
                                    Email
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Prompts List -->
                    <div class="p-5">
                        <div id="prompts-list" class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
                            <!-- Prompts will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Footer -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center space-x-4 glass rounded-2xl px-6 py-3 shadow-lg border border-white/20 backdrop-blur-xl">
                    <div class="flex items-center text-sm text-slate-400">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        Encrypted Data
                    </div>
                    <div class="w-px h-4 bg-white/20"></div>
                    <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Privacy Policy</a>
                </div>
            </div>
            
            <!-- Mobile Prompts Sidebar (Overlay) -->
            <div id="mobile-prompts-sidebar" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 lg:hidden hidden">
                <div class="absolute right-0 top-0 h-full w-80 glass-dark backdrop-blur-xl shadow-2xl transform translate-x-full transition-transform duration-500 border-l border-white/15">
                    <!-- Mobile Prompts Header -->
                    <div class="p-6 border-b border-white/10 bg-gradient-to-r from-indigo-500/20 to-purple-600/20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 glass rounded-xl flex items-center justify-center border border-white/20">
                                    <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Saved Prompts</h3>
                                    <p class="text-slate-400 text-sm">Quick access to your templates</p>
                                </div>
                            </div>
                            <button id="close-mobile-prompts" class="text-white hover:text-slate-300 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Mobile Filters -->
                    <div class="p-4 border-b border-white/10 glass">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2">
                                <input type="text" id="mobile-prompt-search" placeholder="Search prompts..." 
                                       class="flex-1 px-3 py-2 text-sm glass border border-white/20 rounded-lg focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-200 bg-transparent text-white placeholder-slate-400 backdrop-blur-xl">
                                <button id="mobile-clear-search" class="text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button class="mobile-filter-btn active px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white transition-all duration-200 hover:shadow-md" data-category="all">
                                    All
                                </button>
                                <button class="mobile-filter-btn px-3 py-1 text-xs font-medium rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10" data-category="Content">
                                    Content
                                </button>
                                <button class="mobile-filter-btn px-3 py-1 text-xs font-medium rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10" data-category="SEO">
                                    SEO
                                </button>
                                <button class="mobile-filter-btn px-3 py-1 text-xs font-medium rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10" data-category="Marketing">
                                    Marketing
                                </button>
                                <button class="mobile-filter-btn px-3 py-1 text-xs font-medium rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10" data-category="Social Media">
                                    Social
                                </button>
                                <button class="mobile-filter-btn px-3 py-1 text-xs font-medium rounded-full glass border border-white/20 text-slate-300 transition-all duration-200 hover:bg-white/10" data-category="Email">
                                    Email
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Prompts List -->
                    <div class="p-4">
                        <div id="mobile-prompts-list" class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                            <!-- Prompts will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slide-in-right 0.5s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.5s ease-out forwards;
        }

        .animate-bounce-in {
            animation: bounce-in 0.6s ease-out forwards;
        }

        /* Custom Dark Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }

        /* Enhanced prompt cards */
        .prompt-card {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
        .prompt-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                0 0 0 1px rgba(255, 255, 255, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .file-preview {
            transition: all 0.3s ease;
        }

        .file-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .typing-dots {
            display: inline-flex;
            align-items: center;
        }

        .typing-dots span {
            height: 8px;
            width: 8px;
            background: #6366f1;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Enhanced hover effects */
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        /* Drag and drop styles */
        .drag-over {
            background: rgba(99, 102, 241, 0.1) !important;
            border: 2px dashed rgba(99, 102, 241, 0.5) !important;
        }

        /* Filter button styles for dark theme */
        .filter-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .filter-btn:hover::before {
            left: 100%;
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            color: white;
            box-shadow: 
                0 4px 15px rgba(99, 102, 241, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            transform: translateY(-2px) scale(1.05);
        }

        /* Line clamp utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    @endpush

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');
            const chatMessages = document.getElementById('chat-messages');
            const attachButton = document.getElementById('attach-button');
            const fileInput = document.getElementById('file-input');
            const attachmentsArea = document.getElementById('attachments-area');
            const attachmentsList = document.getElementById('attachments-list');
            const charCounter = document.getElementById('char-counter');
            const messageCount = document.getElementById('message-count');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let selectedFiles = [];
            let messageCounter = 1;
            let allPrompts = [];
            let currentFilter = 'all';
            let currentSearch = '';

            // Enhanced character counter
            messageInput.addEventListener('input', function() {
                const length = this.value.length;
                charCounter.textContent = length;
                charCounter.className = length > 500 ? 'text-xs text-red-400' : 'text-xs text-slate-500';
                
                // Add visual feedback for long messages
                if (length > 500) {
                    this.classList.add('border-red-500/50');
                } else {
                    this.classList.remove('border-red-500/50');
                }
            });

            function getFileIcon(fileName) {
                const extension = fileName.split('.').pop().toLowerCase();
                const icons = {
                    'pdf': '📄',
                    'doc': '📝', 'docx': '📝',
                    'txt': '📄',
                    'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️',
                    'mp3': '🎵', 'wav': '🎵',
                    'mp4': '🎬', 'avi': '🎬',
                    'zip': '📦', 'rar': '📦'
                };
                return icons[extension] || '📎';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function formatMessage(message) {
                if (!message) return '';
                
                return message
                    .replace(/\*\*(.*?)\*\*/g, '<strong class="font-semibold text-white">$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em class="italic text-slate-300">$1</em>')
                    .replace(/`(.*?)`/g, '<code class="bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded text-sm font-mono border border-indigo-500/30">$1</code>')
                    .replace(/\[([^\]]+)\]$$([^)]+)$$/g, '<a href="$2" class="text-indigo-400 hover:text-indigo-300 underline transition-colors duration-200" target="_blank">$1</a>')
                    .replace(/\n/g, '<br>');
            }

            // Message handling
            function addMessage(message, isUser = false, isTyping = false, attachments = []) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `flex ${isUser ? 'justify-end' : 'justify-start'} mb-6 opacity-0`;
                
                let innerHtml = '';
                
                if (isUser) {
                    messageDiv.className += ' animate-slide-in-right';
                    innerHtml = `
                        <div class="flex items-start max-w-4xl">
                            <div class="px-5 py-4 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 order-2 ml-3 backdrop-blur-xl">
                                <p class="text-xs text-indigo-200 font-semibold mb-2 flex items-center">
                                    <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                                    You
                                </p>
                                <div class="text-white">
                                    <p class="whitespace-pre-wrap">${message}</p>
                                    ${attachments.length > 0 ? `
                                        <div class="mt-3 pt-3 border-t border-indigo-400/30">
                                            <p class="text-xs text-indigo-200 mb-2 font-medium">📎 Attached files:</p>
                                            <div class="space-y-2">
                                                ${attachments.map(file => `
                                                    <div class="flex items-center glass rounded-lg px-3 py-2 text-sm border border-white/20">
                                                        <span class="mr-2">${getFileIcon(file.name)}</span>
                                                        <span class="flex-1 truncate">${file.name}</span>
                                                        <span class="text-xs text-indigo-200 ml-2">${formatFileSize(file.size)}</span>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-gray-500 to-gray-700 flex items-center justify-center text-white order-1 flex-shrink-0 shadow-lg ring-2 ring-gray-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    `;
                } else if (isTyping) {
                    messageDiv.className += ' animate-bounce-in';
                    innerHtml = `
                        <div class="flex items-start max-w-4xl">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-3 flex-shrink-0 shadow-lg animate-pulse ring-2 ring-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="px-5 py-4 rounded-2xl glass border border-white/20 shadow-lg backdrop-blur-xl">
                                <p class="text-xs text-indigo-400 font-semibold mb-2 flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                    Assistant
                                </p>
                                <div class="typing-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.className += ' animate-slide-in-left';
                    innerHtml = `
                        <div class="flex items-start max-w-4xl">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-3 flex-shrink-0 shadow-lg ring-2 ring-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="px-5 py-4 rounded-2xl glass border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 backdrop-blur-xl">
                                <p class="text-xs text-indigo-400 font-semibold mb-2 flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                    Assistant
                                </p>
                                <div class="prose prose-sm max-w-none text-slate-300">
                                    <div class="whitespace-pre-wrap">${formatMessage(message)}</div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                messageDiv.innerHTML = innerHtml;
                
                if (isTyping) {
                    messageDiv.id = 'typing-indicator';
                }
                
                chatMessages.appendChild(messageDiv);
                
                // Animar la aparición
                setTimeout(() => {
                    messageDiv.classList.remove('opacity-0');
                    messageDiv.classList.add('opacity-100');
                }, 100);
                
                chatMessages.scrollTop = chatMessages.scrollHeight;
                return messageDiv;
            }

            // File handling
            function updateAttachmentsDisplay() {
                if (selectedFiles.length > 0) {
                    attachmentsArea.classList.remove('hidden');
                    attachmentsList.innerHTML = selectedFiles.map((file, index) => `
                        <div class="file-preview flex items-center glass border border-indigo-500/30 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-300 px-4 py-3 rounded-2xl text-sm shadow-lg hover:shadow-xl transition-all duration-300 backdrop-blur-xl">
                            <span class="text-lg mr-3">${getFileIcon(file.name)}</span>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium truncate text-white">${file.name}</p>
                                <p class="text-xs text-indigo-400">${formatFileSize(file.size)}</p>
                            </div>
                            <button type="button" onclick="removeFile(${index})" class="ml-3 text-indigo-400 hover:text-red-400 transition-colors duration-200 p-1 rounded-full hover:bg-red-500/10">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    `).join('');
                } else {
                    attachmentsArea.classList.add('hidden');
                }
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateAttachmentsDisplay();
                showNotification('File removed! 🗑️', 'info');
            };

            window.clearAllFiles = function() {
                selectedFiles = [];
                updateAttachmentsDisplay();
                showNotification('All files cleared! 🧹', 'info');
            };

            // Prompt Management Functions
            function loadPrompts() {
                fetch('{{ route('prompts.index') }}')
                    .then(response => response.json())
                    .then(prompts => {
                        allPrompts = prompts;
                        renderPrompts();
                    })
                    .catch(error => {
                        console.error('Error loading prompts:', error);
                        const promptsList = document.getElementById('prompts-list');
                        const mobilePromptsList = document.getElementById('mobile-prompts-list');
                        const errorHtml = `
                            <div class="flex items-center justify-center py-8 text-red-400">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm">Error loading prompts</p>
                                    <p class="text-xs text-red-300">Please try refreshing the page</p>
                                </div>
                            </div>
                        `;
                        promptsList.innerHTML = errorHtml;
                        if (mobilePromptsList) mobilePromptsList.innerHTML = errorHtml;
                    });
            }

            function renderPrompts() {
                const promptsList = document.getElementById('prompts-list');
                const mobilePromptsList = document.getElementById('mobile-prompts-list');
                
                // Clear both lists
                promptsList.innerHTML = '';
                if (mobilePromptsList) mobilePromptsList.innerHTML = '';
                
                let filteredPrompts = allPrompts.filter(prompt => {
                    const matchesCategory = currentFilter === 'all' || prompt.category === currentFilter;
                    const matchesSearch = !currentSearch || 
                        prompt.title.toLowerCase().includes(currentSearch.toLowerCase()) ||
                        prompt.content.toLowerCase().includes(currentSearch.toLowerCase());
                    return matchesCategory && matchesSearch;
                });
                
                if (filteredPrompts.length === 0) {
                    const emptyState = `
                        <div class="flex items-center justify-center py-8 text-slate-400">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm">${currentSearch || currentFilter !== 'all' ? 'No prompts found' : 'No prompts saved yet'}</p>
                                <p class="text-xs text-slate-500">${currentSearch || currentFilter !== 'all' ? 'Try adjusting your search or filters' : 'Type a message and click "Save Prompt" to get started'}</p>
                            </div>
                        </div>
                    `;
                    promptsList.innerHTML = emptyState;
                    if (mobilePromptsList) mobilePromptsList.innerHTML = emptyState;
                } else {
                    // Sort by favorites first, then by creation date
                    filteredPrompts.sort((a, b) => {
                        if (a.is_favorite && !b.is_favorite) return -1;
                        if (!a.is_favorite && b.is_favorite) return 1;
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
                    
                    filteredPrompts.forEach((prompt, index) => {
                        const promptCard = createPromptCard(prompt);
                        const mobilePromptCard = createPromptCard(prompt);
                        
                        promptCard.style.animationDelay = `${index * 0.1}s`;
                        promptCard.classList.add('animate-fade-in-up');
                        promptsList.appendChild(promptCard);
                        
                        if (mobilePromptsList) {
                            mobilePromptCard.style.animationDelay = `${index * 0.1}s`;
                            mobilePromptCard.classList.add('animate-fade-in-up');
                            mobilePromptsList.appendChild(mobilePromptCard);
                        }
                    });
                }
            }

            function createPromptCard(prompt) {
                const card = document.createElement('div');
                card.className = 'prompt-card rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-500 cursor-pointer group';
                card.setAttribute('data-category', prompt.category || 'General');
                card.setAttribute('data-title', prompt.title.toLowerCase());
                card.setAttribute('data-content', prompt.content.toLowerCase());
                card.innerHTML = `
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-300 shadow-sm border border-indigo-500/30">
                                    ${prompt.category || 'General'}
                                </span>
                                ${prompt.is_favorite ? '<span class="text-yellow-400 animate-pulse">⭐</span>' : ''}
                            </div>
                            <h5 class="text-sm font-bold text-white truncate mb-2 group-hover:text-indigo-400 transition-colors duration-300">${prompt.title}</h5>
                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed group-hover:text-slate-300 transition-colors duration-300">${prompt.content.substring(0, 120)}${prompt.content.length > 120 ? '...' : ''}</p>
                        </div>
                        <div class="flex items-center space-x-2 ml-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <button class="favorite-btn text-slate-500 hover:text-yellow-400 transition-all duration-300 transform hover:scale-125 hover:rotate-12" data-prompt-id="${prompt.id}">
                                <svg class="w-4 h-4 ${prompt.is_favorite ? 'text-yellow-400' : ''}" fill="${prompt.is_favorite ? 'currentColor' : 'none'}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </button>
                            <button class="delete-btn text-slate-500 hover:text-red-400 transition-all duration-300 transform hover:scale-125 hover:rotate-12" data-prompt-id="${prompt.id}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                
                // Add event listeners
                card.addEventListener('click', function(e) {
                    if (!e.target.closest('button')) {
                        messageInput.value = prompt.content;
                        messageInput.focus();
                        // Add visual feedback with enhanced animation
                        card.style.transform = 'scale(0.9) rotate(-2deg)';
                        card.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                        setTimeout(() => {
                            card.style.transform = '';
                            card.style.boxShadow = '';
                        }, 300);
                        
                        // Show success notification
                        showNotification(`Prompt "${prompt.title}" loaded! 🚀`, 'success');
                    }
                });
                
                // Favorite button
                card.querySelector('.favorite-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const promptId = this.getAttribute('data-prompt-id');
                    toggleFavorite(promptId);
                });
                
                // Delete button
                card.querySelector('.delete-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const promptId = this.getAttribute('data-prompt-id');
                    deletePrompt(promptId);
                });
                
                return card;
            }

            function showSavePromptModal(content) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in-up';
                modal.innerHTML = `
                    <div class="glass-dark rounded-2xl p-8 w-full max-w-lg mx-4 shadow-2xl transform animate-bounce-in border border-white/20">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-white">Save Prompt</h3>
                            <button type="button" class="close-modal text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-3">Title</label>
                                <input type="text" id="prompt-title" class="w-full p-4 glass border border-white/20 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-200 text-lg bg-transparent text-white placeholder-slate-400 backdrop-blur-xl" placeholder="Enter a descriptive title">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-3">Category</label>
                                <select id="prompt-category" class="w-full p-4 glass border border-white/20 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-200 text-lg bg-transparent text-white backdrop-blur-xl">
                                    <option value="Content" class="bg-gray-800 text-white">Content</option>
                                    <option value="SEO" class="bg-gray-800 text-white">SEO</option>
                                    <option value="Marketing" class="bg-gray-800 text-white">Marketing</option>
                                    <option value="Social Media" class="bg-gray-800 text-white">Social Media</option>
                                    <option value="Email" class="bg-gray-800 text-white">Email</option>
                                    <option value="General" class="bg-gray-800 text-white">General</option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="button" class="close-modal px-6 py-3 text-slate-400 hover:text-slate-300 transition-colors duration-200 font-medium">
                                    Cancel
                                </button>
                                <button type="button" class="save-prompt-btn px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-medium transform hover:scale-105 shadow-lg">
                                    Save Prompt
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Add event listeners
                modal.querySelectorAll('.close-modal').forEach(btn => {
                    btn.addEventListener('click', () => modal.remove());
                });
                modal.querySelector('.save-prompt-btn').addEventListener('click', () => {
                    savePrompt(content, modal);
                });
                
                // Close on backdrop click
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.remove();
                });
                
                // Enter key to save
                document.getElementById('prompt-title').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        savePrompt(content, modal);
                    }
                });
                
                document.getElementById('prompt-title').focus();
            }

            function savePrompt(content, modal) {
                const title = document.getElementById('prompt-title').value.trim();
                const category = document.getElementById('prompt-category').value;
                
                if (!title) {
                    showNotification('Please enter a title for the prompt', 'error');
                    return;
                }

                // Show loading state
                const saveBtn = modal.querySelector('.save-prompt-btn');
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...';
                saveBtn.disabled = true;

                fetch('{{ route('prompts.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: title,
                        content: content,
                        category: category
                    })
                })
                .then(response => response.json())
                .then(data => {
                    modal.remove();
                    allPrompts.unshift(data);
                    renderPrompts();
                    showNotification('Prompt saved successfully! 🎉', 'success');
                })
                .catch(error => {
                    console.error('Error saving prompt:', error);
                    showNotification('Error saving prompt. Please try again.', 'error');
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
            }

            function toggleFavorite(promptId) {
                fetch(`{{ route('prompts.index') }}/${promptId}/toggle-favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const promptIndex = allPrompts.findIndex(p => p.id == promptId);
                    if (promptIndex !== -1) {
                        allPrompts[promptIndex].is_favorite = data.is_favorite;
                    }
                    renderPrompts();
                    showNotification(data.is_favorite ? 'Added to favorites! ⭐' : 'Removed from favorites', 'success');
                })
                .catch(error => {
                    console.error('Error toggling favorite:', error);
                    showNotification('Error updating favorite status', 'error');
                });
            }

            function deletePrompt(promptId) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in-up';
                modal.innerHTML = `
                    <div class="glass-dark rounded-2xl p-8 w-full max-w-md mx-4 shadow-2xl transform animate-bounce-in border border-white/20">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-500/20 mb-4 border border-red-500/30">
                                <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">Delete Prompt</h3>
                            <p class="text-sm text-slate-400 mb-6">Are you sure you want to delete this prompt? This action cannot be undone.</p>
                            <div class="flex justify-center space-x-4">
                                <button type="button" class="cancel-delete px-4 py-2 text-slate-400 hover:text-slate-300 transition-colors duration-200 font-medium">
                                    Cancel
                                </button>
                                <button type="button" class="confirm-delete px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                modal.querySelector('.cancel-delete').addEventListener('click', () => modal.remove());
                modal.querySelector('.confirm-delete').addEventListener('click', () => {
                    modal.remove();
                    
                    fetch(`{{ route('prompts.index') }}/${promptId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        allPrompts = allPrompts.filter(p => p.id != promptId);
                        renderPrompts();
                        showNotification('Prompt deleted successfully! 🗑️', 'success');
                    })
                    .catch(error => {
                        console.error('Error deleting prompt:', error);
                        showNotification('Error deleting prompt. Please try again.', 'error');
                    });
                });
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.remove();
                });
            }

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                const colors = {
                    success: 'from-emerald-500 to-green-600 border-emerald-400',
                    error: 'from-red-500 to-pink-600 border-red-400',
                    info: 'from-blue-500 to-indigo-600 border-blue-400'
                };
                
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-500 translate-x-full bg-gradient-to-r ${colors[type]} text-white border-2 max-w-sm glass backdrop-blur-xl`;
                
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
                }, 100);
                
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 500);
                }, 4000);
            }

            // Chat functionality
            function sendMessage(event) {
                if (event) {
                    event.preventDefault();
                }
                
                const message = messageInput.value.trim();
                if (!message && selectedFiles.length === 0) return;

                // Deshabilitar botón de envío
                sendButton.disabled = true;
                sendButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending...
                `;

                const selectedModel = document.querySelector('input[name="ai_model"]:checked').value;
                const formData = new FormData();
                formData.append('message', message);
                formData.append('ai_model', selectedModel);
                formData.append('_token', csrfToken);

                const currentFiles = [...selectedFiles];
                selectedFiles.forEach(file => {
                    formData.append('attachments[]', file);
                });

                messageInput.value = '';
                selectedFiles = [];
                updateAttachmentsDisplay();

                addMessage(message, true, false, currentFiles);
                const typingIndicator = addMessage('', false, true);

                // Actualizar contador de mensajes
                messageCount.textContent = messageCounter++;

                fetch('{{ route('generate.chat') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server error: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        typingIndicator.remove();
                        addMessage(data.response, false);
                        messageCount.textContent = messageCounter++;
                        showNotification('Response received! ✨', 'success');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        typingIndicator.remove();
                        addMessage('Sorry, there was an error processing your message. Please try again.', false);
                        showNotification('Error occurred! Please try again. ⚠️', 'error');
                    })
                    .finally(() => {
                        // Rehabilitar botón de envío
                        sendButton.disabled = false;
                        sendButton.innerHTML = `
                            <span class="mr-2 font-semibold">Send</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        `;
                    });
            }

            // Event listeners for chat
            chatForm.addEventListener('submit', sendMessage);
            sendButton.addEventListener('click', sendMessage);

            // Enviar con Enter
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            attachButton.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);
                selectedFiles = selectedFiles.concat(files);
                updateAttachmentsDisplay();
                fileInput.value = '';
                
                // Mostrar notificación de archivos agregados
                if (files.length > 0) {
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-bounce-in';
                    notification.textContent = `${files.length} file(s) added`;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            });

            // Drag and drop
            chatMessages.addEventListener('dragover', (e) => {
                e.preventDefault();
                chatMessages.classList.add('bg-indigo-50', 'border-2', 'border-dashed', 'border-indigo-300');
            });

            chatMessages.addEventListener('dragleave', (e) => {
                e.preventDefault();
                chatMessages.classList.remove('bg-indigo-50', 'border-2', 'border-dashed', 'border-indigo-300');
            });

            chatMessages.addEventListener('drop', (e) => {
                e.preventDefault();
                chatMessages.classList.remove('bg-indigo-50', 'border-2', 'border-dashed', 'border-indigo-300');
                
                const files = Array.from(e.dataTransfer.files);
                selectedFiles = selectedFiles.concat(files);
                updateAttachmentsDisplay();
            });

            messageInput.focus();

            // Prompt Management Functions
            function loadPrompts() {
                fetch('{{ route('prompts.index') }}')
                    .then(response => response.json())
                    .then(prompts => {
                        allPrompts = prompts;
                        renderPrompts();
                    })
                    .catch(error => {
                        console.error('Error loading prompts:', error);
                        const promptsList = document.getElementById('prompts-list');
                        promptsList.innerHTML = `
                            <div class="flex items-center justify-center py-8 text-red-500">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm">Error loading prompts</p>
                                    <p class="text-xs text-red-400">Please try refreshing the page</p>
                                </div>
                            </div>
                        `;
                    });
            }

            function renderPrompts() {
                const promptsList = document.getElementById('prompts-list');
                const mobilePromptsList = document.getElementById('mobile-prompts-list');
                
                // Clear both lists
                promptsList.innerHTML = '';
                mobilePromptsList.innerHTML = '';
                
                let filteredPrompts = allPrompts.filter(prompt => {
                    const matchesCategory = currentFilter === 'all' || prompt.category === currentFilter;
                    const matchesSearch = !currentSearch || 
                        prompt.title.toLowerCase().includes(currentSearch.toLowerCase()) ||
                        prompt.content.toLowerCase().includes(currentSearch.toLowerCase());
                    return matchesCategory && matchesSearch;
                });
                
                if (filteredPrompts.length === 0) {
                    const emptyState = `
                        <div class="flex items-center justify-center py-8 text-gray-500">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm">${currentSearch || currentFilter !== 'all' ? 'No prompts found' : 'No prompts saved yet'}</p>
                                <p class="text-xs text-gray-400">${currentSearch || currentFilter !== 'all' ? 'Try adjusting your search or filters' : 'Type a message and click "Save Prompt" to get started'}</p>
                            </div>
                        </div>
                    `;
                    promptsList.innerHTML = emptyState;
                    mobilePromptsList.innerHTML = emptyState;
                } else {
                    // Sort by favorites first, then by creation date
                    filteredPrompts.sort((a, b) => {
                        if (a.is_favorite && !b.is_favorite) return -1;
                        if (!a.is_favorite && b.is_favorite) return 1;
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
                    
                    filteredPrompts.forEach((prompt, index) => {
                        const promptCard = createPromptCard(prompt);
                        const mobilePromptCard = createPromptCard(prompt);
                        
                        promptCard.style.animationDelay = `${index * 0.1}s`;
                        promptCard.classList.add('animate-slide-in-up');
                        promptsList.appendChild(promptCard);
                        
                        mobilePromptCard.style.animationDelay = `${index * 0.1}s`;
                        mobilePromptCard.classList.add('animate-slide-in-up');
                        mobilePromptsList.appendChild(mobilePromptCard);
                    });
                }
            }

            function createPromptCard(prompt) {
                const card = document.createElement('div');
                card.className = 'prompt-card rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-500 cursor-pointer group hover-lift';
                card.setAttribute('data-category', prompt.category || 'General');
                card.setAttribute('data-title', prompt.title.toLowerCase());
                card.setAttribute('data-content', prompt.content.toLowerCase());
                card.innerHTML = `
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-300 shadow-sm border border-indigo-500/30">
                                    ${prompt.category || 'General'}
                                </span>
                                ${prompt.is_favorite ? '<span class="text-yellow-400 animate-pulse">⭐</span>' : ''}
                            </div>
                            <h5 class="text-sm font-bold text-white truncate mb-2 group-hover:text-indigo-400 transition-colors duration-300">${prompt.title}</h5>
                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed group-hover:text-slate-300 transition-colors duration-300">${prompt.content.substring(0, 120)}${prompt.content.length > 120 ? '...' : ''}</p>
                        </div>
                        <div class="flex items-center space-x-2 ml-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <button class="favorite-btn text-slate-500 hover:text-yellow-400 transition-all duration-300 transform hover:scale-125 hover:rotate-12" data-prompt-id="${prompt.id}">
                                <svg class="w-4 h-4 ${prompt.is_favorite ? 'text-yellow-400' : ''}" fill="${prompt.is_favorite ? 'currentColor' : 'none'}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </button>
                            <button class="delete-btn text-slate-500 hover:text-red-400 transition-all duration-300 transform hover:scale-125 hover:rotate-12" data-prompt-id="${prompt.id}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                
                // Add event listeners
                card.addEventListener('click', function(e) {
                    if (!e.target.closest('button')) {
                        messageInput.value = prompt.content;
                        messageInput.focus();
                        // Add visual feedback with enhanced animation
                        card.style.transform = 'scale(0.9) rotate(-2deg)';
                        card.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                        setTimeout(() => {
                            card.style.transform = '';
                            card.style.boxShadow = '';
                        }, 300);
                        
                        // Show success notification
                        showNotification(`Prompt "${prompt.title}" loaded! 🚀`, 'success');
                    }
                });
                
                // Favorite button
                card.querySelector('.favorite-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const promptId = this.getAttribute('data-prompt-id');
                    toggleFavorite(promptId);
                });
                
                // Delete button
                card.querySelector('.delete-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const promptId = this.getAttribute('data-prompt-id');
                    deletePrompt(promptId);
                });
                
                return card;
            }

            function showSavePromptModal(content) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in';
                modal.innerHTML = `
                    <div class="glass-dark rounded-2xl p-8 w-full max-w-lg mx-4 shadow-2xl transform animate-scale-in border border-white/20">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-white">Save Prompt</h3>
                            <button type="button" class="close-modal text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-3">Title</label>
                                <input type="text" id="prompt-title" class="w-full p-4 glass border border-white/20 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg text-white placeholder:text-slate-400" placeholder="Enter a descriptive title">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-3">Category</label>
                                <select id="prompt-category" class="w-full p-4 glass border border-white/20 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg text-white bg-gray-800/50">
                                    <option value="Content" class="bg-gray-800 text-white">Content</option>
                                    <option value="SEO" class="bg-gray-800 text-white">SEO</option>
                                    <option value="Marketing" class="bg-gray-800 text-white">Marketing</option>
                                    <option value="Social Media" class="bg-gray-800 text-white">Social Media</option>
                                    <option value="Email" class="bg-gray-800 text-white">Email</option>
                                    <option value="General" class="bg-gray-800 text-white">General</option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="button" class="close-modal px-6 py-3 text-slate-400 hover:text-slate-300 transition-colors duration-200 font-medium">
                                    Cancel
                                </button>
                                <button type="button" class="save-prompt-btn px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-medium transform hover:scale-105 shadow-lg">
                                    Save Prompt
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Add event listeners
                modal.querySelector('.close-modal').addEventListener('click', () => modal.remove());
                modal.querySelector('.save-prompt-btn').addEventListener('click', () => {
                    savePrompt(content, modal);
                });
                
                // Close on backdrop click
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.remove();
                });
                
                // Enter key to save
                document.getElementById('prompt-title').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        savePrompt(content, modal);
                    }
                });
                
                document.getElementById('prompt-title').focus();
            }

            function savePrompt(content, modal) {
                const title = document.getElementById('prompt-title').value.trim();
                const category = document.getElementById('prompt-category').value;
                
                if (!title) {
                    showNotification('Please enter a title for the prompt', 'error');
                    return;
                }

                // Show loading state
                const saveBtn = modal.querySelector('.save-prompt-btn');
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...';
                saveBtn.disabled = true;

                fetch('{{ route('prompts.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: title,
                        content: content,
                        category: category
                    })
                })
                .then(response => response.json())
                .then(data => {
                    modal.remove();
                    // Add the new prompt to allPrompts array
                    allPrompts.unshift(data);
                    renderPrompts();
                    showNotification('Prompt saved successfully! 🎉', 'success');
                })
                .catch(error => {
                    console.error('Error saving prompt:', error);
                    showNotification('Error saving prompt. Please try again.', 'error');
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
            }

            function toggleFavorite(promptId) {
                fetch(`{{ route('prompts.index') }}/${promptId}/toggle-favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update the prompt in allPrompts array
                    const promptIndex = allPrompts.findIndex(p => p.id == promptId);
                    if (promptIndex !== -1) {
                        allPrompts[promptIndex].is_favorite = data.is_favorite;
                    }
                    renderPrompts();
                    showNotification(data.is_favorite ? 'Added to favorites! ⭐' : 'Removed from favorites', 'success');
                })
                .catch(error => {
                    console.error('Error toggling favorite:', error);
                    showNotification('Error updating favorite status', 'error');
                });
            }

            function deletePrompt(promptId) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in';
                modal.innerHTML = `
                    <div class="glass-dark rounded-2xl p-8 w-full max-w-md mx-4 shadow-2xl transform animate-scale-in border border-white/20">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-500/20 mb-4 border border-red-500/30">
                                <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">Delete Prompt</h3>
                            <p class="text-sm text-slate-400 mb-6">Are you sure you want to delete this prompt? This action cannot be undone.</p>
                            <div class="flex justify-center space-x-4">
                                <button type="button" class="cancel-delete px-4 py-2 text-slate-400 hover:text-slate-300 transition-colors duration-200 font-medium">
                                    Cancel
                                </button>
                                <button type="button" class="confirm-delete px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                modal.querySelector('.cancel-delete').addEventListener('click', () => modal.remove());
                modal.querySelector('.confirm-delete').addEventListener('click', () => {
                    modal.remove();
                    
                    fetch(`{{ route('prompts.index') }}/${promptId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove the prompt from allPrompts array
                        allPrompts = allPrompts.filter(p => p.id != promptId);
                        renderPrompts();
                        showNotification('Prompt deleted successfully! 🗑️', 'success');
                    })
                    .catch(error => {
                        console.error('Error deleting prompt:', error);
                        showNotification('Error deleting prompt. Please try again.', 'error');
                    });
                });
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.remove();
                });
            }

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-4 rounded-xl shadow-lg z-50 transform transition-all duration-300 ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">${type === 'success' ? '✅' : '❌'}</span>
                        <span class="font-medium">${message}</span>
                    </div>
                `;
                document.body.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Initialize prompts
            loadPrompts();
            
            // Save prompt button
            document.getElementById('save-prompt-btn').addEventListener('click', function() {
                const currentMessage = messageInput.value.trim();
                if (currentMessage) {
                    showSavePromptModal(currentMessage);
                } else {
                    showNotification('Please enter a message to save as a prompt', 'error');
                }
            });

            // Search functionality
            document.getElementById('prompt-search').addEventListener('input', function() {
                currentSearch = this.value;
                renderPrompts();
            });

            // Clear search
            document.getElementById('clear-search').addEventListener('click', function() {
                document.getElementById('prompt-search').value = '';
                currentSearch = '';
                renderPrompts();
            });

            // Filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('active', 'bg-indigo-600', 'text-white');
                        b.classList.add('bg-gray-700', 'text-gray-300');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-gray-700', 'text-gray-300');
                    this.classList.add('active', 'bg-indigo-600', 'text-white');
                    
                    currentFilter = this.getAttribute('data-category');
                    renderPrompts();
                });
            });

            // Mobile sidebar functionality
            document.getElementById('toggle-prompts-btn').addEventListener('click', function() {
                const sidebar = document.getElementById('mobile-prompts-sidebar');
                const sidebarContent = sidebar.querySelector('div');
                sidebar.classList.remove('hidden');
                setTimeout(() => {
                    sidebarContent.style.transform = 'translateX(0)';
                }, 10);
            });

            document.getElementById('close-mobile-prompts').addEventListener('click', function() {
                const sidebar = document.getElementById('mobile-prompts-sidebar');
                const sidebarContent = sidebar.querySelector('div');
                sidebarContent.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    sidebar.classList.add('hidden');
                }, 500);
            });

            // Close mobile sidebar when clicking outside
            document.getElementById('mobile-prompts-sidebar').addEventListener('click', function(e) {
                if (e.target === this) {
                    const sidebarContent = this.querySelector('div');
                    sidebarContent.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        this.classList.add('hidden');
                    }, 500);
                }
            });

            // Mobile search functionality
            document.getElementById('mobile-prompt-search').addEventListener('input', function() {
                currentSearch = this.value;
                renderPrompts();
            });

            document.getElementById('mobile-clear-search').addEventListener('click', function() {
                document.getElementById('mobile-prompt-search').value = '';
                currentSearch = '';
                renderPrompts();
            });

            // Mobile filter buttons
            document.querySelectorAll('.mobile-filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all mobile buttons
                    document.querySelectorAll('.mobile-filter-btn').forEach(b => {
                        b.classList.remove('active', 'bg-indigo-600', 'text-white');
                        b.classList.add('bg-gray-700', 'text-gray-300');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-gray-700', 'text-gray-300');
                    this.classList.add('active', 'bg-indigo-600', 'text-white');
                    
                    currentFilter = this.getAttribute('data-category');
                    renderPrompts();
                });
            });
        }); // Cierre del DOMContentLoaded
    </script>
    @endpush
</x-app-layout>
