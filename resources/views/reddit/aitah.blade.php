@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                Am I The A**hole?
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                Real stories from r/AITAH - Read, judge, and discuss
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Stories</p>
                        <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $posts->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-purple/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">From</p>
                        <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">r/AITAH</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-orange/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-orange" fill="currentColor" viewBox="0 0 24 24">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stories List -->
        @if($posts->count() > 0)
            <div class="space-y-6">
                @foreach($posts as $post)
                    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <a href="{{ route('reddit.show', $post) }}" class="group">
                                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2 group-hover:text-accent-blue transition-colors">
                                        {{ $post->title }}
                                    </h2>
                                </a>
                                <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                    @if($post->author)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            u/{{ $post->author }}
                                        </span>
                                    @endif
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $post->posted_at?->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($post->flair)
                                <span class="ml-4 px-3 py-1 bg-accent-purple/10 text-accent-purple rounded-lg text-sm font-medium">
                                    {{ $post->flair }}
                                </span>
                            @endif
                        </div>

                        <!-- Body Preview -->
                        <div class="dark:text-dark-text-primary text-light-text-primary mb-4">
                            <p class="line-clamp-3">
                                {{ $post->body ? Str::limit($post->body, 300) : 'Click to read the full story...' }}
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
                            <div class="flex items-center space-x-6">
                                <span class="flex items-center text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                    <svg class="w-5 h-5 mr-1.5 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                    {{ number_format($post->score) }} votes
                                </span>
                                <span class="flex items-center text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    {{ number_format($post->num_comments) }} comments
                                </span>
                            </div>
                            
                            <a href="{{ route('reddit.show', $post) }}" class="inline-flex items-center px-4 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors text-sm font-medium">
                                Read Full Story
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">No Stories Available</h3>
                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                    Stories will appear here once they are scraped from r/AITAH.
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
