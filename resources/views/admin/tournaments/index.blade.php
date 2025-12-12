@extends('admin.layouts.app')

@section('title', 'Manage Tournaments')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright">Tournament Management</h1>
        <p class="dark:text-dark-text-secondary mt-2">Manage all tournaments on the platform</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-1">Total Tournaments</div>
                    <div class="text-2xl font-bold dark:text-dark-text-bright">{{ $tournaments->total() }}</div>
                </div>
                <div class="w-12 h-12 bg-accent-blue/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-1">Active</div>
                    <div class="text-2xl font-bold text-green-500">{{ $tournaments->where('status', 'in_progress')->count() }}</div>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-1">Upcoming</div>
                    <div class="text-2xl font-bold text-blue-500">{{ $tournaments->whereIn('status', ['upcoming', 'registration_open'])->count() }}</div>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-1">Completed</div>
                    <div class="text-2xl font-bold dark:text-dark-text-bright">{{ $tournaments->where('status', 'completed')->count() }}</div>
                </div>
                <div class="w-12 h-12 bg-gray-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tournaments Table -->
    <div class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b dark:border-dark-border-primary">
            <h2 class="text-xl font-bold dark:text-dark-text-bright">All Tournaments</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="dark:bg-dark-bg-tertiary">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Tournament</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Format</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Participants</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Starts</th>
                        <th class="px-6 py-4 text-left text-sm font-medium dark:text-dark-text-primary">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-dark-border-primary">
                    @forelse($tournaments as $tournament)
                        <tr class="hover:bg-dark-bg-tertiary/50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-semibold dark:text-dark-text-bright">{{ $tournament->name }}</div>
                                    @if($tournament->game)
                                        <div class="text-sm text-accent-blue">{{ $tournament->game }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $tournament->status === 'registration_open' ? 'bg-green-600 text-white' : '' }}
                                    {{ $tournament->status === 'in_progress' ? 'bg-blue-600 text-white' : '' }}
                                    {{ $tournament->status === 'completed' ? 'bg-gray-600 text-white' : '' }}
                                    {{ $tournament->status === 'upcoming' ? 'bg-yellow-600 text-white' : '' }}
                                    {{ $tournament->status === 'cancelled' ? 'bg-red-600 text-white' : '' }}">
                                    {{ str_replace('_', ' ', ucfirst($tournament->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm dark:text-dark-text-secondary capitalize">
                                    {{ str_replace('_', ' ', $tournament->format) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm dark:text-dark-text-primary">
                                    <span class="font-semibold">{{ $tournament->current_participants }}</span> / {{ $tournament->max_participants }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm dark:text-dark-text-secondary">
                                    {{ $tournament->starts_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.tournaments.show', $tournament) }}" class="px-3 py-1 bg-accent-blue text-white text-sm rounded hover:bg-blue-600 transition-colors">
                                        Manage
                                    </a>
                                    <a href="{{ route('tournaments.show', $tournament) }}" target="_blank" class="px-3 py-1 dark:bg-dark-bg-tertiary dark:text-dark-text-primary text-sm rounded hover:bg-dark-bg-elevated transition-colors">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center dark:text-dark-text-secondary">
                                No tournaments found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t dark:border-dark-border-primary">
            {{ $tournaments->links() }}
        </div>
    </div>
</div>
@endsection
