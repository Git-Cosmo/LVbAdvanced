@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            Gaming News
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Stay updated with the latest gaming news, updates, and announcements
        </p>
    </div>

    <!-- Featured News -->
    @if($featuredNews->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Featured Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredNews as $featured)
                    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        @if($featured->image)
                            <div class="relative h-48">
                                <img src="{{ $featured->image }}" alt="{{ $featured->title }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 px-3 py-1 bg-accent-orange rounded-full text-white text-xs font-semibold">
                                    Featured
                                </div>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                                <a href="{{ route('news.show', $featured) }}" class="hover:text-accent-blue transition-colors">
                                    {{ $featured->title }}
                                </a>
                            </h3>
                            @if($featured->excerpt)
                                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-3 line-clamp-2">
                                    {{ $featured->excerpt }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                <span>{{ $featured->published_at->diffForHumans() }}</span>
                                <span>👁 {{ $featured->views_count }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All News -->
    <div>
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Latest News</h2>
        <div class="space-y-6">
            @forelse($news as $article)
                <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="md:flex">
                        @if($article->image)
                            <div class="md:w-1/3 h-48 md:h-auto">
                                <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-6 {{ $article->image ? 'md:w-2/3' : 'w-full' }}">
                            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                                <a href="{{ route('news.show', $article) }}" class="hover:text-accent-blue transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            @if($article->excerpt)
                                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-3">
                                    {{ $article->excerpt }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center space-x-4 dark:text-dark-text-tertiary text-light-text-tertiary">
                                    @if($article->user)
                                        <span>By {{ $article->user->name }}</span>
                                        <span>•</span>
                                    @endif
                                    <span>{{ $article->published_at->format('M d, Y') }}</span>
                                    <span>•</span>
                                    <span>👁 {{ $article->views_count }}</span>
                                </div>
                                <a href="{{ route('news.show', $article) }}" class="text-accent-blue hover:text-accent-purple font-medium transition-colors">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                        No news articles yet. Check back soon!
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
