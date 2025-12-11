<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/css/forum.css', 'resources/js/app.js', 'resources/js/forum.js'])
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary dark:text-dark-text-primary text-light-text-primary min-h-screen">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 dark:bg-dark-bg-secondary bg-light-bg-secondary border-r dark:border-dark-border-primary border-light-border-primary">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">Admin Panel</h2>
                </div>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <div class="mt-6 px-6 py-3 text-xs uppercase dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">Users</div>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    User Management
                </a>
                
                <div class="mt-6 px-6 py-3 text-xs uppercase dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">Forums</div>
                
                <a href="{{ route('admin.forum.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.forum.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Forum Management
                </a>
                
                <a href="{{ route('admin.moderation.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.moderation.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Moderation
                </a>
                
                <div class="mt-6 px-6 py-3 text-xs uppercase dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">Content</div>
                
                <a href="{{ route('admin.news.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.news.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    News Management
                </a>
                
                <a href="{{ route('admin.rss.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.rss.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                    </svg>
                    RSS Feeds
                </a>

                <a href="{{ route('admin.deals.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.deals.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 2v8m0 0v2m0-2c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Game Deals
                </a>

                <a href="{{ route('admin.media.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.media.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Media Management
                </a>

                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Events Management
                </a>

                <a href="{{ route('admin.reddit.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.reddit.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/>
                    </svg>
                    Reddit Management
                </a>

                <a href="{{ route('admin.streamerbans.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.streamerbans.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    StreamerBans
                </a>
                
                <div class="mt-6 px-6 py-3 text-xs uppercase dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">Gamification</div>
                
                <a href="{{ route('admin.reputation.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.reputation.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Reputation
                </a>
                
                <a href="{{ route('admin.gamification.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.gamification.*') ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Gamification Settings
                </a>
                
                <div class="mt-6 px-6 py-3 text-xs uppercase dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">System</div>
                
                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 dark:text-dark-text-primary text-light-text-primary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors" target="_blank">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Site
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <header class="dark:bg-dark-bg-secondary bg-light-bg-secondary border-b dark:border-dark-border-primary border-light-border-primary">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold dark:text-dark-text-bright text-light-text-bright">@yield('header', 'Dashboard')</h1>
                    
                    <div class="flex items-center space-x-4">
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-6">
                @if(session('success') || session('status'))
                    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') ?? session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/50 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
