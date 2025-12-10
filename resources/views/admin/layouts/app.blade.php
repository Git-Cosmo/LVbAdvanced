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
