@extends('layouts.app')

@section('title', 'Gaming Events')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">Gaming Events</h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">Stay updated with the latest gaming releases, tournaments, expos, and updates</p>
    </div>

    <!-- Featured Events -->
    @if($featuredEvents->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Featured Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredEvents as $featuredEvent)
            <a href="{{ route('events.show', $featuredEvent) }}" class="block dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                @if($featuredEvent->image)
                <img src="{{ $featuredEvent->image }}" alt="{{ $featuredEvent->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-accent-blue/20 text-accent-blue">
                            {{ ucfirst($featuredEvent->event_type) }}
                        </span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400">
                            Featured
                        </span>
                    </div>
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2">{{ $featuredEvent->title }}</h3>
                    @if($featuredEvent->start_date)
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $featuredEvent->start_date->format('M d, Y') }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 flex flex-wrap gap-4">
        <div>
            <label class="block text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary mb-2">Status</label>
            <div class="flex gap-2">
                <a href="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'upcoming'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status', 'upcoming') === 'upcoming' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Upcoming
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'ongoing'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'ongoing' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Ongoing
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'past'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'past' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Past
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'all' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    All
                </a>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary mb-2">Type</label>
            <div class="flex gap-2">
                <a href="{{ route('events.index', array_merge(request()->except('type'), ['type' => 'all'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('type', 'all') === 'all' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    All
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('type'), ['type' => 'release'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('type') === 'release' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Releases
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('type'), ['type' => 'tournament'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('type') === 'tournament' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Tournaments
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('type'), ['type' => 'expo'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('type') === 'expo' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Expos
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('type'), ['type' => 'update'])) }}" 
                   class="px-4 py-2 rounded-lg {{ request('type') === 'update' ? 'bg-primary-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                    Updates
                </a>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    @if($events->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <a href="{{ route('events.show', $event) }}" class="block dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
            @if($event->image)
            <img src="{{ $event->image }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif
            <div class="p-4">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $event->event_type === 'release' ? 'bg-green-500/20 text-green-400' : '' }}
                        {{ $event->event_type === 'tournament' ? 'bg-purple-500/20 text-purple-400' : '' }}
                        {{ $event->event_type === 'expo' ? 'bg-blue-500/20 text-blue-400' : '' }}
                        {{ $event->event_type === 'update' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                        {{ $event->event_type === 'general' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                        {{ ucfirst($event->event_type) }}
                    </span>
                    @if($event->status)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $event->status === 'upcoming' ? 'bg-blue-500/20 text-blue-400' : '' }}
                        {{ $event->status === 'ongoing' ? 'bg-green-500/20 text-green-400' : '' }}
                        {{ $event->status === 'past' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    @endif
                    @if($event->is_virtual)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500/20 text-purple-400">
                        Virtual
                    </span>
                    @endif
                </div>
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-2 line-clamp-2">{{ $event->title }}</h3>
                @if($event->description)
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary mb-3 line-clamp-2">{{ $event->description }}</p>
                @endif
                @if($event->start_date)
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $event->start_date->format('M d, Y') }}
                    @if($event->end_date && !$event->start_date->isSameDay($event->end_date))
                        - {{ $event->end_date->format('M d, Y') }}
                    @endif
                </p>
                @endif
                @if($event->source)
                <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-2">
                    Source: {{ $event->source }}
                </p>
                @endif
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $events->links() }}
    </div>
    @else
    <div class="text-center py-12 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg">
        <svg class="mx-auto w-16 h-16 dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">No events found matching your filters.</p>
    </div>
    @endif
</div>
@endsection
