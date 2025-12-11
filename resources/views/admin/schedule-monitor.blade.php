@extends('admin.layouts.app')

@section('title', 'Schedule Monitor')
@section('header', 'Schedule Monitor')

@section('content')
<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 border dark:border-dark-border-primary border-light-border-primary">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">Monitored Scheduled Jobs</h2>
            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Live view of cron health powered by Spatie Schedule Monitor.</p>
        </div>
        <a href="{{ route('status') }}" target="_blank" class="text-sm px-3 py-2 rounded-lg bg-accent-blue text-white hover:bg-accent-purple transition">View Status Page</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-border-primary">
            <thead>
                <tr class="text-left text-xs font-semibold uppercase dark:text-dark-text-secondary text-light-text-secondary">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Cron</th>
                    <th class="px-4 py-3">Last Started</th>
                    <th class="px-4 py-3">Last Finished</th>
                    <th class="px-4 py-3">Last Failed</th>
                    <th class="px-4 py-3">Grace (min)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-dark-border-primary">
                @forelse($tasks as $task)
                    @php
                        $isFailing = !is_null($task->last_failed_at);
                        $isLate = $task->last_pinged_at && $task->last_pinged_at->lt(now()->subMinutes($task->grace_time_in_minutes));
                    @endphp
                    <tr class="dark:text-dark-text-primary text-light-text-primary">
                        <td class="px-4 py-3 font-medium">{{ $task->name }}</td>
                        <td class="px-4 py-3">{{ $task->cron_expression }}</td>
                        <td class="px-4 py-3 text-sm">{{ optional($task->last_started_at)->diffForHumans() ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">{{ optional($task->last_finished_at)->diffForHumans() ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($isFailing)
                                <span class="px-2 py-1 text-xs rounded-full bg-red-500/10 text-red-500 border border-red-500/20">Failed {{ $task->last_failed_at->diffForHumans() }}</span>
                            @elseif($isLate)
                                <span class="px-2 py-1 text-xs rounded-full bg-amber-500/10 text-amber-500 border border-amber-500/20">Late</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-green-500/10 text-green-500 border border-green-500/20">Healthy</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $task->grace_time_in_minutes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center dark:text-dark-text-secondary text-light-text-secondary">No scheduled jobs have been synced yet. Run <code class="text-xs">php artisan schedule-monitor:sync</code> to register them.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
