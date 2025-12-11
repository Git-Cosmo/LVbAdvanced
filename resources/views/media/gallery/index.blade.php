@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    Downloads
                </h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    Download custom maps, mods, skins, and resources for Counter Strike 2, GTA V, Fortnite, and more
                </p>
            </div>
            @auth
                <a href="{{ route('downloads.create') }}" class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Upload Content
                </a>
            @endauth
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg font-medium dark:text-dark-text-bright text-light-text-bright hover:bg-accent-blue hover:text-white transition-colors">
            All
        </button>
        <button class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg font-medium dark:text-dark-text-secondary text-light-text-secondary hover:bg-accent-blue hover:text-white transition-colors">
            Counter Strike 2
        </button>
        <button class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg font-medium dark:text-dark-text-secondary text-light-text-secondary hover:bg-accent-blue hover:text-white transition-colors">
            GTA V
        </button>
        <button class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg font-medium dark:text-dark-text-secondary text-light-text-secondary hover:bg-accent-blue hover:text-white transition-colors">
            Fortnite
        </button>
        <button class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg font-medium dark:text-dark-text-secondary text-light-text-secondary hover:bg-accent-blue hover:text-white transition-colors">
            Call of Duty
        </button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative h-48 dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                    @if($gallery->galleryMedia->first())
                        <img src="{{ $gallery->galleryMedia->first()->url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2 px-3 py-1 bg-accent-blue rounded-full text-white text-xs font-semibold">
                        {{ $gallery->game }}
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                        <a href="{{ route('downloads.show', $gallery) }}" class="hover:text-accent-blue transition-colors">
                            {{ $gallery->title }}
                        </a>
                    </h3>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-3 line-clamp-2">
                        {{ $gallery->description }}
                    </p>
                    <div class="flex items-center justify-between text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
                        <div class="flex items-center space-x-4">
                            <span>👁 {{ $gallery->views }}</span>
                            <span>⬇ {{ $gallery->downloads }}</span>
                        </div>
                        <span class="text-xs">{{ $gallery->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                    No content uploaded yet. Be the first to share!
                </p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
