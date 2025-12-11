@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Gallery Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 bg-accent-blue rounded-full text-white text-xs font-semibold">
                        {{ $gallery->game }}
                    </span>
                    <span class="px-3 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-full dark:text-dark-text-secondary text-light-text-secondary text-xs font-semibold capitalize">
                        {{ $gallery->category }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    {{ $gallery->title }}
                </h1>
                <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <a href="{{ route('profile.show', $gallery->user) }}" class="hover:text-accent-blue transition-colors">
                            {{ $gallery->user->name }}
                        </a>
                    </div>
                    <span>•</span>
                    <span>{{ $gallery->created_at->diffForHumans() }}</span>
                    <span>•</span>
                    <span>👁 {{ $gallery->views }} views</span>
                    <span>•</span>
                    <span>⬇ {{ $gallery->downloads }} downloads</span>
                </div>
            </div>
            @auth
                @if(auth()->id() === $gallery->user_id)
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg font-medium hover:shadow-lg transition-all">
                            Edit
                        </button>
                        <form action="{{ route('downloads.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-accent-red text-white rounded-lg font-medium hover:shadow-lg transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        @if($gallery->description)
            <p class="mt-4 dark:text-dark-text-secondary text-light-text-secondary">
                {{ $gallery->description }}
            </p>
        @endif
    </div>

    <!-- Media Files -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            Files ({{ $gallery->galleryMedia->count() }})
        </h2>
        
        @if($gallery->galleryMedia->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($gallery->galleryMedia as $media)
                    <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg overflow-hidden">
                        @if(str_starts_with($media->mime_type, 'image/'))
                            <div class="relative h-48">
                                <img src="{{ $media->url }}" alt="{{ $media->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="relative h-48 flex items-center justify-center dark:bg-dark-bg-elevated bg-light-bg-elevated">
                                <svg class="w-16 h-16 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-3">
                            <p class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary truncate">
                                {{ $media->name }}
                            </p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                    {{ number_format($media->size / 1024, 2) }} KB
                                </span>
                                <a href="{{ route('downloads.download', $media->id) }}" class="text-xs text-accent-blue hover:text-accent-purple transition-colors font-medium">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-center py-8">
                No files uploaded yet.
            </p>
        @endif
    </div>

    <!-- Comments Section -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            Comments ({{ $gallery->comments->count() }})
        </h2>
        
        @auth
            <form action="{{ route('downloads.comment.store', $gallery) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="content" 
                          rows="3"
                          placeholder="Write a comment..."
                          class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue mb-2"
                          required></textarea>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    Post Comment
                </button>
            </form>
        @else
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-6">
                <a href="{{ route('login') }}" class="text-accent-blue hover:text-accent-purple transition-colors">Sign in</a> to leave a comment
            </p>
        @endauth

        <div class="space-y-4">
            @forelse($gallery->comments as $comment)
                <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-semibold">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <a href="{{ route('profile.show', $comment->user) }}" class="font-medium dark:text-dark-text-primary text-light-text-primary hover:text-accent-blue transition-colors">
                                    {{ $comment->user->name }}
                                </a>
                                <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
                                {{ $comment->content }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-center py-8">
                    No comments yet. Be the first to comment!
                </p>
            @endforelse
        </div>
    </div>
</div>
@endsection
