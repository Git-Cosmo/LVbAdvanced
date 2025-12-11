@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('streamerbans.index') }}" class="inline-flex items-center text-accent-blue hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to all streamers
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2">
                <!-- Header Card -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-8 shadow-lg mb-8">
                    <div class="flex items-start">
                        @if($streamerBan->avatar_url)
                            <img src="{{ $streamerBan->avatar_url }}" 
                                 alt="{{ $streamerBan->username }}"
                                 class="w-24 h-24 rounded-full mr-6">
                        @else
                            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mr-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
                                    {{ $streamerBan->username }}
                                </h1>
                                @if($streamerBan->is_featured)
                                    <span class="px-3 py-1 text-sm font-semibold bg-accent-purple/20 text-accent-purple rounded-full">
                                        ★ Featured
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $streamerBan->views_count }} views
                                </span>
                                
                                @if($streamerBan->last_scraped_at)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Updated {{ $streamerBan->last_scraped_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4">
                                <a href="{{ $streamerBan->streamer_bans_url }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center text-accent-blue hover:text-blue-600 transition-colors">
                                    View on StreamerBans.com
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                        <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-2">Total Bans</p>
                        <p class="text-4xl font-bold text-accent-red">{{ $streamerBan->total_bans }}</p>
                    </div>
                    
                    @if($streamerBan->last_ban)
                        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-2">Last Ban</p>
                            <p class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">{{ $streamerBan->last_ban }}</p>
                        </div>
                    @endif
                    
                    @if($streamerBan->longest_ban)
                        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-2">Longest Ban</p>
                            <p class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">{{ $streamerBan->longest_ban }}</p>
                        </div>
                    @endif
                </div>

                <!-- Ban History -->
                @if($streamerBan->ban_history && count($streamerBan->ban_history) > 0)
                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">
                                <svg class="w-6 h-6 inline-block mr-2 text-accent-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Recent Activity Timeline
                            </h2>
                            <span class="px-3 py-1 bg-accent-blue/20 text-accent-blue rounded-full text-sm font-semibold">
                                {{ count($streamerBan->ban_history) }} {{ count($streamerBan->ban_history) === 1 ? 'Event' : 'Events' }}
                            </span>
                        </div>
                        
                        <!-- Timeline -->
                        <div class="relative">
                            <!-- Timeline line -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-accent-red via-accent-orange to-accent-blue"></div>
                            
                            <div class="space-y-6">
                                @foreach($streamerBan->ban_history as $index => $ban)
                                    <div class="relative pl-12">
                                        <!-- Timeline dot -->
                                        <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center
                                                    @if($index === 0) bg-accent-red
                                                    @elseif($index < 3) bg-accent-orange
                                                    @else bg-accent-blue
                                                    @endif
                                                    shadow-lg">
                                            @if(isset($ban['activity']) && (stripos($ban['activity'], 'banned') !== false || stripos($ban['activity'], 'timeout') !== false))
                                                <!-- Ban icon -->
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            @elseif(isset($ban['activity']) && stripos($ban['activity'], 'unbanned') !== false)
                                                <!-- Unban icon -->
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @else
                                                <!-- Default activity icon -->
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        
                                        <!-- Event card -->
                                        <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-200">
                                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-2">
                                                @if(isset($ban['activity']))
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold text-lg dark:text-dark-text-bright text-light-text-bright">
                                                            {{ $ban['activity'] }}
                                                        </span>
                                                        @if(stripos($ban['activity'], 'banned') !== false || stripos($ban['activity'], 'timeout') !== false)
                                                            <span class="px-2 py-0.5 bg-accent-red/20 text-accent-red rounded text-xs font-semibold uppercase">
                                                                Ban
                                                            </span>
                                                        @elseif(stripos($ban['activity'], 'unbanned') !== false)
                                                            <span class="px-2 py-0.5 bg-accent-green/20 text-accent-green rounded text-xs font-semibold uppercase">
                                                                Lifted
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                @if(isset($ban['date']))
                                                    <div class="flex items-center text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="font-medium">{{ $ban['date'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if(isset($ban['reason']))
                                                <div class="mt-2 p-3 bg-white/5 rounded-md">
                                                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                                        <span class="font-semibold text-accent-orange">Reason:</span> 
                                                        <span class="ml-1">{{ $ban['reason'] }}</span>
                                                    </p>
                                                </div>
                                            @endif
                                            
                                            @if(isset($ban['duration']))
                                                <div class="mt-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-accent-orange">
                                                        Duration: {{ $ban['duration'] }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if(isset($ban['text']) && !isset($ban['activity']))
                                                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                                    {{ $ban['text'] }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Summary footer -->
                        <div class="mt-6 pt-6 border-t dark:border-dark-border-primary border-light-border-primary">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                <div class="p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Total Events</p>
                                    <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ count($streamerBan->ban_history) }}</p>
                                </div>
                                <div class="p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Total Bans</p>
                                    <p class="text-2xl font-bold text-accent-red">{{ $streamerBan->total_bans }}</p>
                                </div>
                                @if($streamerBan->last_ban)
                                <div class="p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Most Recent</p>
                                    <p class="text-sm font-bold dark:text-dark-text-bright text-light-text-bright">{{ $streamerBan->last_ban }}</p>
                                </div>
                                @endif
                                @if($streamerBan->longest_ban)
                                <div class="p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary mb-1">Longest Duration</p>
                                    <p class="text-sm font-bold dark:text-dark-text-bright text-light-text-bright">{{ $streamerBan->longest_ban }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-8 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-accent-blue/10 flex items-center justify-center">
                                <svg class="w-10 h-10 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">No Activity Timeline Available</h3>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                                Detailed ban history and activity timeline has not been scraped yet for this streamer.
                            </p>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                Visit <a href="{{ $streamerBan->streamer_bans_url }}" target="_blank" rel="noopener noreferrer" class="text-accent-blue hover:underline">StreamerBans.com</a> for complete information.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1">
                <!-- Related Streamers -->
                @if($relatedStreamers->count() > 0)
                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg mb-6">
                        <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                            Similar Streamers
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($relatedStreamers as $related)
                                <a href="{{ route('streamerbans.show', $related) }}" 
                                   class="block p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-opacity-80 transition-all">
                                    <div class="flex items-center">
                                        @if($related->avatar_url)
                                            <img src="{{ $related->avatar_url }}" 
                                                 alt="{{ $related->username }}"
                                                 class="w-10 h-10 rounded-full mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <p class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $related->username }}</p>
                                            <p class="text-xs text-accent-red">{{ $related->total_bans }} bans</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                        About Ban Tracking
                    </h3>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-4">
                        Ban data is automatically scraped and updated from StreamerBans.com. This information helps track streamer ban patterns and history.
                    </p>
                    <p class="text-xs dark:text-dark-text-secondary text-light-text-secondary">
                        Data provided for informational purposes only. Visit the official StreamerBans.com page for the most up-to-date information.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
