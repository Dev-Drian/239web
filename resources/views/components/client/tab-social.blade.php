<div id="social-tab" class="tab-content hidden">
    <div class="p-8 bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl" id="tab-social">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Social Media Links</h2>
            <p class="text-gray-600">Connect your social media profiles to boost your online presence</p>
        </div>
        
        <!-- Add New Social Link Form -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8 hover:shadow-xl transition-all duration-300">
            <div class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Choose Platform</label>
                    <div class="relative">
                        <select id="social_type" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 pr-12 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 appearance-none cursor-pointer hover:border-gray-300">
                            <option value="">Select a platform...</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">LinkedIn</option>
                            <option value="twitter">Twitter / X</option>
                            <option value="youtube">YouTube</option>
                            <option value="tiktok">TikTok</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="telegram">Telegram</option>
                            <option value="discord">Discord</option>
                            <option value="github">GitHub</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex-2 min-w-0">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Profile URL</label>
                    <div class="relative">
                        <input type="url" id="social_url" 
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                               placeholder="Enter your profile URL...">
                        <div id="url_preview" class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none opacity-0 transition-opacity duration-200">
                            <div class="w-5 h-5 rounded-full bg-gray-200"></div>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="addSocialBtn" 
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Link
                </button>
            </div>
            
            <input type="hidden" name="social_media_array" id="social_media_array" value="[]">
        </div>

        <!-- Social Links Display -->
        <div class="space-y-4" id="socialLinksContainer">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Your Social Links</h3>
                <div class="text-sm text-gray-500">
                    <span id="linkCount">0</span> links configured
                </div>
            </div>
            
            <div id="socialLinksGrid" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Social links will be added here dynamically -->
            </div>
            
            <div id="emptyState" class="text-center py-16 px-6">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.102m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <h4 class="text-xl font-semibold text-gray-900 mb-2">No social links yet</h4>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">Start building your social presence by adding your first social media profile link above.</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Facebook</span>
                    <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-medium">Instagram</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">LinkedIn</span>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">YouTube</span>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('addSocialBtn');
        const typeInput = document.getElementById('social_type');
        const urlInput = document.getElementById('social_url');
        const linksGrid = document.getElementById('socialLinksGrid');
        const hiddenInput = document.getElementById('social_media_array');
        const emptyState = document.getElementById('emptyState');
        const linkCount = document.getElementById('linkCount');
        const urlPreview = document.getElementById('url_preview');
        
        let socialArray = [];

        // Cargar los social links desde el backend si existen
        @if(isset($client) && $client->clientSocialProfiles && $client->clientSocialProfiles->count())
            socialArray = @json($client->clientSocialProfiles->map(fn($s) => ['type' => $s->type, 'url' => $s->url]));
            hiddenInput.value = JSON.stringify(socialArray);
            setTimeout(() => {
                socialArray.forEach(({type, url}) => {
                    const card = createSocialCard(type, url);
                    linksGrid.appendChild(card);
                });
                updateUI();
            }, 100);
        @endif

        // Enhanced social platform data
        const socialPlatforms = {
            facebook: {
                name: 'Facebook',
                color: 'from-blue-600 to-blue-700',
                textColor: 'text-blue-600',
                bgColor: 'bg-blue-50',
                placeholder: 'https://facebook.com/yourprofile',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>'
            },
            instagram: {
                name: 'Instagram',
                color: 'from-pink-500 to-purple-600',
                textColor: 'text-pink-600',
                bgColor: 'bg-pink-50',
                placeholder: 'https://instagram.com/yourusername',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-2.458 0-4.467-2.01-4.467-4.468s2.009-4.467 4.467-4.467c2.458 0 4.468 2.009 4.468 4.467s-2.01 4.468-4.468 4.468z"/></svg>'
            },
            linkedin: {
                name: 'LinkedIn',
                color: 'from-blue-700 to-blue-800',
                textColor: 'text-blue-700',
                bgColor: 'bg-blue-50',
                placeholder: 'https://linkedin.com/in/yourprofile',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'
            },
            twitter: {
                name: 'Twitter / X',
                color: 'from-gray-800 to-black',
                textColor: 'text-gray-800',
                bgColor: 'bg-gray-50',
                placeholder: 'https://twitter.com/yourusername',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>'
            },
            youtube: {
                name: 'YouTube',
                color: 'from-red-600 to-red-700',
                textColor: 'text-red-600',
                bgColor: 'bg-red-50',
                placeholder: 'https://youtube.com/@yourchannel',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
            },
            tiktok: {
                name: 'TikTok',
                color: 'from-black to-gray-800',
                textColor: 'text-black',
                bgColor: 'bg-gray-50',
                placeholder: 'https://tiktok.com/@yourusername',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>'
            },
            whatsapp: {
                name: 'WhatsApp',
                color: 'from-green-600 to-green-700',
                textColor: 'text-green-600',
                bgColor: 'bg-green-50',
                placeholder: 'https://wa.me/1234567890',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.085"/></svg>'
            },
            telegram: {
                name: 'Telegram',
                color: 'from-blue-500 to-blue-600',
                textColor: 'text-blue-500',
                bgColor: 'bg-blue-50',
                placeholder: 'https://t.me/yourusername',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>'
            },
            discord: {
                name: 'Discord',
                color: 'from-indigo-600 to-purple-600',
                textColor: 'text-indigo-600',
                bgColor: 'bg-indigo-50',
                placeholder: 'https://discord.gg/yourinvite',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419-.0002 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1568 2.4189Z"/></svg>'
            },
            github: {
                name: 'GitHub',
                color: 'from-gray-800 to-black',
                textColor: 'text-gray-800',
                bgColor: 'bg-gray-50',
                placeholder: 'https://github.com/yourusername',
                icon: '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>'
            }
        };

        function updateUI() {
            linkCount.textContent = socialArray.length;
            emptyState.style.display = socialArray.length === 0 ? 'block' : 'none';
            linksGrid.style.display = socialArray.length === 0 ? 'none' : 'grid';
            
            // Update button state
            const selectedType = typeInput.value;
            const url = urlInput.value.trim();
            const exists = socialArray.some(item => item.type === selectedType);
            
            addBtn.disabled = !selectedType || !url || exists;
            addBtn.innerHTML = exists ? 
                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Already Added' :
                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>Add Link';
        }

        function createSocialCard(type, url) {
            const platform = socialPlatforms[type];
            const card = document.createElement('div');
            card.className = 'group bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1';
            card.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-r ${platform.color} flex items-center justify-center text-white shadow-lg">
                            ${platform.icon}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">${platform.name}</h4>
                            <p class="text-sm text-gray-500">Social Profile</p>
                        </div>
                    </div>
                    <button type="button" class="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" 
                            onclick="removeSocialLink('${type}')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <a href="${url}" target="_blank" 
                       class="block text-sm text-gray-600 hover:${platform.textColor} transition-colors duration-200 truncate font-medium">
                        ${url}
                    </a>
                    <div class="flex gap-2">
                        <a href="${url}" target="_blank" 
                           class="flex-1 bg-gradient-to-r ${platform.color} text-white px-4 py-2 rounded-lg text-sm font-medium text-center hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                            Visit Profile
                        </a>
                        <button type="button" onclick="copyToClipboard('${url}')" 
                                class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all duration-200">
                            Copy
                        </button>
                    </div>
                </div>
            `;
            return card;
        }

        // Event listeners
        typeInput.addEventListener('change', function() {
            const platform = socialPlatforms[this.value];
            if (platform) {
                urlInput.placeholder = platform.placeholder;
                urlPreview.style.opacity = '1';
            } else {
                urlInput.placeholder = 'Enter your profile URL...';
                urlPreview.style.opacity = '0';
            }
            updateUI();
        });

        urlInput.addEventListener('input', updateUI);

        addBtn.addEventListener('click', function() {
            const type = typeInput.value;
            const url = urlInput.value.trim();
            
            if (!type || !url) {
                showNotification('Please select a platform and enter a URL', 'error');
                return;
            }
            
            if (!/^https?:\/\/.+\..+/.test(url)) {
                showNotification('Please enter a valid URL starting with http:// or https://', 'error');
                return;
            }

            const exists = socialArray.some(item => item.type === type);
            if (exists) {
                showNotification('This platform is already added. Remove it first to update.', 'warning');
                return;
            }

            // Add to array
            socialArray.push({type, url});
            hiddenInput.value = JSON.stringify(socialArray);
            
            // Add to UI
            const card = createSocialCard(type, url);
            linksGrid.appendChild(card);
            
            // Reset form
            urlInput.value = '';
            typeInput.value = '';
            urlInput.placeholder = 'Enter your profile URL...';
            
            updateUI();
            showNotification('Social link added successfully!', 'success');
        });

        // Global functions
        window.removeSocialLink = function(type) {
            socialArray = socialArray.filter(item => item.type !== type);
            hiddenInput.value = JSON.stringify(socialArray);
            
            // Remove from UI
            const cards = linksGrid.children;
            for (let card of cards) {
                if (card.querySelector(`button[onclick="removeSocialLink('${type}')"]`)) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => card.remove(), 200);
                    break;
                }
            }
            
            updateUI();
            showNotification('Social link removed', 'info');
        };

        window.copyToClipboard = function(text) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification('URL copied to clipboard!', 'success');
            });
        };

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            
            notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => notification.style.transform = 'translateX(0)', 100);
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Initialize
        updateUI();
    });
    </script>

    <style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #socialLinksGrid > div {
        animation: slideIn 0.3s ease-out;
    }

    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    </style>
</div>