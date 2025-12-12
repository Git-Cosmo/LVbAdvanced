@extends('admin.layouts.app')

@section('title', 'Manage ' . $tournament->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">{{ $tournament->name }}</h1>
                <p class="dark:text-dark-text-secondary mt-2">Tournament Management</p>
            </div>
            <a href="{{ route('admin.tournaments.index') }}" class="px-4 py-2 dark:bg-dark-bg-secondary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-tertiary transition-colors">
                Back to List
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        @if($tournament->status === 'registration_closed' || $tournament->status === 'upcoming')
            <form method="POST" action="{{ route('admin.tournaments.generate-brackets', $tournament) }}">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    Generate Brackets
                </button>
            </form>
        @endif
        
        <a href="{{ route('tournaments.show', $tournament) }}" target="_blank" class="px-4 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors text-center">
            View Public Page
        </a>
        
        <a href="{{ route('tournaments.bracket', $tournament) }}" target="_blank" class="px-4 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors text-center">
            View Bracket
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Participants Management -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow">
                <div class="p-6 border-b dark:border-dark-border-primary">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright">Participants</h2>
                </div>

                <div class="p-6">
                    @if($tournament->participants->isEmpty())
                        <p class="text-center dark:text-dark-text-secondary py-8">No participants yet</p>
                    @else
                        <div class="space-y-4">
                            @foreach($tournament->participants->sortBy('registered_at') as $participant)
                                <div class="flex items-center justify-between p-4 dark:bg-dark-bg-tertiary rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                            {{ $participant->seed ?? '?' }}
                                        </div>
                                        <div>
                                            <div class="font-semibold dark:text-dark-text-bright">
                                                {{ $participant->display_name }}
                                            </div>
                                            <div class="text-sm dark:text-dark-text-secondary">
                                                Registered {{ $participant->registered_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $participant->status === 'checked_in' ? 'bg-green-600 text-white' : '' }}
                                            {{ $participant->status === 'approved' ? 'bg-blue-600 text-white' : '' }}
                                            {{ $participant->status === 'pending' ? 'bg-yellow-600 text-white' : '' }}
                                            {{ $participant->status === 'rejected' ? 'bg-red-600 text-white' : '' }}">
                                            {{ ucfirst($participant->status) }}
                                        </span>

                                        @if($participant->status === 'pending')
                                            <div class="flex space-x-2">
                                                <form method="POST" action="{{ route('admin.tournaments.participants.approve', $participant) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.tournaments.participants.reject', $participant) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Matches Management -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow">
                <div class="p-6 border-b dark:border-dark-border-primary">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright">Matches</h2>
                </div>

                <div class="p-6">
                    @if($tournament->matches->isEmpty())
                        <p class="text-center dark:text-dark-text-secondary py-8">No matches generated yet</p>
                    @else
                        <div class="space-y-6">
                            @foreach($tournament->matches->groupBy('round') as $round => $matches)
                                <div>
                                    <h3 class="font-bold dark:text-dark-text-bright mb-3">
                                        Round {{ $round }}
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach($matches as $match)
                                            <div class="p-4 dark:bg-dark-bg-tertiary rounded-lg">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-sm dark:text-dark-text-muted">Match #{{ $match->match_number }}</span>
                                                    <span class="px-2 py-1 rounded text-xs font-medium
                                                        {{ $match->status === 'completed' ? 'bg-green-600 text-white' : '' }}
                                                        {{ $match->status === 'in_progress' ? 'bg-blue-600 text-white' : '' }}
                                                        {{ $match->status === 'ready' ? 'bg-accent-blue text-white' : '' }}
                                                        {{ $match->status === 'pending' ? 'bg-gray-600 text-white' : '' }}">
                                                        {{ ucfirst($match->status) }}
                                                    </span>
                                                </div>

                                                <div class="space-y-2 mb-3">
                                                    <div class="flex items-center justify-between p-2 rounded dark:bg-dark-bg-elevated">
                                                        <span class="dark:text-dark-text-primary">{{ $match->participant1?->display_name ?? 'TBD' }}</span>
                                                        <span class="font-bold dark:text-dark-text-bright">{{ $match->participant1_score ?? '-' }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between p-2 rounded dark:bg-dark-bg-elevated">
                                                        <span class="dark:text-dark-text-primary">{{ $match->participant2?->display_name ?? 'TBD' }}</span>
                                                        <span class="font-bold dark:text-dark-text-bright">{{ $match->participant2_score ?? '-' }}</span>
                                                    </div>
                                                </div>

                                                @if($match->status !== 'completed' && $match->isReady())
                                                    <form method="POST" action="{{ route('admin.tournaments.matches.result', $match) }}" class="grid grid-cols-3 gap-2">
                                                        @csrf
                                                        <input type="number" name="participant1_score" placeholder="Score" min="0" required class="px-3 py-2 dark:bg-dark-bg-elevated dark:text-dark-text-primary rounded text-sm">
                                                        <input type="number" name="participant2_score" placeholder="Score" min="0" required class="px-3 py-2 dark:bg-dark-bg-elevated dark:text-dark-text-primary rounded text-sm">
                                                        <button type="submit" class="px-3 py-2 bg-accent-blue text-white text-sm rounded hover:bg-blue-600 transition-colors">
                                                            Submit
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Tournament Info -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Tournament Info</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="dark:text-dark-text-secondary">Status</div>
                        <div class="font-semibold dark:text-dark-text-bright capitalize">{{ str_replace('_', ' ', $tournament->status) }}</div>
                    </div>
                    <div>
                        <div class="dark:text-dark-text-secondary">Format</div>
                        <div class="font-semibold dark:text-dark-text-bright capitalize">{{ str_replace('_', ' ', $tournament->format) }}</div>
                    </div>
                    <div>
                        <div class="dark:text-dark-text-secondary">Type</div>
                        <div class="font-semibold dark:text-dark-text-bright capitalize">{{ $tournament->type }}</div>
                    </div>
                    <div>
                        <div class="dark:text-dark-text-secondary">Participants</div>
                        <div class="font-semibold dark:text-dark-text-bright">{{ $tournament->current_participants }}/{{ $tournament->max_participants }}</div>
                    </div>
                    @if($tournament->prize_pool)
                        <div>
                            <div class="dark:text-dark-text-secondary">Prize Pool</div>
                            <div class="font-semibold text-accent-green">${{ number_format($tournament->prize_pool, 0) }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Statistics</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Total Matches:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->matches->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Completed:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->matches->where('status', 'completed')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Pending:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->matches->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Checked In:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->participants->where('status', 'checked_in')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Staff:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->staff->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Staff -->
            @if($tournament->staff->isNotEmpty())
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                    <h3 class="font-bold dark:text-dark-text-bright mb-4">Staff</h3>
                    <div class="space-y-2">
                        @foreach($tournament->staff as $staff)
                            <div class="flex items-center justify-between">
                                <span class="text-sm dark:text-dark-text-primary">{{ $staff->user->name }}</span>
                                <span class="text-xs px-2 py-1 dark:bg-dark-bg-tertiary rounded dark:text-dark-text-secondary capitalize">
                                    {{ $staff->role }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
