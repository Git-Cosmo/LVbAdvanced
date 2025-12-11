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
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 border border-transparent dark:border-dark-border-primary border-light-border-primary">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-purple to-accent-blue rounded-2xl flex items-center justify-center overflow-hidden">
                            @if($currentArtwork)
                                <img src="{{ $currentArtwork }}" alt="Now playing artwork" class="w-full h-full" loading="lazy">
                            @else
                                <span class="text-xs uppercase tracking-wider text-white">AZ</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary">Now Playing</p>
                            <h3 class="text-2xl font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $currentTitle }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $currentArtist }}@if($currentAlbum) · {{ $currentAlbum }}@endif</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full {{ $stationOnline ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                            {{ $stationOnline ? 'On Air' : 'Offline' }}
                        </span>
                    </div>
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

            <!-- Latest Downloads -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        Latest Downloads
                    </h3>
                    <a href="{{ route('downloads.index') }}" class="text-sm text-accent-blue hover:text-accent-purple transition-colors">
                        View All →
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @forelse($latestDownloads as $download)
                        <a href="{{ route('downloads.show', $download) }}" class="block dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative h-32 dark:bg-dark-bg-elevated bg-light-bg-elevated">
                                @if($download->galleryMedia->first())
                                    <img src="{{ $download->galleryMedia->first()->url }}" alt="{{ $download->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 px-2 py-1 bg-accent-blue rounded text-white text-xs font-semibold">
                                    {{ $download->game }}
                                </div>
                            </div>
                            <div class="p-3">
                                <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm line-clamp-1 mb-1">
                                    {{ $download->title }}
                                </h4>
                                <div class="flex items-center justify-between text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                    <span>⬇ {{ $download->downloads }}</span>
                                    <span>{{ $download->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                No downloads yet. Be the first to upload!
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
@endsection
