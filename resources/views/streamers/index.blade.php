@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🎮 Live Streamers</h1>
        <p class="dark:text-dark-text-secondary text-lg">Watch top gaming streamers live on Twitch & Kick</p>
    </div>

    <!-- Platform Filter -->
    <div class="flex justify-center gap-4 mb-8">
        <a href="{{ route('streamers.index', ['platform' => 'all']) }}" 
           class="px-6 py-2 rounded-lg {{ $platform === 'all' ? 'bg-gradient-to-r from-accent-blue to-accent-purple text-white' : 'dark:bg-dark-bg-secondary dark:text-dark-text-secondary hover:dark:bg-dark-bg-tertiary' }}">
            All Platforms
        </a>
        <a href="{{ route('streamers.index', ['platform' => 'twitch']) }}" 
           class="px-6 py-2 rounded-lg {{ $platform === 'twitch' ? 'bg-purple-600 text-white' : 'dark:bg-dark-bg-secondary dark:text-dark-text-secondary hover:dark:bg-dark-bg-tertiary' }}">
            Twitch
        </a>
        <a href="{{ route('streamers.index', ['platform' => 'kick']) }}" 
           class="px-6 py-2 rounded-lg {{ $platform === 'kick' ? 'bg-green-600 text-white' : 'dark:bg-dark-bg-secondary dark:text-dark-text-secondary hover:dark:bg-dark-bg-tertiary' }}">
            Kick
        </a>
    </div>

    <!-- Streamers Grid -->
    @if($streamers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($streamers as $streamer)
                <a href="{{ $streamer->channel_url }}" target="_blank" class="block dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden hover:border-accent-blue transition-colors group">
                    <!-- Thumbnail -->
                    <div class="relative aspect-video bg-gray-800">
                        @if($streamer->thumbnail_url)
                            <img src="{{ $streamer->thumbnail_url }}" alt="{{ $streamer->display_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-4xl">📺</span>
                            </div>
                        @endif
                        
                        <!-- Live Badge -->
                        <div class="absolute top-2 left-2 px-2 py-1 bg-red-600 text-white text-xs font-semibold rounded flex items-center gap-1">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                            LIVE
                        </div>

                        <!-- Viewer Count -->
                        <div class="absolute top-2 right-2 px-2 py-1 bg-black/70 text-white text-xs font-semibold rounded">
                            👁️ {{ $streamer->formatted_viewers }}
                        </div>

                        <!-- Platform Badge -->
                        <div class="absolute bottom-2 right-2 px-2 py-1 {{ $streamer->platform === 'twitch' ? 'bg-purple-600' : 'bg-green-600' }} text-white text-xs font-semibold rounded">
                            {{ ucfirst($streamer->platform) }}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <!-- Profile -->
                        <div class="flex items-center gap-3 mb-3">
                            @if($streamer->profile_image_url)
                                <img src="{{ $streamer->profile_image_url }}" alt="{{ $streamer->display_name }}" class="w-10 h-10 rounded-full">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                    {{ substr($streamer->display_name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold dark:text-dark-text-bright truncate">{{ $streamer->display_name }}</h3>
                                @if($streamer->game_name)
                                    <p class="text-xs dark:text-dark-text-tertiary truncate">{{ $streamer->game_name }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Stream Title -->
                        @if($streamer->stream_title)
                            <p class="text-sm dark:text-dark-text-secondary line-clamp-2 mb-2">{{ $streamer->stream_title }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gradient-to-br from-accent-blue to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-4xl">📺</span>
            </div>
            <h3 class="text-2xl font-bold dark:text-dark-text-bright mb-2">No Live Streamers</h3>
            <p class="dark:text-dark-text-secondary mb-4">Check back later for live streams!</p>
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <form action="{{ route('streamers.sync') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-accent-blue text-white rounded-lg hover:bg-accent-blue-bright transition-colors">
                            Sync Streamers Now
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    @endif

    <!-- Info Box -->
    <div class="mt-12 dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
        <h3 class="font-semibold dark:text-dark-text-bright mb-3">About Live Streamers</h3>
        <p class="dark:text-dark-text-secondary text-sm mb-3">
            Discover and watch the top gaming streamers currently live on Twitch and Kick. Our list updates automatically every 5 minutes to show you who's streaming right now.
        </p>
        <p class="dark:text-dark-text-secondary text-sm">
            Click on any streamer card to watch their stream directly on their platform.
        </p>
    </div>
</div>
@endsection
