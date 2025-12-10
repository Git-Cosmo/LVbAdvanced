@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            What's New
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Latest activity and content from the FPSociety community
        </p>
    </div>

    <div class="space-y-4">
        @forelse($feed as $item)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                @if($item['type'] === 'thread')
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-semibold">
                            {{ substr($item['data']->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ $item['data']->user->name }}</span>
                                <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">created a new thread</span>
                                <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">• {{ $item['timestamp']->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('forum.thread.show', $item['data']->slug) }}" class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-accent-blue transition-colors">
                                {{ $item['data']->title }}
                            </a>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-2">
                                in {{ $item['data']->forum->name }}
                            </p>
                        </div>
                    </div>
                @elseif($item['type'] === 'post')
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-accent-purple to-accent-pink flex items-center justify-center text-white font-semibold">
                            {{ substr($item['data']->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ $item['data']->user->name }}</span>
                                <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">replied to</span>
                                <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">• {{ $item['timestamp']->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('forum.thread.show', $item['data']->thread->slug) }}" class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-accent-blue transition-colors">
                                {{ $item['data']->thread->title }}
                            </a>
                            <div class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-2 line-clamp-2">
                                {{ Str::limit(strip_tags($item['data']->content), 200) }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 text-center">
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    No activity yet. Be the first to post something!
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
