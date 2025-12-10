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
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs uppercase text-gray-500 font-semibold">Stores</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $storesCount }}</p>
            <p class="text-sm text-gray-500">CheapShark stores tracked</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs uppercase text-gray-500 font-semibold">Games</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $gamesCount }}</p>
            <p class="text-sm text-gray-500">Games with deals</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs uppercase text-gray-500 font-semibold">Deals</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $dealsCount }}</p>
            <p class="text-sm text-gray-500">Active offers stored</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Manual Sync</h2>
                <p class="text-sm text-gray-500">Pull latest stores, games, and deals from CheapShark</p>
            </div>
            <form method="POST" action="{{ route('admin.deals.sync') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 shadow">
                    Run Sync Now
                </button>
            </form>
        </div>
        @if($lastLog)
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-4 gap-3 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Last Status</p>
                    <p class="font-semibold">{{ ucfirst($lastLog->status) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">Completed</p>
                    <p class="font-semibold">{{ optional($lastLog->finished_at)->diffForHumans() ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">Summary</p>
                    <p class="font-semibold">{{ $lastLog->message ?? 'No message' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">Run Type</p>
                    <p class="font-semibold">{{ ucfirst($lastLog->run_type) }}</p>
                </div>
            </div>
        @else
            <div class="px-6 py-4 text-sm text-gray-600">No sync has been run yet.</div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Sync Logs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Started</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Counts</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Message</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ optional($log->started_at)->toDayDateTimeString() ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($log->status === 'completed') bg-green-100 text-green-800
                                    @elseif($log->status === 'running') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $log->stores_synced }} stores • {{ $log->games_synced }} games • {{ $log->deals_synced }} deals
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $log->message ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-600">No sync history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
