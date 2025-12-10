@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="dark:bg-gradient-to-r from-dark-bg-secondary to-dark-bg-tertiary bg-gradient-to-r from-light-bg-secondary to-light-bg-tertiary rounded-xl p-8 md:p-12 shadow-lg">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Welcome to vBadvanced Portal
            </h1>
            <p class="text-xl dark:text-dark-text-secondary text-light-text-secondary mb-6">
                A modern, feature-rich portal system inspired by vBadvanced CMPS, built with Laravel 12 and TailwindCSS.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('forum.index') }}" class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Visit Forums
                </a>
                <a href="#features" class="px-6 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg font-medium dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                    Learn More
                </a>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div id="features" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Feature 1 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Forum System</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Full-featured discussion system with categories, threads, polls, reactions, and moderation tools.
            </p>
        </div>

        <!-- Feature 2 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-purple to-accent-pink rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">User Profiles</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Extended user profiles with XP, levels, karma, badges, and achievements for gamification.
            </p>
        </div>

        <!-- Feature 3 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-green to-accent-teal rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Role-Based Access</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Advanced permission system using Spatie's Laravel Permission package for fine-grained control.
            </p>
        </div>

        <!-- Feature 4 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-orange to-accent-red rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Modern Tech Stack</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Built with Laravel 12, TailwindCSS, Alpine.js, and PHP 8.4 for optimal performance.
            </p>
        </div>

        <!-- Feature 5 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-teal to-accent-blue rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Rich Content</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Support for BBCode, file attachments, embedded media, polls, and real-time reactions.
            </p>
        </div>

        <!-- Feature 6 -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 shadow-md dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-pink to-accent-purple rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Admin Panel</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Comprehensive admin interface for managing content, users, forums, and monitoring activity.
            </p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 text-center shadow-md">
            <div class="text-3xl font-bold dark:text-dark-text-accent text-light-text-accent mb-2">
                {{ \App\Models\User::count() }}
            </div>
            <div class="dark:text-dark-text-secondary text-light-text-secondary">Total Members</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 text-center shadow-md">
            <div class="text-3xl font-bold dark:text-dark-text-accent text-light-text-accent mb-2">
                {{ \App\Models\Forum\Forum::count() }}
            </div>
            <div class="dark:text-dark-text-secondary text-light-text-secondary">Forums</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 text-center shadow-md">
            <div class="text-3xl font-bold dark:text-dark-text-accent text-light-text-accent mb-2">
                {{ \App\Models\Forum\Thread::count() }}
            </div>
            <div class="dark:text-dark-text-secondary text-light-text-secondary">Threads</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 text-center shadow-md">
            <div class="text-3xl font-bold dark:text-dark-text-accent text-light-text-accent mb-2">
                {{ \App\Models\Forum\Post::count() }}
            </div>
            <div class="dark:text-dark-text-secondary text-light-text-secondary">Posts</div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="dark:bg-gradient-to-r from-accent-blue to-accent-purple bg-gradient-to-r from-light-text-accent to-accent-purple rounded-xl p-8 text-center shadow-lg">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Join the Community?</h2>
        <p class="text-white/90 mb-6 max-w-2xl mx-auto">
            Create an account today and become part of our growing community. Share your ideas, participate in discussions, and connect with like-minded individuals.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            @guest
                <a href="/register" class="px-8 py-3 bg-white text-accent-blue rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Sign Up Now
                </a>
                <a href="/login" class="px-8 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white hover:text-accent-blue transition-all">
                    Sign In
                </a>
            @else
                <a href="{{ route('forum.index') }}" class="px-8 py-3 bg-white text-accent-blue rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Explore Forums
                </a>
            @endguest
        </div>
    </div>
</div>
@endsection
