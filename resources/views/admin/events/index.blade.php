@extends('admin.layouts.app')

@section('title', 'Events Management')
@section('header', 'Events Management')

@section('content')
<div class="space-y-6">
    @if(session('status') || session('success'))
        <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg">
            {{ session('status') ?? session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Total Events</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $stats['total'] }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">All events in database</p>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Upcoming</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $stats['upcoming'] }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Future events</p>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Ongoing</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $stats['ongoing'] }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Currently active</p>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Featured</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $stats['featured'] }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Featured events</p>
        </div>
    </div>

    <!-- Import Section -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow">
        <div class="px-6 py-4 border-b dark:border-dark-border-primary border-light-border-primary flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">Import Events</h2>
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Scrape events from GameSpot and IGN RSS feeds</p>
            </div>
            <form method="POST" action="{{ route('admin.events.import') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 shadow">
                    Import Events Now
                </button>
            </form>
        </div>
    </div>

    <!-- Events Table -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow">
        <div class="px-6 py-4 border-b dark:border-dark-border-primary border-light-border-primary">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">All Events</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
                <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Start Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Source</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Views</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary text-sm">
                    @forelse($events as $event)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if($event->image)
                                        <img src="{{ $event->image }}" alt="" class="w-10 h-10 rounded object-cover mr-3">
                                    @endif
                                    <div>
                                        <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ Str::limit($event->title, 50) }}</div>
                                        <div class="flex gap-1 mt-1">
                                            @if($event->is_featured)
                                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-yellow-500/20 text-yellow-400">
                                                    Featured
                                                </span>
                                            @endif
                                            @if(!$event->is_published)
                                                <span class="px-2 py-0.5 rounded text-xs font-semibold dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-secondary text-light-text-secondary">
                                                    Unpublished
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-primary text-light-text-primary">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $event->event_type === 'release' ? 'bg-green-500/20 text-green-400' : '' }}
                                    {{ $event->event_type === 'tournament' ? 'bg-purple-500/20 text-purple-400' : '' }}
                                    {{ $event->event_type === 'expo' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                    {{ $event->event_type === 'update' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                    {{ $event->event_type === 'general' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                    {{ ucfirst($event->event_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-primary text-light-text-primary">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $event->status === 'upcoming' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                    {{ $event->status === 'ongoing' ? 'bg-green-500/20 text-green-400' : '' }}
                                    {{ $event->status === 'past' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-primary text-light-text-primary">
                                {{ $event->start_date ? $event->start_date->format('M d, Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $event->source ?? '-' }}
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $event->views_count }}
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('events.show', $event) }}" target="_blank" class="text-blue-400 hover:text-blue-300">View</a>
                                
                                <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-400 hover:text-yellow-300">
                                        {{ $event->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.events.toggle-published', $event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-indigo-400 hover:text-indigo-300">
                                        {{ $event->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">No events found. Click "Import Events Now" to fetch events.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection
