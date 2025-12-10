@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Left Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Welcome Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Welcome
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                Welcome to vBadvanced Portal, a modern forum platform built with Laravel 12.
            </p>
            @guest
                <div class="space-y-2">
                    <a href="/register" class="block w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white text-center rounded-lg font-medium hover:shadow-lg transition-all">
                        Sign Up
                    </a>
                    <a href="/login" class="block w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary text-center rounded-lg font-medium dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                        Sign In
                    </a>
                </div>
            @else
                <p class="dark:text-dark-text-primary text-light-text-primary text-sm">
                    Welcome back, <strong>{{ auth()->user()->name }}</strong>!
                </p>
            @endguest
        </div>

        <!-- Stats Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Forum Statistics
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Forums:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\Forum::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Threads:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumThread::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Posts:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumPost::count() }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Links Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Quick Links
            </h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('forum.index') }}" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Forum Index
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Recent Posts
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Top Members
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Help & FAQ
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Center Content -->
    <div class="col-span-12 lg:col-span-6">
        <div class="space-y-6">
            <!-- Hero Welcome -->
            <div class="dark:bg-gradient-to-r from-dark-bg-secondary to-dark-bg-tertiary bg-gradient-to-r from-light-bg-secondary to-light-bg-tertiary rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-3">
                    Welcome to vBadvanced Portal
                </h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                    A modern, feature-rich portal system inspired by vBadvanced CMPS, built with Laravel 12 and TailwindCSS.
                </p>
                <a href="{{ route('forum.index') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Visit Forums
                </a>
            </div>

            <!-- Latest News -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Latest News
                </h3>
                <div class="space-y-4">
                    <article class="border-b dark:border-dark-border-primary border-light-border-primary pb-4 last:border-0">
                        <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">
                            Welcome to Our New Portal
                        </h4>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-2">
                            We're excited to announce the launch of our new portal system. Explore the forums, connect with community members, and share your ideas.
                        </p>
                        <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            Posted on {{ now()->format('M d, Y') }}
                        </span>
                    </article>
                    <article class="border-b dark:border-dark-border-primary border-light-border-primary pb-4 last:border-0">
                        <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">
                            Forum Features Overview
                        </h4>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-2">
                            Our forum includes powerful features like polls, reactions, BBCode support, file attachments, and a comprehensive moderation system.
                        </p>
                        <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            Posted on {{ now()->subDays(2)->format('M d, Y') }}
                        </span>
                    </article>
                </div>
            </div>

            <!-- Features Overview -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Key Features
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Forum System</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Full-featured discussions</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-purple to-accent-pink rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">User Profiles</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">XP, levels & badges</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-green to-accent-teal rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Moderation Tools</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Reports, warnings & bans</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-orange to-accent-red rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Rich Content</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">BBCode & attachments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Online Users Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Who's Online
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Guests:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Total:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Recent Activity
            </h3>
            <div class="space-y-3 text-sm">
                <div class="border-b dark:border-dark-border-primary border-light-border-primary pb-3 last:border-0">
                    <p class="dark:text-dark-text-secondary text-light-text-secondary">
                        Welcome to the portal! Start exploring the forums.
                    </p>
                    <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Just now</span>
                </div>
            </div>
        </div>

        <!-- Community Info Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                About
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                Built with Laravel 12, this modern forum platform combines the classic vBadvanced CMPS layout with contemporary design and features.
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Laravel 12</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">TailwindCSS</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Alpine.js</span>
            </div>
        </div>
    </aside>
</div>
@endsection
