@extends('layouts.app')

@section('title', $event->title . ' - Gaming Events')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('events.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Events
        </a>

        <!-- Event Header -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden mb-8">
            @if($event->image)
            <img src="{{ $event->image }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
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
                    @if($event->is_featured)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-500/20 text-yellow-400">
                        Featured
                    </span>
                    @endif
                </div>

                <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">{{ $event->title }}</h1>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @if($event->start_date)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Start Date</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->start_date->format('F d, Y @ g:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->end_date)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">End Date</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->end_date->format('F d, Y @ g:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->location)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Location</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->location }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->platform)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Platform</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->platform }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->game_name)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Game</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->game_name }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->venue)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Venue</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->venue }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->city && $event->country)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">City / Country</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->city }}, {{ $event->country }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->organizer)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 dark:text-dark-text-secondary text-light-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Organizer</p>
                            <p class="dark:text-dark-text-bright text-light-text-bright">{{ $event->organizer }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                @if($event->description)
                <div class="mb-6">
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-3">About</h2>
                    <p class="dark:text-dark-text-primary text-light-text-primary">{{ $event->description }}</p>
                </div>
                @endif

                <!-- Content -->
                @if($event->content)
                <div class="prose dark:prose-invert max-w-none mb-6">
                    {{-- Content is from trusted sources and may contain HTML formatting --}}
                    {{-- Using strip_tags to prevent XSS while preserving basic formatting --}}
                    {!! strip_tags($event->content, '<p><br><a><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6>') !!}
                </div>
                @endif

                <!-- Ticket Information -->
                @if($event->ticket_info || $event->ticket_url)
                <div class="mb-6 p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg border dark:border-dark-border-primary border-light-border-primary">
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Ticket Information
                    </h3>
                    @if($event->ticket_info)
                    <p class="dark:text-dark-text-primary text-light-text-primary mb-3">{{ $event->ticket_info }}</p>
                    @endif
                    @if($event->ticket_url)
                    <a href="{{ $event->ticket_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Get Tickets
                    </a>
                    @endif
                </div>
                @endif

                <!-- Source Link -->
                @if($event->source_url)
                <div class="mb-4">
                    <a href="{{ $event->source_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-primary-600 hover:text-primary-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Visit Official Website
                    </a>
                </div>
                @endif

                <!-- Metadata -->
                <div class="flex items-center gap-4 text-sm dark:text-dark-text-tertiary text-light-text-tertiary pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
                    @if($event->source)
                    <span>Source: {{ $event->source }}</span>
                    @endif
                    <span>{{ $event->views_count }} views</span>
                    <span>Posted {{ $event->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Related Events -->
        @if($relatedEvents->isNotEmpty())
        <div>
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Related Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedEvents as $relatedEvent)
                <a href="{{ route('events.show', $relatedEvent) }}" class="block dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($relatedEvent->image)
                    <img src="{{ $relatedEvent->image }}" alt="{{ $relatedEvent->title }}" class="w-full h-32 object-cover">
                    @else
                    <div class="w-full h-32 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-accent-blue/20 text-accent-blue mb-2 inline-block">
                            {{ ucfirst($relatedEvent->event_type) }}
                        </span>
                        <h3 class="font-bold dark:text-dark-text-bright text-light-text-bright line-clamp-2">{{ $relatedEvent->title }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
