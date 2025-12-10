@extends('layouts.app')

@section('title', 'Welcome to ' . config('app.name', 'vBadvanced Portal'))

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-accent-blue to-accent-purple rounded-xl p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'vBadvanced Portal') }}</h1>
        <p class="text-lg opacity-90">A modern, feature-rich portal system inspired by vBadvanced CMPS, built with Laravel 12 and TailwindCSS.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Latest News/Posts Section -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden shadow-md">
                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-6 py-4">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                        <span class="w-1 h-6 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                        <span>Latest Updates</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4">
                            <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">Portal System Refactored</h3>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-3">
                                The portal has been refactored to use native Laravel Blade templates, making it cleaner and easier to maintain.
                            </p>
                            <div class="flex items-center text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                <span>Posted {{ now()->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4">
                            <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">Welcome to the Community</h3>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-3">
                                Join our growing community and explore all the features this portal has to offer.
                            </p>
                            <div class="flex items-center text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                <span>Posted {{ now()->subDays(1)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Community Features -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden shadow-md">
                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-6 py-4">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                        <span class="w-1 h-6 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                        <span>Community Features</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="#" class="group dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright group-hover:text-accent-blue transition-colors">Forums</h3>
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Discuss topics with the community</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="group dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-purple to-accent-pink flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright group-hover:text-accent-purple transition-colors">Articles</h3>
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Read the latest articles and news</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="group dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-green to-accent-teal flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright group-hover:text-accent-green transition-colors">Members</h3>
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Connect with other members</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="group dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-orange to-accent-red flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright group-hover:text-accent-orange transition-colors">Calendar</h3>
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">View upcoming events</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stats Card -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden shadow-md">
                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-6 py-4">
                    <h2 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                        <span>Community Stats</span>
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">Members</span>
                        <span class="font-bold dark:text-dark-text-accent text-light-text-accent">{{ \App\Models\User::count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">Online Now</span>
                        <span class="font-bold text-accent-green">{{ rand(5, 15) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">Active Today</span>
                        <span class="font-bold dark:text-dark-text-accent text-light-text-accent">{{ rand(20, 50) }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden shadow-md">
                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-6 py-4">
                    <h2 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                        <span>Quick Links</span>
                    </h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>What's New</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Recent Posts</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Top Members</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Forum Rules</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Help & FAQ</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Active Users -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden shadow-md">
                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-6 py-4">
                    <h2 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                        <span>Active Members</span>
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary text-center">
                        <span class="font-semibold text-accent-green">{{ rand(5, 15) }}</span> members online now
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
