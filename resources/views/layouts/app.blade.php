<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        // Use provided SEO data or generate defaults
        if (!isset($seoData)) {
            $seoService = app(\App\Services\SeoService::class);
            $seoData = $seoService->generateMetaTags([
                'title' => $page->meta_title ?? $page->title ?? 'FPSociety - Ultimate Gaming Community',
                'description' => $page->meta_description ?? 'Join FPSociety, the premier gaming community for Counter Strike 2, GTA V, Fortnite, and more.',
                'keywords' => $page->meta_keywords ?? null,
            ]);
        }
    @endphp

    <title>{{ $seoData['basic']['title'] }}</title>
    
    <!-- Basic Meta Tags -->
    <meta name="description" content="{{ $seoData['basic']['description'] }}">
    <meta name="keywords" content="{{ $seoData['basic']['keywords'] }}">
    
    <!-- Open Graph Meta Tags -->
    @foreach($seoData['og'] as $property => $content)
        <meta property="{{ $property }}" content="{{ $content }}">
    @endforeach
    
    <!-- Twitter Card Meta Tags -->
    @foreach($seoData['twitter'] as $name => $content)
        <meta name="{{ $name }}" content="{{ $content }}">
    @endforeach
    
    <!-- Structured Data -->
    <script type="application/ld+json">
        {!! json_encode($seoData['structured']) !!}
    </script>

    @vite(['resources/css/app.css', 'resources/css/forum.css', 'resources/js/app.js', 'resources/js/forum.js', 'resources/js/mentions.js'])
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary dark:text-dark-text-primary text-light-text-primary min-h-screen">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 dark:bg-dark-bg-secondary/95 bg-light-bg-secondary/95 navbar-blur dark:border-b dark:border-dark-border-primary border-light-border-primary shadow-sm">
        <div class="container mx-auto px-4">
            <!-- Top Bar with Logo and User Menu -->
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 dark:bg-gradient-to-br from-accent-blue to-accent-purple bg-gradient-to-br from-light-text-accent to-accent-purple rounded-lg flex items-center justify-center transform group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright gradient-text">
                            FPSociety
                        </span>
                    </a>

                    <!-- Main Navigation -->
                    <nav class="hidden lg:flex items-center space-x-1">
                        <a href="/" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Home</span>
                            </div>
                        </a>
                        <a href="{{ route('forum.index') }}" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span>Forums</span>
                            </div>
                        </a>
                        
                        <!-- Universal Search Bar -->
                        <form action="{{ route('search') }}" method="GET" class="relative ml-4">
                            <input type="text" 
                                   name="q" 
                                   placeholder="Search everything..." 
                                   class="px-4 py-2 pl-10 w-64 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-4 h-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span>News</span>
                            </div>
                        </a>
                        <a href="{{ route('deals.index') }}" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 2v8m0 0v2m0-2c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Deals</span>
                            </div>
                        </a>
                        <a href="#" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Members</span>
                            </div>
                        </a>
                        <a href="{{ route('search') }}" class="px-4 py-2 rounded-lg dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-all font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Search</span>
                            </div>
                        </a>
                    </nav>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Theme Switcher -->
                    <button x-data="{ dark: true }" @click="dark = !dark; document.documentElement.classList.toggle('dark')" class="p-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                        <svg x-show="dark" class="w-5 h-5 dark:text-dark-text-accent text-light-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg x-show="!dark" class="w-5 h-5 dark:text-dark-text-accent text-light-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <!-- Notifications -->
                    @auth
                    <div x-data="notificationsDropdown()" @click.away="open = false" class="relative">
                        <button @click="toggleNotifications()" class="relative p-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                            <svg class="w-5 h-5 dark:text-dark-text-primary text-light-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="unreadCount > 0" class="absolute top-1 right-1 w-5 h-5 bg-accent-red rounded-full text-white text-xs flex items-center justify-center font-bold" x-text="unreadCount"></span>
                        </button>
                        
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-96 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-xl dark:border dark:border-dark-border-primary border-light-border-primary max-h-96 overflow-y-auto">
                            <div class="px-4 py-3 dark:border-b dark:border-dark-border-primary border-light-border-primary flex items-center justify-between">
                                <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright">Notifications</h3>
                                <button @click="markAllAsRead()" x-show="unreadCount > 0" class="text-xs text-accent-blue hover:text-accent-purple transition-colors">
                                    Mark all as read
                                </button>
                            </div>
                            
                            <div x-show="loading" class="p-4 text-center">
                                <svg class="animate-spin h-6 w-6 mx-auto dark:text-dark-text-accent text-light-text-accent" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            
                            <template x-if="!loading && notifications.length === 0">
                                <div class="p-8 text-center dark:text-dark-text-tertiary text-light-text-tertiary">
                                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <p class="text-sm">No notifications yet</p>
                                </div>
                            </template>
                            
                            <template x-for="notification in notifications" :key="notification.id">
                                <a :href="notification.url" @click="markAsRead(notification.id)" class="block px-4 py-3 dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors border-b dark:border-dark-border-primary border-light-border-primary last:border-0" :class="{ 'dark:bg-dark-bg-tertiary/50 bg-light-bg-tertiary/50': !notification.read_at }">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright" x-text="notification.title"></p>
                                            <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mt-1 line-clamp-2" x-text="notification.message"></p>
                                            <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1" x-text="notification.created_at"></p>
                                        </div>
                                        <span x-show="!notification.read_at" class="w-2 h-2 bg-accent-blue rounded-full mt-2"></span>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                    @endauth

                    @auth
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block dark:text-dark-text-primary text-light-text-primary font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-xl dark:border dark:border-dark-border-primary border-light-border-primary py-2">
                                <div class="px-4 py-3 dark:border-b dark:border-dark-border-primary border-light-border-primary">
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Signed in as</p>
                                    <p class="text-sm font-semibold dark:text-dark-text-bright text-light-text-bright">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="/admin" class="flex items-center space-x-2 px-4 py-2 dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Admin Panel</span>
                                </a>
                                <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center space-x-2 px-4 py-2 dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Your Profile</span>
                                </a>
                                <a href="{{ route('settings.index') }}" class="flex items-center space-x-2 px-4 py-2 dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Settings</span>
                                </a>
                                <div class="border-t dark:border-dark-border-primary border-light-border-primary my-2"></div>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 w-full text-left dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary dark:text-accent-red text-accent-red">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                            Sign In
                        </a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button class="lg:hidden p-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                        <svg class="w-6 h-6 dark:text-dark-text-primary text-light-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Secondary Navigation Bar (like vBadvanced) -->
            <div class="hidden md:flex items-center space-x-4 py-3 border-t dark:border-dark-border-secondary border-light-border-secondary">
                <a href="{{ route('activity.whats-new') }}" class="text-sm dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">What's New</a>
                <span class="dark:text-dark-border-primary text-light-border-primary">•</span>
                <a href="{{ route('activity.recent-posts') }}" class="text-sm dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Recent Posts</a>
                <span class="dark:text-dark-border-primary text-light-border-primary">•</span>
                <a href="{{ route('activity.trending') }}" class="text-sm dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Trending</a>
                <span class="dark:text-dark-border-primary text-light-border-primary">•</span>
                <a href="{{ route('leaderboard.index') }}" class="text-sm dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Leaderboard</a>
                <span class="dark:text-dark-border-primary text-light-border-primary">•</span>
                <a href="{{ route('downloads.index') }}" class="text-sm dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Downloads</a>
                <div class="flex-1"></div>
                <div class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\User::count() }}</span> members,
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\User::online()->count() }}</span> online,
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\Forum::count() }}</span> forums
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="dark:bg-dark-bg-secondary bg-light-bg-secondary dark:border-t dark:border-dark-border-primary border-light-border-primary mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">About FPSociety</h3>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
                        FPSociety is the ultimate gaming community for Counter Strike 2, GTA V, Fortnite, Call of Duty and more. Share mods, maps, and connect with gamers worldwide.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Contact Us</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">FAQ</a></li>
                    </ul>
                </div>
                
                <!-- Community -->
                <div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Community</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Forum Rules</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Member List</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Staff</a></li>
                        <li><a href="#" class="dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">Advertise</a></li>
                    </ul>
                </div>
                
                <!-- Social -->
                <div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Connect</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary flex items-center justify-center dark:hover:bg-accent-blue hover:bg-accent-blue transition-colors group">
                            <svg class="w-5 h-5 dark:text-dark-text-primary text-light-text-primary group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary flex items-center justify-center dark:hover:bg-accent-blue hover:bg-accent-blue transition-colors group">
                            <svg class="w-5 h-5 dark:text-dark-text-primary text-light-text-primary group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary flex items-center justify-center dark:hover:bg-accent-purple hover:bg-accent-purple transition-colors group">
                            <svg class="w-5 h-5 dark:text-dark-text-primary text-light-text-primary group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t dark:border-dark-border-primary border-light-border-primary mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">
                    &copy; {{ date('Y') }} FPSociety - Gaming Community. All rights reserved.
                </p>
                <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm mt-2 md:mt-0">
                    Powered by <span class="gradient-text font-semibold">Laravel & Passion for Gaming</span>
                </p>
            </div>
        </div>
    </footer>

    @auth
    <script>
        function notificationsDropdown() {
            return {
                open: false,
                loading: false,
                notifications: [],
                unreadCount: 0,
                
                async toggleNotifications() {
                    this.open = !this.open;
                    // Load full notifications only when dropdown is opened for the first time
                    if (this.open && this.notifications.length === 0) {
                        await this.loadNotifications();
                    }
                },
                
                async loadNotifications() {
                    this.loading = true;
                    try {
                        const response = await fetch('/notifications', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });
                        const data = await response.json();
                        this.notifications = data.notifications;
                        this.unreadCount = data.unread_count;
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    } finally {
                        this.loading = false;
                    }
                },
                
                async markAsRead(id) {
                    try {
                        await fetch(`/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });
                        const notification = this.notifications.find(n => n.id === id);
                        if (notification && !notification.read_at) {
                            notification.read_at = new Date();
                            this.unreadCount = Math.max(0, this.unreadCount - 1);
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },
                
                async markAllAsRead() {
                    try {
                        await fetch('/notifications/read-all', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });
                        this.notifications.forEach(n => n.read_at = new Date());
                        this.unreadCount = 0;
                    } catch (error) {
                        console.error('Error marking all as read:', error);
                    }
                },
                
                async init() {
                    // Load only unread count initially to reduce page load overhead
                    try {
                        const response = await fetch('/notifications', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });
                        const data = await response.json();
                        this.unreadCount = data.unread_count;
                    } catch (error) {
                        console.error('Error loading notification count:', error);
                    }
                }
            }
        }
    </script>
    @endauth

    <!-- Cookie Consent -->
    @include('cookie-consent::index')
</body>
</html>
