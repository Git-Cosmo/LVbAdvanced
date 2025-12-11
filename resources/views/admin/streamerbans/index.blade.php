@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            StreamerBans Management
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Manage streamer ban data scraped from streamerbans.com
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Published</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['published_streamers'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-green/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Featured</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['featured_streamers'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-purple/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Bans</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['total_bans_tracked'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-red/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8 space-y-4">
        <div class="flex flex-wrap gap-4">
            <!-- Scrape All -->
            <form action="{{ route('admin.streamerbans.scrape') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="action" value="all">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Scrape All Streamers
                </button>
            </form>

            <!-- Update Existing -->
            <form action="{{ route('admin.streamerbans.scrape') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="limit" value="50">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-accent-green hover:bg-green-600 text-white rounded-lg transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Update 50 Oldest
                </button>
            </form>
        </div>

        <!-- Scrape Specific Streamer -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">
                Scrape Specific Streamer
            </h3>
            <form action="{{ route('admin.streamerbans.scrape-streamer') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="username" placeholder="Enter streamer username" required
                    class="flex-1 px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-bright text-light-text-bright rounded-lg border border-transparent focus:border-accent-blue focus:ring focus:ring-accent-blue/20 focus:outline-none">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors font-medium">
                    Scrape
                </button>
            </form>
        </div>
    </div>

    <!-- Most Banned Streamers -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Top 10 Most Banned Streamers
        </h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b dark:border-dark-border border-light-border">
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Username</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Total Bans</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Last Ban</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-dark-border divide-light-border">
                    @forelse($mostBanned as $streamer)
                        <tr class="hover:bg-dark-bg-tertiary transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if($streamer->avatar_url)
                                        <img src="{{ $streamer->avatar_url }}" alt="{{ $streamer->username }}" class="w-8 h-8 rounded-full mr-3">
                                    @endif
                                    <span class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $streamer->username }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-bright text-light-text-bright">
                                <span class="px-3 py-1 bg-accent-red/20 text-accent-red rounded-full text-sm font-semibold">
                                    {{ $streamer->total_bans }}
                                </span>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $streamer->last_ban ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($streamer->is_published)
                                    <span class="px-3 py-1 bg-accent-green/20 text-accent-green rounded-full text-xs font-semibold">Published</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-xs font-semibold">Draft</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                                No streamers found. Run the scraper to import data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Streamers -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Recently Scraped Streamers
        </h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b dark:border-dark-border border-light-border">
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Username</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Total Bans</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Last Scraped</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold dark:text-dark-text-secondary text-light-text-secondary">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-dark-border divide-light-border">
                    @forelse($recentStreamers as $streamer)
                        <tr class="hover:bg-dark-bg-tertiary transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if($streamer->avatar_url)
                                        <img src="{{ $streamer->avatar_url }}" alt="{{ $streamer->username }}" class="w-8 h-8 rounded-full mr-3">
                                    @endif
                                    <a href="{{ route('streamerbans.show', $streamer) }}" target="_blank" class="font-medium dark:text-dark-text-bright text-light-text-bright hover:text-accent-blue">
                                        {{ $streamer->username }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-bright text-light-text-bright">
                                {{ $streamer->total_bans }}
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $streamer->last_scraped_at ? $streamer->last_scraped_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.streamerbans.toggle-publish', $streamer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-medium rounded {{ $streamer->is_published ? 'bg-accent-green/20 text-accent-green hover:bg-accent-green/30' : 'bg-gray-500/20 text-gray-400 hover:bg-gray-500/30' }} transition-colors">
                                            {{ $streamer->is_published ? 'Published' : 'Unpublished' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.streamerbans.toggle-feature', $streamer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-medium rounded {{ $streamer->is_featured ? 'bg-accent-purple/20 text-accent-purple hover:bg-accent-purple/30' : 'bg-gray-500/20 text-gray-400 hover:bg-gray-500/30' }} transition-colors">
                                            {{ $streamer->is_featured ? '★ Featured' : 'Feature' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.streamerbans.delete', $streamer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this streamer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-xs font-medium rounded bg-accent-red/20 text-accent-red hover:bg-accent-red/30 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                                No streamers found. Run the scraper to import data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
