@extends('admin.layouts.app')

@section('title', 'Game Deals')
@section('header', 'CheapShark Deals & Sync')

@section('content')
<div class="space-y-6">
    @if(session('status'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Stores</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $storesCount }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">CheapShark stores tracked</p>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Games</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $gamesCount }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Games with deals</p>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-5">
            <p class="text-xs uppercase dark:text-dark-text-secondary text-light-text-secondary font-semibold">Deals</p>
            <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mt-2">{{ $dealsCount }}</p>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Active offers stored</p>
        </div>
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow">
        <div class="px-6 py-4 border-b dark:border-dark-border-primary border-light-border-primary flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">Manual Sync</h2>
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Pull latest stores, games, and deals from CheapShark</p>
            </div>
            <form method="POST" action="{{ route('admin.deals.sync') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 shadow">
                    Run Sync Now
                </button>
            </form>
        </div>
        @if($lastLog)
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-4 gap-3 text-sm dark:text-dark-text-primary text-light-text-primary">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-xs uppercase">Last Status</p>
                    <p class="font-semibold">{{ ucfirst($lastLog->status) }}</p>
                </div>
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-xs uppercase">Completed</p>
                    <p class="font-semibold">{{ optional($lastLog->finished_at)->diffForHumans() ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-xs uppercase">Summary</p>
                    <p class="font-semibold">{{ $lastLog->message ?? 'No message' }}</p>
                </div>
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-xs uppercase">Run Type</p>
                    <p class="font-semibold">{{ ucfirst($lastLog->run_type) }}</p>
                </div>
            </div>
        @else
            <div class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">No sync has been run yet.</div>
        @endif
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow">
        <div class="px-6 py-4 border-b dark:border-dark-border-primary border-light-border-primary">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">Recent Sync Logs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Started</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Counts</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Message</th>
                    </tr>
                </thead>
                <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary text-sm">
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-4 py-3 dark:text-dark-text-primary text-light-text-primary">{{ optional($log->started_at)->toDayDateTimeString() ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($log->status === 'completed') bg-green-100 text-green-800
                                    @elseif($log->status === 'running') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-primary text-light-text-primary">
                                {{ $log->stores_synced }} stores • {{ $log->games_synced }} games • {{ $log->deals_synced }} deals
                            </td>
                            <td class="px-4 py-3 dark:text-dark-text-secondary text-light-text-secondary">{{ $log->message ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">No sync history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
