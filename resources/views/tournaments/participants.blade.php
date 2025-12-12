@extends('layouts.app')

@section('title', $tournament->name . ' - Participants')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">{{ $tournament->name }}</h1>
                <p class="dark:text-dark-text-secondary mt-2">Participants ({{ $participants->total() }})</p>
            </div>
            <a href="{{ route('tournaments.show', $tournament) }}" class="px-4 py-2 dark:bg-dark-bg-secondary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-tertiary transition-colors">
                Back to Tournament
            </a>
        </div>
    </div>

    @if($participants->isEmpty())
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <p class="dark:text-dark-text-secondary">No participants yet.</p>
        </div>
    @else
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="dark:bg-dark-bg-tertiary">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Seed</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-dark-border-primary">
                    @foreach($participants as $participant)
                        <tr class="hover:bg-dark-bg-tertiary/50">
                            <td class="px-6 py-4">
                                <span class="font-bold dark:text-dark-text-bright">
                                    {{ $participant->seed ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                        @if($tournament->type === 'solo' && $participant->user)
                                            {{ substr($participant->user->name, 0, 1) }}
                                        @else
                                            {{ substr($participant->display_name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold dark:text-dark-text-bright">
                                            {{ $participant->display_name }}
                                        </div>
                                        @if($tournament->type === 'team' && $participant->clan)
                                            <div class="text-sm dark:text-dark-text-secondary">
                                                {{ $participant->clan->name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $participant->status === 'checked_in' ? 'bg-green-600 text-white' : '' }}
                                    {{ $participant->status === 'approved' ? 'bg-blue-600 text-white' : '' }}
                                    {{ $participant->status === 'pending' ? 'bg-yellow-600 text-white' : '' }}
                                    {{ $participant->status === 'waitlist' ? 'bg-orange-600 text-white' : '' }}
                                    {{ $participant->status === 'rejected' ? 'bg-red-600 text-white' : '' }}
                                    {{ $participant->status === 'disqualified' ? 'bg-gray-600 text-white' : '' }}">
                                    {{ ucfirst($participant->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm dark:text-dark-text-secondary">
                                    {{ $participant->registered_at->format('M d, Y') }}
                                </div>
                                <div class="text-xs dark:text-dark-text-muted">
                                    {{ $participant->registered_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $participants->links() }}
        </div>
    @endif
</div>
@endsection
