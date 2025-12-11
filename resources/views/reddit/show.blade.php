@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ $post->subreddit === 'LivestreamFail' ? route('clips.index') : route('aitah.index') }}" 
               class="inline-flex items-center text-accent-blue hover:underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to {{ $post->subreddit === 'LivestreamFail' ? 'Clips' : 'AITAH' }}
            </a>
        </div>

        <!-- Main Content Card -->
        <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b dark:border-dark-border-primary border-light-border-primary">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-3">
                            {{ $post->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                            @if($post->author)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    u/{{ $post->author }}
                                </span>
                            @endif
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $post->posted_at?->format('F j, Y \a\t g:i A') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($post->views_count) }} views
                            </span>
                        </div>
                    </div>
                    
                    @if($post->flair)
                        <span class="ml-4 px-3 py-1 bg-accent-blue/10 text-accent-blue rounded-lg text-sm font-medium flex-shrink-0">
                            {{ $post->flair }}
                        </span>
                    @endif
                </div>

                <!-- Stats -->
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-1.5 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                        <span class="font-semibold dark:text-dark-text-primary text-light-text-primary">
                            {{ number_format($post->score) }}
                        </span>
                        <span class="ml-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">upvotes</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-1.5 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="font-semibold dark:text-dark-text-primary text-light-text-primary">
                            {{ number_format($post->num_comments) }}
                        </span>
                        <span class="ml-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">comments</span>
                    </div>
                </div>
            </div>

            <!-- Media Content (for video posts) -->
            @if($post->is_video && $post->url)
                <div class="bg-black">
                    <div class="aspect-video flex items-center justify-center">
                        @if(str_contains($post->url, 'youtube.com') || str_contains($post->url, 'youtu.be'))
                            @if($post->getYoutubeVideoId())
                                <iframe class="w-full h-full" 
                                        src="https://www.youtube.com/embed/{{ $post->getYoutubeVideoId() }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            @endif
                        @elseif(str_contains($post->url, 'twitch.tv'))
                            <p class="text-white">
                                <a href="{{ $post->url }}" target="_blank" rel="noopener noreferrer" class="text-accent-blue hover:underline">
                                    Watch on Twitch →
                                </a>
                            </p>
                        @else
                            <a href="{{ $post->url }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center text-white hover:text-accent-blue transition-colors">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Watch Video</span>
                            </a>
                        @endif
                    </div>
                </div>
            @elseif($post->thumbnail && !$post->is_self)
                <div class="bg-black">
                    <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full object-contain max-h-[600px]">
                </div>
            @endif

            <!-- Body Content -->
            @if($post->body)
                <div class="p-6">
                    <div class="prose prose-invert max-w-none dark:text-dark-text-primary text-light-text-primary whitespace-pre-wrap">
                        {{ $post->body }}
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div class="p-6 bg-gray-800/50 border-t dark:border-dark-border-primary border-light-border-primary">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                            Posted in
                            <span class="font-semibold dark:text-dark-text-primary text-light-text-primary">
                                r/{{ $post->subreddit }}
                            </span>
                        </span>
                    </div>
                    
                    <a href="{{ $post->reddit_url }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center px-4 py-2 bg-accent-orange hover:bg-orange-600 text-white rounded-lg transition-colors text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/>
                        </svg>
                        View on Reddit
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
