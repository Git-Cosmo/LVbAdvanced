@extends('portal.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 dark:text-dark-text-secondary text-light-text-secondary text-sm">
        <a href="{{ route('forum.index') }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">Forums</a>
        <span>›</span>
        <a href="{{ route('forum.show', $forum->category->slug) }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">{{ $forum->category->name }}</a>
        <span>›</span>
        <span class="dark:text-dark-text-primary text-light-text-primary">{{ $forum->name }}</span>
    </nav>

    <!-- Forum Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    {{ $forum->name }}
                </h1>
                @if($forum->description)
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    {{ $forum->description }}
                </p>
                @endif
            </div>
            @auth
            <a href="{{ route('forum.thread.create', $forum) }}" 
               class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                New Thread
            </a>
            @endauth
        </div>
    </div>

    <!-- Threads List -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden">
        @forelse($threads as $thread)
        <div class="flex items-center p-6 dark:border-b dark:border-dark-border-secondary border-light-border-secondary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
            <!-- Thread Icon -->
            <div class="mr-4">
                @if($thread->is_pinned)
                <div class="w-10 h-10 rounded-lg bg-accent-yellow/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent-yellow" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5l2.5 5 5.5.8-4 3.9.9 5.6-5-2.6-5 2.6.9-5.6-4-3.9 5.5-.8z"/>
                    </svg>
                </div>
                @elseif($thread->is_locked)
                <div class="w-10 h-10 rounded-lg bg-accent-red/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                @else
                <div class="w-10 h-10 rounded-lg dark:bg-dark-bg-elevated bg-light-bg-elevated flex items-center justify-center">
                    <svg class="w-5 h-5 dark:text-dark-text-accent text-light-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                @endif
            </div>

            <!-- Thread Info -->
            <div class="flex-1">
                <a href="{{ route('forum.thread.show', $thread->slug) }}" 
                   class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright dark:hover:text-dark-text-accent hover:text-light-text-accent">
                    {{ $thread->title }}
                </a>
                <div class="flex items-center space-x-4 mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $thread->user->name }}
                    </span>
                    <span>{{ $thread->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Thread Stats -->
            <div class="ml-4 text-center hidden md:block">
                <div class="dark:text-dark-text-accent text-light-text-accent font-semibold">
                    {{ number_format($thread->posts_count) }}
                </div>
                <div class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">
                    Replies
                </div>
            </div>

            <div class="ml-6 text-center hidden md:block">
                <div class="dark:text-dark-text-accent text-light-text-accent font-semibold">
                    {{ number_format($thread->views_count) }}
                </div>
                <div class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">
                    Views
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                No Threads Yet
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                Be the first to start a discussion in this forum!
            </p>
            @auth
            <a href="{{ route('forum.thread.create', $forum) }}" 
               class="inline-block px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                Create Thread
            </a>
            @endauth
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($threads->hasPages())
    <div class="mt-6">
        {{ $threads->links() }}
    </div>
    @endif
</div>
@endsection
