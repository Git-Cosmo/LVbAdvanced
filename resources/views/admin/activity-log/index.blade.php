@extends('admin.layouts.app')

@section('header', 'Activity Log')

@section('content')
<div class="max-w-7xl">
    <h1 class="text-2xl font-bold dark:text-dark-text-bright mb-6">Activity Log</h1>

    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" 
                class="dark:bg-dark-bg-tertiary dark:text-dark-text-primary border dark:border-dark-border-primary rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-blue">
            <select name="log_name" class="dark:bg-dark-bg-tertiary dark:text-dark-text-primary border dark:border-dark-border-primary rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-blue">
                <option value="">All Logs</option>
                @foreach($logNames as $logName)
                    <option value="{{ $logName }}" {{ request('log_name') == $logName ? 'selected' : '' }}>{{ ucfirst($logName) }}</option>
                @endforeach
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                class="dark:bg-dark-bg-tertiary dark:text-dark-text-primary border dark:border-dark-border-primary rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-blue">
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
                Filter
            </button>
        </form>
    </div>

    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden">
        <table class="w-full">
            <thead class="dark:bg-dark-bg-tertiary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Causer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-dark-border-primary">
                @forelse($activities as $activity)
                    <tr class="hover:dark:bg-dark-bg-elevated transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($activity->log_name === 'user') bg-blue-500/20 text-blue-400
                                @elseif($activity->log_name === 'tournament') bg-purple-500/20 text-purple-400
                                @elseif($activity->log_name === 'forum') bg-green-500/20 text-green-400
                                @elseif($activity->log_name === 'admin') bg-red-500/20 text-red-400
                                @else bg-gray-500/20 text-gray-400
                                @endif">
                                {{ ucfirst($activity->log_name) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 dark:text-dark-text-primary">{{ $activity->description }}</td>
                        <td class="px-6 py-4 dark:text-dark-text-secondary">{{ $activity->causer?->name ?? 'System' }}</td>
                        <td class="px-6 py-4 dark:text-dark-text-tertiary text-sm">{{ $activity->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center dark:text-dark-text-tertiary">
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $activities->links() }}</div>
</div>
@endsection
