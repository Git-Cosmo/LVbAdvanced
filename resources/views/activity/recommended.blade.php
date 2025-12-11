@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            ✨ Recommended For You
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Personalized gaming content based on your interests and activity
        </p>
    </div>

    <div class="space-y-4">
        @forelse($threads as $thread)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <a href="{{ route('forum.thread.show', $thread->slug) }}" class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-accent-blue transition-colors">
                            {{ $thread->title }}
                        </a>
                        <div class="flex items-center space-x-4 mt-2 text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
                            <span>by {{ $thread->user->name }}</span>
                            <span>•</span>
                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                            <span>•</span>
                            <span>in {{ $thread->forum->name }}</span>
                        </div>
                        <div class="flex items-center space-x-6 mt-4 text-sm">
                            <div class="flex items-center space-x-2 dark:text-dark-text-secondary text-light-text-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                <span>{{ $thread->posts_count ?? 0 }} replies</span>
                            </div>
                            <div class="flex items-center space-x-2 dark:text-dark-text-secondary text-light-text-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>{{ $thread->views ?? 0 }} views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-2">
                    No recommendations available yet
                </p>
                <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">
                    Start exploring forums and threads to get personalized recommendations!
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
