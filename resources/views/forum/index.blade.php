@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Forums</h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Welcome to our community forums. Join the discussion!
        </p>
    </div>

    <!-- Forum Categories -->
    @foreach($categories as $category)
    <div class="mb-8">
        <!-- Category Header -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-t-xl px-6 py-4 dark:border-b dark:border-dark-border-primary border-light-border-primary">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">
                {{ $category->name }}
            </h2>
            @if($category->description)
            <p class="dark:text-dark-text-secondary text-light-text-secondary mt-1">
                {{ $category->description }}
            </p>
            @endif
        </div>

        <!-- Forums List -->
        <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-b-xl overflow-hidden">
            @forelse($category->forums as $forum)
            <a href="{{ route('forum.show', $forum->slug) }}" 
               class="flex items-center p-6 dark:border-b dark:border-dark-border-secondary border-light-border-secondary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                <!-- Forum Icon -->
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>

                <!-- Forum Info -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">
                        {{ $forum->name }}
                    </h3>
                    @if($forum->description)
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-1">
                        {{ $forum->description }}
                    </p>
                    @endif
                    @if($forum->children_count > 0)
                    <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs mt-2">
                        {{ $forum->children_count }} subforums
                    </p>
                    @endif
                </div>

                <!-- Stats -->
                <div class="text-right ml-4">
                    <div class="dark:text-dark-text-accent text-light-text-accent font-semibold">
                        {{ number_format($forum->threads_count) }}
                    </div>
                    <div class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
                        Threads
                    </div>
                    <div class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs mt-1">
                        {{ number_format($forum->posts_count) }} posts
                    </div>
                </div>
            </a>
            @empty
            <div class="p-6 text-center dark:text-dark-text-secondary text-light-text-secondary">
                No forums in this category yet.
            </div>
            @endforelse
        </div>
    </div>
    @endforeach

    @if($categories->isEmpty())
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
        <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
            No Forums Available
        </h3>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Forums are being set up. Please check back soon!
        </p>
    </div>
    @endif
</div>
@endsection
