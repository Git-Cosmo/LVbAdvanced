@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                Streamer Bans
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                Track ban history and statistics for your favorite streamers
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Streamers</p>
                        <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['total_streamers'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-blue/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Bans Tracked</p>
                        <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ number_format($stats['total_bans']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-red/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="mb-8 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <form method="GET" action="{{ route('streamerbans.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search streamers..." 
                           class="w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-bright text-light-text-bright rounded-lg border border-transparent focus:border-accent-blue focus:ring focus:ring-accent-blue/20 focus:outline-none">
                </div>
                <div>
                    <select name="sort" 
                            onchange="this.form.submit()"
                            class="px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-bright text-light-text-bright rounded-lg border border-transparent focus:border-accent-blue focus:ring focus:ring-accent-blue/20 focus:outline-none">
                        <option value="most_bans" {{ $sort === 'most_bans' ? 'selected' : '' }}>Most Bans</option>
                        <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>Recently Updated</option>
                        <option value="alphabetical" {{ $sort === 'alphabetical' ? 'selected' : '' }}>Alphabetical</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors font-medium">
                    Search
                </button>
            </form>
        </div>

        <!-- Streamers Grid -->
        @if($streamers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($streamers as $streamer)
                    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <a href="{{ route('streamerbans.show', $streamer) }}" class="block p-6">
                            <!-- Avatar and Username -->
                            <div class="flex items-center mb-4">
                                @if($streamer->avatar_url)
                                    <img src="{{ $streamer->avatar_url }}" 
                                         alt="{{ $streamer->username }}"
                                         class="w-16 h-16 rounded-full mr-4">
                                @else
                                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright group-hover:text-accent-blue transition-colors">
                                        {{ $streamer->username }}
                                    </h3>
                                    @if($streamer->is_featured)
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold bg-accent-purple/20 text-accent-purple rounded">
                                            ★ Featured
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-3">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Total Bans</p>
                                    <p class="text-2xl font-bold text-accent-red">{{ $streamer->total_bans }}</p>
                                </div>
                                <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-3">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Views</p>
                                    <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $streamer->views_count }}</p>
                                </div>
                            </div>

                            <!-- Last Ban -->
                            @if($streamer->last_ban)
                                <div class="mt-4 pt-4 border-t dark:border-dark-border border-light-border">
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                        <span class="font-semibold">Last Ban:</span> {{ $streamer->last_ban }}
                                    </p>
                                </div>
                            @endif
                            
                            @if($streamer->longest_ban)
                                <div class="mt-2">
                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                        <span class="font-semibold">Longest:</span> {{ $streamer->longest_ban }}
                                    </p>
                                </div>
                            @endif
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $streamers->links() }}
            </div>
        @else
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xl dark:text-dark-text-secondary text-light-text-secondary">No streamers found</p>
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mt-2">Try adjusting your search or filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
