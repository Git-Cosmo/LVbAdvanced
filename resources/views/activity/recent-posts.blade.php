@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            Recent Posts
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Latest replies and discussions across FPSociety
        </p>
    </div>

    <div class="space-y-4">
        @forelse($posts as $post)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-accent-green to-accent-teal flex items-center justify-center text-white font-semibold">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ $post->user->name }}</span>
                            <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">replied in</span>
                            <a href="{{ route('forum.thread.show', $post->thread->slug) }}" class="dark:text-dark-text-accent text-light-text-accent text-sm hover:underline">
                                {{ $post->thread->title }}
                            </a>
                        </div>
                        <div class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-2">
                            {{ Str::limit(strip_tags($post->content), 300) }}
                        </div>
                        <div class="flex items-center space-x-4 mt-3 text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            <span>•</span>
                            <span>in {{ $post->thread->forum->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 text-center">
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    No posts yet. Start the conversation!
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
