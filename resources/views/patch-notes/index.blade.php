@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    Game Patch Notes
                </h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    Stay updated with the latest patches, updates, and balance changes
                </p>
            </div>
            
            <!-- Game Filter -->
            @if($games->count() > 0)
                <form method="GET" action="{{ route('patch-notes.index') }}" class="mt-4 md:mt-0">
                    <select name="game" onchange="this.form.submit()" 
                        class="px-4 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                        <option value="">All Games</option>
                        @foreach($games as $game)
                            <option value="{{ $game }}" {{ $selectedGame === $game ? 'selected' : '' }}>
                                {{ $game }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </div>

    <!-- Featured Patch Notes -->
    @if($featuredPatchNotes->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Featured Updates</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredPatchNotes as $featured)
                    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-primary-600 dark:text-primary-400">{{ $featured->game_name }}</span>
                                <span class="px-3 py-1 bg-accent-orange rounded-full text-white text-xs font-semibold">
                                    Featured
                                </span>
                            </div>
                            @if($featured->version)
                                <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mb-2">Version {{ $featured->version }}</div>
                            @endif
                            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                                <a href="{{ route('patch-notes.show', $featured) }}" class="hover:text-accent-blue transition-colors">
                                    {{ $featured->title }}
                                </a>
                            </h3>
                            @if($featured->description)
                                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-3 line-clamp-2">
                                    {{ $featured->description }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                <span>{{ $featured->released_at ? $featured->released_at->diffForHumans() : 'Recently' }}</span>
                                <span>👁 {{ $featured->views_count }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Patch Notes -->
    <div>
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            {{ $selectedGame ? $selectedGame . ' Patch Notes' : 'Latest Patch Notes' }}
        </h2>
        <div class="space-y-4">
            @forelse($patchNotes as $patchNote)
                <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="text-sm font-medium text-primary-600 dark:text-primary-400">{{ $patchNote->game_name }}</span>
                                    @if($patchNote->version)
                                        <span class="px-2 py-1 bg-gray-200 dark:bg-dark-bg-tertiary rounded text-xs dark:text-dark-text-secondary text-light-text-secondary">
                                            v{{ $patchNote->version }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                                    <a href="{{ route('patch-notes.show', $patchNote) }}" class="hover:text-accent-blue transition-colors">
                                        {{ $patchNote->title }}
                                    </a>
                                </h3>
                                @if($patchNote->description)
                                    <p class="dark:text-dark-text-secondary text-light-text-secondary mb-3">
                                        {{ $patchNote->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-4 dark:text-dark-text-tertiary text-light-text-tertiary">
                                <span>Released {{ $patchNote->released_at ? $patchNote->released_at->format('M d, Y') : 'recently' }}</span>
                                <span>•</span>
                                <span>👁 {{ $patchNote->views_count }} views</span>
                            </div>
                            <a href="{{ route('patch-notes.show', $patchNote) }}" class="text-primary-600 hover:text-primary-800 font-medium">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">No Patch Notes Found</h3>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $selectedGame ? "No patch notes found for $selectedGame." : 'Check back later for the latest game updates!' }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($patchNotes->hasPages())
        <div class="mt-6">
            {{ $patchNotes->links() }}
        </div>
    @endif
</div>
@endsection
