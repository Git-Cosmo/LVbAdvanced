@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden mb-6">
        @if($news->image)
            <div class="relative h-96">
                <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                @if($news->is_featured)
                    <div class="absolute top-4 right-4 px-4 py-2 bg-accent-orange rounded-full text-white text-sm font-semibold">
                        Featured
                    </div>
                @endif
            </div>
        @endif

        <div class="p-8">
            <!-- Title and Meta -->
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                {{ $news->title }}
            </h1>

            <div class="flex items-center space-x-4 mb-6 pb-6 border-b dark:border-dark-border-primary border-light-border-primary">
                @if($news->user)
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-semibold">
                            {{ substr($news->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary">
                                {{ $news->user->name }}
                            </p>
                            <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                Author
                            </p>
                        </div>
                    </div>
                @endif
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    {{ $news->published_at->format('F d, Y') }}
                </span>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    👁 {{ $news->views_count }} views
                </span>
            </div>

            <!-- Excerpt -->
            @if($news->excerpt)
                <div class="text-lg dark:text-dark-text-secondary text-light-text-secondary italic mb-6 pb-6 border-b dark:border-dark-border-primary border-light-border-primary">
                    {{ $news->excerpt }}
                </div>
            @endif

            <!-- Content -->
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- Tags -->
            @if($news->tags->count() > 0)
                <div class="mt-8 pt-6 border-t dark:border-dark-border-primary border-light-border-primary">
                    <div class="flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <span class="px-3 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-full text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Source -->
            @if($news->source && $news->source_url)
                <div class="mt-6 p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        Source: <a href="{{ $news->source_url }}" target="_blank" rel="noopener" class="text-accent-blue hover:text-accent-purple font-medium">{{ $news->source }}</a>
                    </p>
                </div>
            @endif
        </div>
    </article>

    <!-- Related News -->
    @if($relatedNews->count() > 0)
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Related Articles
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($relatedNews as $related)
                    <article class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        @if($related->image)
                            <div class="h-32">
                                <img src="{{ $related->image }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm mb-2">
                                <a href="{{ route('news.show', $related) }}" class="hover:text-accent-blue transition-colors">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                {{ $related->published_at->diffForHumans() }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-6 text-center">
        <a href="{{ route('news.index') }}" class="inline-flex items-center space-x-2 px-6 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg hover:shadow-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="dark:text-dark-text-primary text-light-text-primary font-medium">Back to News</span>
        </a>
    </div>
</div>
@endsection
