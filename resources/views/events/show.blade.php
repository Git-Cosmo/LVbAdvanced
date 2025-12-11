@extends('layouts.app')

@section('title', $event->name . ' - Gaming Events')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('events.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Events
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Event Header -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden mb-8">
                    @if($event->thumbnail)
                    <img src="{{ $event->thumbnail }}" alt="{{ $event->name }}" class="w-full h-96 object-cover">
                    @else
                    <div class="w-full h-96 bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $event->event_type === 'release' ? 'bg-green-500/20 text-green-400' : '' }}
                                {{ $event->event_type === 'tournament' ? 'bg-purple-500/20 text-purple-400' : '' }}
                                {{ $event->event_type === 'expo' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                {{ $event->event_type === 'update' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                {{ $event->event_type === 'general' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                {{ ucfirst($event->event_type) }}
                            </span>
                            @if($event->status)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $event->status === 'upcoming' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                {{ $event->status === 'ongoing' ? 'bg-green-500/20 text-green-400' : '' }}
                                {{ $event->status === 'past' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                            @endif
                            @if($event->is_virtual)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-500/20 text-purple-400">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                Virtual Event
                            </span>
                            @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-500/20 text-green-400">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                In-Person Event
                            </span>
                            @endif
                            @if($event->is_featured)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-500/20 text-yellow-400">
                                Featured
                            </span>
                            @endif
                        </div>

                        <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">{{ $event->name }}</h1>

                        @if($event->date_human_readable)
                        <p class="text-lg dark:text-dark-text-secondary text-light-text-secondary mb-4">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $event->date_human_readable }}
                        </p>
                        @endif

                        @if($event->description)
                        <p class="dark:text-dark-text-primary text-light-text-primary mb-6">{{ $event->description }}</p>
                        @endif

                        @if($event->link)
                        <a href="{{ $event->link }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Event Details
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Venue Information -->
                @if($event->venues->isNotEmpty())
                @foreach($event->venues as $venue)
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Venue Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $venue->name }}</h3>
                            @if($venue->rating)
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-yellow-400">★</span>
                                <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $venue->rating }} ({{ number_format($venue->review_count ?? 0) }} reviews)</span>
                            </div>
                            @endif
                            @if($venue->subtype)
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary mt-1">{{ $venue->subtype }}</p>
                            @endif
                        </div>

                        @if($venue->full_address)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-1 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="dark:text-dark-text-primary text-light-text-primary">{{ $venue->full_address }}</p>
                                @if($venue->city && $venue->state && $venue->country)
                                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">{{ $venue->city }}, {{ $venue->state }}, {{ $venue->country }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($venue->phone_number)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $venue->phone_number }}" class="dark:text-primary-400 text-primary-600 hover:underline">{{ $venue->phone_number }}</a>
                        </div>
                        @endif

                        @if($venue->website)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="{{ $venue->website }}" target="_blank" class="dark:text-primary-400 text-primary-600 hover:underline">Visit Website</a>
                        </div>
                        @endif

                        @if($venue->latitude && $venue->longitude)
                        <div class="mt-4">
                            <a href="https://www.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                View on Google Maps
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Ticket Links -->
                @if($event->ticketLinks->isNotEmpty())
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Get Tickets</h3>
                    <div class="space-y-3">
                        @foreach($event->ticketLinks as $ticketLink)
                        <a href="{{ $ticketLink->link }}" target="_blank" class="flex items-center justify-between p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-primary-600/10 transition-colors group">
                            <div class="flex items-center gap-3">
                                @if($ticketLink->fav_icon)
                                <img src="{{ $ticketLink->fav_icon }}" alt="{{ $ticketLink->source }}" class="w-6 h-6 rounded">
                                @endif
                                <span class="dark:text-dark-text-primary text-light-text-primary group-hover:text-primary-400">{{ $ticketLink->source }}</span>
                            </div>
                            <svg class="w-5 h-5 dark:text-dark-text-tertiary text-light-text-tertiary group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Info Links -->
                @if($event->infoLinks->isNotEmpty())
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">More Information</h3>
                    <div class="space-y-3">
                        @foreach($event->infoLinks as $infoLink)
                        <a href="{{ $infoLink->link }}" target="_blank" class="flex items-center justify-between p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-primary-600/10 transition-colors group">
                            <span class="dark:text-dark-text-primary text-light-text-primary group-hover:text-primary-400">{{ $infoLink->source }}</span>
                            <svg class="w-5 h-5 dark:text-dark-text-tertiary text-light-text-tertiary group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Publisher Info -->
                @if($event->publisher)
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Published By</h3>
                    <div class="flex items-center gap-3">
                        @if($event->publisher_favicon)
                        <img src="{{ $event->publisher_favicon }}" alt="{{ $event->publisher }}" class="w-8 h-8 rounded">
                        @endif
                        <div>
                            <p class="dark:text-dark-text-primary text-light-text-primary font-semibold">{{ $event->publisher }}</p>
                            @if($event->publisher_domain)
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">{{ $event->publisher_domain }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Event Dates -->
                @if($event->start_time || $event->end_time)
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Date & Time</h3>
                    <div class="space-y-3">
                        @if($event->start_time)
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Starts</p>
                            <p class="dark:text-dark-text-primary text-light-text-primary">{{ $event->start_time->format('F d, Y @ g:i A') }}</p>
                            @if($event->start_time_utc)
                            <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">UTC: {{ $event->start_time_utc->format('F d, Y @ H:i') }}</p>
                            @endif
                        </div>
                        @endif

                        @if($event->end_time)
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Ends</p>
                            <p class="dark:text-dark-text-primary text-light-text-primary">{{ $event->end_time->format('F d, Y @ g:i A') }}</p>
                            @if($event->end_time_utc)
                            <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">UTC: {{ $event->end_time_utc->format('F d, Y @ H:i') }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Events -->
        @if($relatedEvents && $relatedEvents->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">Related Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedEvents as $related)
                <a href="{{ route('events.show', $related) }}" class="block dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($related->thumbnail)
                    <img src="{{ $related->thumbnail }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2 line-clamp-2">{{ $related->name }}</h3>
                        @if($related->date_human_readable)
                        <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $related->date_human_readable }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
