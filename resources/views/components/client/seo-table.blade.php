<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        @include('components.header', ['name' => 'SEO Clients Dashboard'])
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 rounded-2xl shadow-xl mb-8 p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h1 class="text-white text-2xl lg:text-3xl font-bold mb-2">SEO Clients Overview</h1>
                        <p class="text-blue-100 text-sm lg:text-base">Monitor and manage your clients' SEO performance
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('client.index') }}"
                            class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl shadow-lg hover:bg-white/30 font-semibold transition-all duration-300 flex items-center gap-2 border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Clients
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Clients</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $clients->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">With Social Media</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $clients->filter(fn($c) => $c->clientSocialProfiles && $c->clientSocialProfiles->count() > 0)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">With Citations</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $clients->filter(fn($c) => $c->clientExtra && $c->clientExtra->citations)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Recent Press Releases</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $clients->filter(fn($c) => $c->pressReleases && $c->pressReleases->count() > 0)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 011 1v1m4 0h2a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h2m-4 9h.01M5 19h.01" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6 mb-8">
                <div class="flex flex-col gap-4 items-start justify-between">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search clients..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert -->
            <div id="pressReleaseAlert" class="hidden mb-4"></div>
            <!-- Main Table -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                            <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Client
                                        </div>
                                    </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2" />
                                        </svg>
                                        Social Media
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Last Blog Post
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 011 1v1m4 0h2a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h2m-4 9h.01M5 19h.01" />
                                        </svg>
                                        Press Release
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Citation Form
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="clientsTableBody" class="divide-y divide-gray-100">
                            @forelse ($clients as $client)
                                <tr class="hover:bg-blue-50/50 transition-all duration-200 client-row"
                                    data-client-name="{{ strtolower($client->name) }}">
                                    <!-- Client Name -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($client->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 text-lg">{{ $client->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">Client ID: #{{ $client->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Social Media -->
                                    <td class="px-6 py-6">
                                        @if ($client->clientSocialProfiles && $client->clientSocialProfiles->count() > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($client->clientSocialProfiles as $social)
                                                    @php
                                                        $socialIcons = [
                                                            'facebook' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                                                'color' => 'bg-blue-600 hover:bg-blue-700',
                                                            ],
                                                            'instagram' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-2.458 0-4.467-2.01-4.467-4.468s2.009-4.467 4.467-4.467c2.458 0 4.468 2.009 4.468 4.467s-2.01 4.468-4.468 4.468z"/></svg>',
                                                                'color' =>
                                                                    'bg-gradient-to-br from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700',
                                                            ],
                                                            'linkedin' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                                                                'color' => 'bg-blue-700 hover:bg-blue-800',
                                                            ],
                                                            'twitter' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                                                                'color' => 'bg-gray-800 hover:bg-black',
                                                            ],
                                                            'youtube' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                                                                'color' => 'bg-red-600 hover:bg-red-700',
                                                            ],
                                                            'tiktok' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
                                                                'color' => 'bg-black hover:bg-gray-800',
                                                            ],
                                                            'whatsapp' => [
                                                                'icon' =>
                                                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.085"/></svg>',
                                                                'color' => 'bg-green-600 hover:bg-green-700',
                                                            ],
                                                        ];
                                                        $iconData = $socialIcons[$social->type] ?? [
                                                            'icon' =>
                                                                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                                                            'color' => 'bg-gray-400',
                                                        ];
                                                    @endphp
                                                    <a href="{{ $social->url }}" target="_blank"
                                                        class="group relative inline-flex items-center justify-center w-10 h-10 {{ $iconData['color'] }} text-white rounded-xl shadow-lg transition-all duration-300 transform hover:scale-110"
                                                        title="{{ ucfirst($social->type) }}">
                                                        {!! $iconData['icon'] !!}
                                                        <div
                                                            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                            {{ ucfirst($social->type) }}
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $client->clientSocialProfiles->count() }}
                                                    platform{{ $client->clientSocialProfiles->count() !== 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z" />
                                                </svg>
                                                <span class="text-sm">No social media</span>
                                            </div>
                                        @endif
                                    </td>

                                 

                                    <!-- Last Blog Post -->
                                    <td class="px-6 py-6">
                                        @if ($client->clientSeo && $client->clientSeo->last_blog_post)
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                                <span
                                                    class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($client->clientSeo->last_blog_post)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($client->clientSeo->last_blog_post)->diffForHumans() }}
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 text-gray-400">
                                                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                                <span class="text-sm">No blog posts</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Press Release & Calendar -->
                                    <td class="px-6 py-6">
                                        @if ($client->pressReleases && $client->pressReleases->count())
                                            <a href="{{ route('press.show', $client->pressReleases->last()->id) }}"
                                                class="group flex items-start gap-2 p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-all duration-200">
                                                <div
                                                    class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div
                                                        class="text-sm font-medium text-gray-900 group-hover:text-blue-700 transition-colors duration-200 truncate">
                                                        {{ $client->pressReleases->last()->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $client->pressReleases->last()->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="flex items-center gap-2 text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="text-sm">No press releases</span>
                                            </div>
                                        @endif
                                        <div class="mt-3 flex items-center gap-1">
                                            <input type="date" name="press_release"
                                                value="{{ $client->press_release }}" placeholder="Fecha"
                                                class="press-release-input border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring focus:ring-blue-200 w-32"
                                                data-client-id="{{ $client->id }}" />
                                            <button type="button"
                                                class="press-release-update-btn bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700 transition text-xs flex items-center gap-1"
                                                data-client-id="{{ $client->id }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Guardar
                                            </button>
                                            <span class="press-release-update-status text-xs ml-2"></span>
                                        </div>
                                    </td>

                                    <!-- Citation Form -->
                                    <td class="px-6 py-6">
                                        @if ($client->clientCitationSubmissions && $client->clientCitationSubmissions->count())
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                YES ({{ $client->clientCitationSubmissions->count() }})
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                Not sent
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No clients found</h3>
                                            <p class="text-gray-500 mb-6">Get started by adding your first SEO client.
                                            </p>
                                            <a href="{{ route('client.create') }}"
                                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Add Client
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination if needed -->
            @if ($clients->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $clients->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('clientsTableBody');
            const rows = tableBody.querySelectorAll('.client-row');
            const alertDiv = document.getElementById('pressReleaseAlert');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const clientName = row.dataset.clientName;
                    row.style.display = clientName.includes(searchTerm) ? '' : 'none';
                });
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);

            // AJAX press release update
            document.querySelectorAll('.press-release-update-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const clientId = btn.getAttribute('data-client-id');
                    const input = document.querySelector('.press-release-input[data-client-id="' + clientId + '"]');
                    const value = input.value;
                    btn.disabled = true;
                    const url = "{{ route('client.pressRelease', ':id') }}".replace(':id', clientId);
                    fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ press_release: value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        btn.disabled = false;
                        if (data.success) {
                            alertDiv.innerHTML = '<span class="inline-flex items-center px-4 py-2 rounded text-sm font-semibold bg-green-100 text-green-700 border border-green-200"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Saved successfully!</span>';
                            alertDiv.classList.remove('hidden');
                            setTimeout(() => { alertDiv.classList.add('hidden'); }, 2500);
                        } else {
                            alertDiv.innerHTML = '<span class="inline-flex items-center px-4 py-2 rounded text-sm font-semibold bg-red-100 text-red-700 border border-red-200"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Error saving!</span>';
                            alertDiv.classList.remove('hidden');
                            setTimeout(() => { alertDiv.classList.add('hidden'); }, 2500);
                        }
                    })
                    .catch(() => {
                        btn.disabled = false;
                        alertDiv.innerHTML = '<span class="inline-flex items-center px-4 py-2 rounded text-sm font-semibold bg-red-100 text-red-700 border border-red-200"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Error saving!</span>';
                        alertDiv.classList.remove('hidden');
                        setTimeout(() => { alertDiv.classList.add('hidden'); }, 2500);
                    });
                });
            });
        });
    </script>
</x-app-layout>
