@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            🔥 Trending Discussions
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Hottest topics in the FPSociety community right now
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
                            @if(isset($thread->trending_score))
                                <div class="flex items-center space-x-2 text-accent-orange">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"/>
                                    </svg>
                                    <span class="font-semibold">Trending</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 text-center">
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    No trending topics at the moment. Start a discussion!
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
