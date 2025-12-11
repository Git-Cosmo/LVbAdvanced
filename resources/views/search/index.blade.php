@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Universal Search
        </h1>
        
        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="mb-6">
            <div class="relative">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $query }}"
                    placeholder="Search across forums, news, downloads, and members..." 
                    class="w-full px-6 py-4 pl-14 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue text-lg"
                    autofocus
                >
                <button type="submit" class="absolute left-4 top-1/2 transform -translate-y-1/2">
                    <svg class="w-6 h-6 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </form>

        @if($query)
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                Showing results for: <strong class="dark:text-dark-text-accent text-light-text-accent">{{ $query }}</strong>
            </p>
        @endif
    </div>

    @if($query && $results->count() > 0)
        <div class="space-y-4">
            @foreach($results->groupByType() as $type => $modelSearchResults)
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                        {{ ucfirst(class_basename($type)) }} ({{ $modelSearchResults->count() }})
                    </h2>
                    
                    <div class="space-y-3">
                        @foreach($modelSearchResults as $searchResult)
                            <a href="{{ $searchResult->url }}" class="block p-4 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                                <h3 class="font-semibold dark:text-dark-text-accent text-light-text-accent mb-1">
                                    {{ $searchResult->title }}
                                </h3>
                                
                                @if($searchResult->searchable instanceof \App\Models\Forum\ForumThread)
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                        Forum: {{ $searchResult->searchable->forum->name ?? 'Unknown' }}
                                        • Posts: {{ $searchResult->searchable->posts_count }}
                                        • Views: {{ $searchResult->searchable->views_count }}
                                    </p>
                                @elseif($searchResult->searchable instanceof \App\Models\Forum\ForumPost)
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary line-clamp-2">
                                        {{ Str::limit(strip_tags($searchResult->title), 150) }}
                                    </p>
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                        Thread: {{ $searchResult->searchable->thread->title ?? 'Unknown' }}
                                        • By: {{ $searchResult->searchable->user->name ?? 'Unknown' }}
                                    </p>
                                @elseif($searchResult->searchable instanceof \App\Models\News)
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary line-clamp-2">
                                        {{ $searchResult->searchable->excerpt ?? Str::limit($searchResult->searchable->content, 150) }}
                                    </p>
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                        Published: {{ $searchResult->searchable->published_at?->format('M d, Y') ?? 'Draft' }}
                                    </p>
                                @elseif($searchResult->searchable instanceof \App\Models\User\Gallery)
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary line-clamp-2">
                                        {{ $searchResult->searchable->description ?? 'No description' }}
                                    </p>
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                        Game: {{ $searchResult->searchable->game }}
                                        • Category: {{ ucfirst($searchResult->searchable->category) }}
                                        • Downloads: {{ $searchResult->searchable->downloads }}
                                    </p>
                                @elseif($searchResult->searchable instanceof \App\Models\User)
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                        Email: {{ $searchResult->searchable->email }}
                                    </p>
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                        Level: {{ $searchResult->searchable->profile->level ?? 1 }}
                                        • XP: {{ $searchResult->searchable->profile->xp ?? 0 }}
                                        • Posts: {{ $searchResult->searchable->posts()->count() }}
                                    </p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @elseif($query)
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">No Results Found</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                We couldn't find any results for "{{ $query }}". Try different keywords.
            </p>
        </div>
    @else
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">Start Searching</h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Search across forums, news, downloads, and member profiles to find what you're looking for.
            </p>
        </div>
    @endif
</div>
@endsection
