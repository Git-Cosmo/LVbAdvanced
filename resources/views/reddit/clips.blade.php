@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                Gaming Clips
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                Watch the latest gaming clips and highlights from LivestreamFail
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Clips</p>
                        <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $posts->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-blue/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">From</p>
                        <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">r/LivestreamFail</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-purple/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-purple" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Current Page</p>
                        <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $posts->currentPage() }} / {{ $posts->lastPage() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-green/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clips Grid -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <!-- Thumbnail -->
                        <a href="{{ route('reddit.show', $post) }}" class="block relative overflow-hidden aspect-video bg-gray-800">
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Video Badge -->
                            <div class="absolute top-3 left-3 bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                </svg>
                                <span>Video</span>
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="p-6">
                            <a href="{{ route('reddit.show', $post) }}">
                                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-2 line-clamp-2 group-hover:text-accent-blue transition-colors">
                                    {{ $post->title }}
                                </h3>
                            </a>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-sm dark:text-dark-text-secondary text-light-text-secondary mb-3">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                        {{ number_format($post->score) }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ number_format($post->num_comments) }}
                                    </span>
                                </div>
                                <span class="text-xs">{{ $post->posted_at?->diffForHumans() }}</span>
                            </div>

                            <!-- Author & Flair -->
                            <div class="flex items-center justify-between">
                                @if($post->author)
                                    <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
                                        u/{{ $post->author }}
                                    </span>
                                @endif
                                @if($post->flair)
                                    <span class="text-xs bg-accent-blue/10 text-accent-blue px-2 py-1 rounded">
                                        {{ $post->flair }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">No Clips Available</h3>
                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                    Clips will appear here once they are scraped from r/LivestreamFail.
                </p>
                @auth
                    @if(auth()->user()->hasRole('Administrator'))
                        <a href="{{ route('admin.reddit.index') }}" class="inline-flex items-center px-4 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors">
                            Go to Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
