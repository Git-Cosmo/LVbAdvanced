@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Left Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Welcome Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            @guest
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Welcome to FPSociety
                </h3>
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                    Join the ultimate gaming community for Counter Strike 2, GTA V, Fortnite, and more. Share mods, compete, and connect!
                </p>
                <div class="space-y-2">
                    <a href="/register" class="block w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white text-center rounded-lg font-medium hover:shadow-lg transition-all">
                        Sign Up
                    </a>
                    <a href="/login" class="block w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary text-center rounded-lg font-medium dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                        Sign In
                    </a>
                </div>
            @else
                @php
                    $user = auth()->user();
                    $profile = $user->profile;
                    $role = $user->roles->first()?->name ?? 'Member';
                @endphp
                <div class="text-center mb-4">
                    <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">
                        {{ $user->name }}
                    </h3>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $role }}
                    </p>
                </div>

                <div class="space-y-3 mb-4 pb-4 border-b dark:border-dark-border-primary border-light-border-primary">
                    <div class="flex items-center justify-between">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Level:</span>
                        <span class="text-sm font-semibold dark:text-dark-text-accent text-light-text-accent">{{ $profile->level ?? 1 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">XP:</span>
                        <span class="text-sm font-semibold text-accent-purple">{{ $profile->xp ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Karma:</span>
                        <span class="text-sm font-semibold text-accent-green">{{ $profile->karma ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Posts:</span>
                        <span class="text-sm font-semibold dark:text-dark-text-primary text-light-text-primary">{{ $user->posts()->count() }}</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('profile.show', $user) }}" class="block w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary text-center rounded-lg font-medium hover:shadow-lg transition-all text-sm">
                        View Profile
                    </a>
                    <a href="{{ route('settings.index') }}" class="block w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary text-center rounded-lg font-medium hover:shadow-lg transition-all text-sm">
                        Settings
                    </a>
                </div>
            @endguest
        </div>

        <!-- Stats Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Forum Statistics
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Forums:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\Forum::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Threads:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumThread::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Posts:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumPost::count() }}</span>
                </div>
            </div>
        </div>

        <!-- Game Servers Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                    Game Servers
                </div>
            </h3>
            <div class="space-y-3">
                @forelse($gameServers as $server)
                    <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-3 border dark:border-dark-border-primary border-light-border-primary hover:border-accent-blue transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded flex items-center justify-center" style="background: linear-gradient(to bottom right, {{ $server->icon_color_from }}, {{ $server->icon_color_to }});">
                                    <span class="text-white font-bold text-xs">{{ $server->game_short_code }}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">{{ $server->name }}</h4>
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">{{ $server->game_mode ?? $server->game }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded font-semibold
                                @if($server->status === 'online') bg-emerald-500/20 text-emerald-600 dark:text-emerald-400
                                @elseif($server->status === 'offline') bg-rose-500/20 text-rose-600 dark:text-rose-400
                                @elseif($server->status === 'maintenance') bg-amber-500/20 text-amber-600 dark:text-amber-400
                                @else bg-yellow-500/20 text-yellow-600 dark:text-yellow-400
                                @endif">
                                {{ $server->status_label }}
                            </span>
                        </div>
                        @if($server->description)
                            <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-2">{{ $server->description }}</p>
                        @endif
                        @if($server->connect_address && $server->status === 'online')
                            <div class="flex items-center justify-between">
                                <code class="text-xs bg-gray-100 dark:bg-dark-bg-elevated px-2 py-1 rounded">{{ $server->connect_address }}</code>
                                @if($server->max_players)
                                    <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">{{ $server->current_players }}/{{ $server->max_players }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 mx-auto mb-3 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
                            No game servers available yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Links Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Quick Links
            </h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('forum.index') }}" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Forum Index
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Recent Posts
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Top Members
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Help & FAQ
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Center Content -->
    <div class="col-span-12 lg:col-span-6">
        <div class="space-y-6">
            @php
                $currentSong = $nowPlaying['song'] ?? [];
                $currentTitle = $currentSong['title'] ?? 'Nothing playing right now';
                $currentArtist = $currentSong['artist'] ?? 'Waiting for the DJ';
                $currentAlbum = $currentSong['album'] ?? null;
                $currentArtwork = $currentSong['art'] ?? $currentSong['artwork'] ?? null;

                $nextSong = ($upNext['song'] ?? []);
                $nextTitle = $nextSong['title'] ?? 'Queue is empty';
                $nextArtist = $nextSong['artist'] ?? null;
            @endphp

            <!-- Live Radio Now Playing -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden border border-transparent dark:border-dark-border-primary border-light-border-primary">
                <!-- Header with controls -->
                <div class="bg-gradient-to-r from-accent-blue to-accent-purple p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/10 backdrop-blur rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-white/80">Live Radio</p>
                                <p class="text-white font-semibold">FPSociety Radio</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full {{ $stationOnline ? 'bg-emerald-500/30 text-white' : 'bg-rose-500/30 text-white' }}">
                            {{ $stationOnline ? '● On Air' : '○ Offline' }}
                        </span>
                    </div>
                </div>

                <!-- Now Playing Info -->
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-accent-purple to-accent-blue rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($currentArtwork)
                                <img src="{{ $currentArtwork }}" alt="Now playing artwork" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary mb-1">Now Playing</p>
                            <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright truncate">{{ $currentTitle }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary truncate">{{ $currentArtist }}@if($currentAlbum) · {{ $currentAlbum }}@endif</p>
                        </div>
                    </div>

                    <!-- Player Controls -->
                    @if(config('services.icecast.stream_url'))
                        <div class="space-y-3">
                            <audio id="home-radio-player" preload="none" class="hidden">
                                <source src="{{ config('services.icecast.stream_url') }}" type="audio/mpeg">
                            </audio>
                            
                            <div class="flex items-center gap-3">
                                <button id="home-play-btn" class="bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg transition-all flex-shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </button>
                                
                                <div class="flex-1 flex items-center gap-2">
                                    <svg class="w-4 h-4 dark:text-dark-text-tertiary text-light-text-tertiary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"/>
                                    </svg>
                                    <input type="range" id="home-volume-control" min="0" max="100" value="75" class="flex-1 h-2 bg-gray-200 dark:bg-dark-bg-tertiary rounded-lg appearance-none cursor-pointer">
                                    <span id="home-volume-display" class="text-xs dark:text-dark-text-secondary text-light-text-secondary w-8 flex-shrink-0">75%</span>
                                </div>

                                <button onclick="window.open('{{ route('radio.popout') }}', 'RadioPopout', 'width=400,height=500,resizable=yes,scrollbars=no')" class="text-xs px-3 py-1.5 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:bg-accent-blue hover:text-white transition-colors flex-shrink-0">
                                    Popout
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 p-4 bg-gradient-to-b from-black/5 to-transparent rounded-2xl">
                        <p class="text-xs uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary">Next Up</p>
                        <p class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $nextTitle }}</p>
                        <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $nextArtist ?? 'Curating the queue...' }}</p>
                    </div>
                    <div class="space-y-2 p-4 bg-gradient-to-b from-black/5 to-transparent rounded-2xl">
                        <p class="text-xs uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary">Recent History</p>
                        <ul class="space-y-2 text-sm">
                            @forelse($recentSongs as $entry)
                                @php $historySong = $entry['song'] ?? []; @endphp
                                <li class="flex justify-between">
                                    <span class="dark:text-dark-text-bright text-light-text-bright">{{ $historySong['title'] ?? 'Unknown track' }}</span>
                                    <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $historySong['artist'] ?? '' }}</span>
                                </li>
                            @empty
                                <li class="text-xs dark:text-dark-text-secondary text-light-text-secondary">History is loading…</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Latest News -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        Gaming News & Updates
                    </h3>
                    <a href="{{ route('news.index') }}" class="text-sm text-accent-blue hover:text-accent-purple transition-colors">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($latestNews as $news)
                        <article class="border-b dark:border-dark-border-primary border-light-border-primary pb-4 last:border-0">
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">
                                <a href="{{ route('news.show', $news) }}" class="hover:text-accent-blue transition-colors">
                                    {{ $news->title }}
                                </a>
                            </h4>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-2 line-clamp-2">
                                {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 150) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                    Posted on {{ $news->published_at->format('M d, Y') }}
                                </span>
                                @if($news->views_count > 0)
                                    <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                        {{ $news->views_count }} views
                                    </span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <article class="text-center py-8">
                            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                No news articles yet. Check back soon!
                            </p>
                        </article>
                    @endforelse
                </div>
            </div>

            <!-- Latest Game Deals -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 2v8m0 0v2m0-2c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Latest Game Deals
                        </div>
                    </h3>
                    <a href="{{ route('games.deals') }}" class="text-sm text-accent-blue hover:text-accent-purple transition-colors">
                        View All →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($latestDeals as $deal)
                        <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-3 hover:shadow-lg transition-all border dark:border-dark-border-primary border-light-border-primary hover:border-accent-green">
                            <div class="flex items-center gap-3">
                                @if($deal->game && $deal->game->thumb)
                                    <img src="{{ $deal->game->thumb }}" alt="{{ $deal->game->title ?? 'Game' }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-accent-blue to-accent-purple rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm line-clamp-1 mb-1">
                                        {{ $deal->game->title ?? 'Unknown Game' }}
                                    </h4>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs line-through dark:text-dark-text-tertiary text-light-text-tertiary">
                                            ${{ number_format($deal->normal_price, 2) }}
                                        </span>
                                        <span class="text-sm font-bold text-accent-green">
                                            ${{ number_format($deal->sale_price, 2) }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-accent-red text-white text-xs font-bold rounded">
                                            -{{ number_format($deal->savings, 0) }}%
                                        </span>
                                    </div>
                                    @if($deal->store)
                                        <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                            {{ $deal->store->store_name }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-3 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 2v8m0 0v2m0-2c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                No deals available right now. Check back soon!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Deals -->
            @if($latestDeals->count() > 0)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        🔥 Hot Game Deals
                    </h3>
                    <a href="{{ route('deals.index') }}" class="text-sm text-accent-blue hover:text-accent-purple transition-colors">
                        View All →
                    </a>
                </div>
                <div class="space-y-3">
                    @foreach($latestDeals->take(3) as $deal)
                        <div class="flex items-center gap-3 p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                            @if($deal->game && $deal->game->thumb)
                                <img src="{{ $deal->game->thumb }}" alt="{{ $deal->game->title ?? 'Game' }}" class="w-16 h-16 object-cover rounded">
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm line-clamp-1">
                                    {{ $deal->game->title ?? 'Unknown Game' }}
                                </h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs line-through dark:text-dark-text-tertiary text-light-text-tertiary">
                                        ${{ number_format($deal->normal_price, 2) }}
                                    </span>
                                    <span class="text-sm font-bold text-accent-green">
                                        ${{ number_format($deal->sale_price, 2) }}
                                    </span>
                                    <span class="px-2 py-0.5 bg-accent-red text-white text-xs font-bold rounded">
                                        -{{ round($deal->savings) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Features Overview -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Community Features
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Game Downloads</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Maps, mods, skins & more</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-purple to-accent-pink rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">XP & Leveling</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Earn rewards for activity</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-green to-accent-teal rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Leaderboards</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Compete with gamers</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-orange to-accent-red rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Tournaments</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Compete & win prizes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Online Users Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Who's Online
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Guests:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Total:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
            </div>
        </div>

        <!-- Recent Forum Activity Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">
                    Recent Threads
                </h3>
                <a href="{{ route('forum.index') }}" class="text-xs text-accent-blue hover:text-accent-purple transition-colors">
                    View All →
                </a>
            </div>
            <div class="space-y-3 text-sm">
                @forelse($recentThreads as $thread)
                    <div class="border-b dark:border-dark-border-primary border-light-border-primary pb-3 last:border-0">
                        <a href="{{ route('forum.thread.show', $thread->slug) }}" class="dark:text-dark-text-primary text-light-text-primary hover:text-accent-blue transition-colors line-clamp-2 font-medium">
                            {{ $thread->title }}
                        </a>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                by {{ $thread->user->name }}
                            </span>
                            <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                {{ $thread->last_post_at?->diffForHumans() ?? $thread->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="dark:text-dark-text-secondary text-light-text-secondary">
                            No recent threads yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Events Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Upcoming Events
                    </div>
                </h3>
                <a href="{{ route('events.index') }}" class="text-xs text-accent-blue hover:text-accent-purple transition-colors">
                    View All →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($upcomingEvents as $event)
                    @php
                        $eventDate = $event->start_time ? \Carbon\Carbon::parse($event->start_time) : null;
                    @endphp
                    <a href="{{ route('events.show', $event->slug) }}" class="block dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-3 hover:shadow-lg transition-all border dark:border-dark-border-primary border-light-border-primary hover:border-accent-purple">
                        <div class="flex items-start gap-3">
                            <!-- Date Badge -->
                            <div class="flex-shrink-0 w-12 text-center">
                                <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated rounded-lg p-2 border-2 border-accent-purple">
                                    <p class="text-xs font-bold text-accent-purple uppercase">
                                        {{ $eventDate ? $eventDate->format('M') : 'TBA' }}
                                    </p>
                                    <p class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright leading-none">
                                        {{ $eventDate ? $eventDate->format('d') : '--' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Event Info -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm line-clamp-2 mb-1">
                                    {{ $event->name }}
                                </h4>
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($event->event_type)
                                        <span class="px-2 py-0.5 bg-accent-blue/20 text-accent-blue text-xs rounded font-medium capitalize">
                                            {{ $event->event_type }}
                                        </span>
                                    @endif
                                    @if($event->is_virtual)
                                        <span class="px-2 py-0.5 bg-accent-green/20 text-accent-green text-xs rounded font-medium">
                                            Virtual
                                        </span>
                                    @endif
                                </div>
                                @if($eventDate)
                                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1">
                                        {{ $eventDate->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 mx-auto mb-3 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
                            No upcoming events yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Community Info Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Popular Games
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                Find content, discussions, and downloads for your favorite games!
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">CS2</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">GTA V</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Fortnite</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Call of Duty</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Minecraft</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Valorant</span>
            </div>
        </div>
    </aside>
</div>

@if(config('services.icecast.stream_url'))
<script>
    // Home radio player controls
    const homePlayer = document.getElementById('home-radio-player');
    const homePlayBtn = document.getElementById('home-play-btn');
    const homeVolumeControl = document.getElementById('home-volume-control');
    const homeVolumeDisplay = document.getElementById('home-volume-display');

    if (homePlayer && homePlayBtn) {
        // Icon constants
        const ICON_PLAY = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>';
        const ICON_PAUSE = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';

        // Set initial volume
        homePlayer.volume = 0.75;

        // Play/Pause button
        homePlayBtn.addEventListener('click', () => {
            if (homePlayer.paused) {
                homePlayer.play();
                homePlayBtn.innerHTML = ICON_PAUSE;
            } else {
                homePlayer.pause();
                homePlayBtn.innerHTML = ICON_PLAY;
            }
        });

        // Volume control
        if (homeVolumeControl && homeVolumeDisplay) {
            homeVolumeControl.addEventListener('input', (e) => {
                const volume = e.target.value / 100;
                homePlayer.volume = volume;
                homeVolumeDisplay.textContent = e.target.value + '%';
            });
        }
    }
</script>
@endif
@endsection
