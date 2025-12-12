@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            🎵 Song Requests
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Browse and request songs from our music library
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if(!auth()->check())
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="dark:text-dark-text-primary text-light-text-primary">
                    You must be <a href="{{ route('login') }}" class="text-accent-blue hover:underline">logged in</a> to request songs.
                </p>
            </div>
        </div>
    @endif

    <!-- Requestable Songs -->
    @if(isset($requestableSongs) && count($requestableSongs) > 0)
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">
                    Available Songs
                </h2>
                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    {{ count($requestableSongs) }} songs available
                </span>
            </div>

            <!-- Search Filter -->
            <div class="mb-6">
                <input type="text" 
                       id="search-songs" 
                       placeholder="Search songs, artists, or albums..." 
                       class="w-full px-4 py-3 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary border dark:border-dark-border-primary border-light-border-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
            </div>

            <!-- Songs Grid -->
            <div id="songs-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($requestableSongs as $song)
                    <div class="song-item p-4 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all"
                         data-search-text="{{ strtolower(($song['song']['title'] ?? '') . ' ' . ($song['song']['artist'] ?? '') . ' ' . ($song['song']['album'] ?? '')) }}">
                        <div class="flex items-center space-x-4">
                            @if(isset($song['song']['art']))
                                <img src="{{ $song['song']['art'] }}" 
                                     alt="Album Art" 
                                     class="w-20 h-20 rounded-lg shadow">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold dark:text-dark-text-bright text-light-text-bright truncate">
                                    {{ $song['song']['title'] ?? 'Unknown Title' }}
                                </h3>
                                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary truncate">
                                    {{ $song['song']['artist'] ?? 'Unknown Artist' }}
                                </p>
                                @if(isset($song['song']['album']))
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary truncate">
                                        {{ $song['song']['album'] }}
                                    </p>
                                @endif
                            </div>

                            @auth
                                <form method="POST" action="{{ route('radio.request.submit') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="request_id" value="{{ $song['request_id'] ?? $song['track_id'] ?? '' }}">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-lg font-semibold transition-all transform hover:scale-105 text-sm">
                                        Request
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="px-4 py-2 bg-gray-600 text-gray-400 rounded-lg text-sm cursor-not-allowed">
                                    Login Required
                                </button>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="no-results" class="hidden text-center py-8">
                <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    No songs found matching your search
                </p>
            </div>
        </div>
    @else
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                No Songs Available
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Song requests are currently unavailable. Please check back later or contact an administrator.
            </p>
        </div>
    @endif
</div>

<script>
    // Search functionality
    const searchInput = document.getElementById('search-songs');
    const songsContainer = document.getElementById('songs-container');
    const noResults = document.getElementById('no-results');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const songItems = document.querySelectorAll('.song-item');
            let visibleCount = 0;

            songItems.forEach(item => {
                const searchText = item.getAttribute('data-search-text');
                if (searchText.includes(searchTerm)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0 && searchTerm !== '') {
                noResults.classList.remove('hidden');
                songsContainer.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                songsContainer.classList.remove('hidden');
            }
        });
    }
</script>
@endsection
