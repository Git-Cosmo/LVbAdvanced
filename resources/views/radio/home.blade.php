@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            🎵 Radio Home
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Your central hub for FPSociety live radio featuring gaming music, community shows, and more
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Now Playing Section -->
        <div class="lg:col-span-2">
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Now Playing
                </h2>
                
                @if($nowPlaying && isset($nowPlaying['now_playing']))
                    <div class="flex items-center space-x-4 mb-6">
                        @if(isset($nowPlaying['now_playing']['song']['art']))
                            <img src="{{ $nowPlaying['now_playing']['song']['art'] }}" 
                                 alt="Album Art" 
                                 class="w-32 h-32 rounded-lg shadow-lg">
                        @else
                            <div class="w-32 h-32 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                                {{ $nowPlaying['now_playing']['song']['title'] ?? 'Unknown Track' }}
                            </h3>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $nowPlaying['now_playing']['song']['artist'] ?? 'Unknown Artist' }}
                            </p>
                            @if(isset($nowPlaying['now_playing']['song']['album']))
                                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
                                    {{ $nowPlaying['now_playing']['song']['album'] }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Station Status -->
                    <div class="flex items-center space-x-2 mb-4">
                        @if($nowPlaying['is_online'])
                            <span class="flex items-center px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                Live
                            </span>
                        @else
                            <span class="flex items-center px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">
                                <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                Offline
                            </span>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="dark:text-dark-text-secondary text-light-text-secondary">
                            No current track information available
                        </p>
                    </div>
                @endif

                <!-- Quick Player Controls -->
                <div class="flex space-x-3 mt-6">
                    <button onclick="openPopout()" class="flex-1 bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-lg px-6 py-3 font-semibold transition-all transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                        Launch Player
                    </button>
                    <a href="{{ route('radio.requests') }}" class="flex-1 bg-dark-bg-tertiary hover:bg-dark-bg-elevated text-dark-text-bright rounded-lg px-6 py-3 font-semibold transition-all text-center">
                        Request Song
                    </a>
                </div>
            </div>

            <!-- Playing Next -->
            @if($nowPlaying && isset($nowPlaying['playing_next']))
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                        Playing Next
                    </h3>
                    <div class="flex items-center space-x-3">
                        @if(isset($nowPlaying['playing_next']['song']['art']))
                            <img src="{{ $nowPlaying['playing_next']['song']['art'] }}" 
                                 alt="Album Art" 
                                 class="w-16 h-16 rounded">
                        @else
                            <div class="w-16 h-16 bg-dark-bg-tertiary rounded flex items-center justify-center">
                                <svg class="w-8 h-8 dark:text-dark-text-tertiary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold dark:text-dark-text-bright text-light-text-bright">
                                {{ $nowPlaying['playing_next']['song']['title'] ?? 'Unknown' }}
                            </p>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $nowPlaying['playing_next']['song']['artist'] ?? 'Unknown' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Recent History -->
            @if($nowPlaying && isset($nowPlaying['song_history']) && count($nowPlaying['song_history']) > 0)
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Recently Played
                    </h3>
                    <div class="space-y-3">
                        @foreach(array_slice($nowPlaying['song_history'], 0, 5) as $track)
                            <div class="flex items-center space-x-3 p-2 rounded hover:bg-dark-bg-tertiary transition-colors">
                                @if(isset($track['song']['art']))
                                    <img src="{{ $track['song']['art'] }}" 
                                         alt="Album Art" 
                                         class="w-12 h-12 rounded">
                                @else
                                    <div class="w-12 h-12 bg-dark-bg-tertiary rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 dark:text-dark-text-tertiary" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright truncate">
                                        {{ $track['song']['title'] ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary truncate">
                                        {{ $track['song']['artist'] ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Links -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    Quick Links
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('radio.index') }}" class="block p-3 rounded-lg hover:bg-dark-bg-tertiary transition-colors">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <span class="dark:text-dark-text-primary text-light-text-primary">Radio Player</span>
                        </div>
                    </a>
                    <a href="{{ route('radio.requests') }}" class="block p-3 rounded-lg hover:bg-dark-bg-tertiary transition-colors">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="dark:text-dark-text-primary text-light-text-primary">Song Requests</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openPopout() {
        window.open('{{ route("radio.popout") }}', 'RadioPopout', 'width=400,height=500,resizable=yes,scrollbars=no');
    }
</script>
@endsection
