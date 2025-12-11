@extends('layouts.app')

@section('content')
<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-2xl shadow-lg p-8 border dark:border-dark-border-primary border-light-border-primary">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">Status Overview</h1>
            <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Live service health with automatic refresh every 5 minutes.</p>
        </div>
        <span class="px-3 py-1 text-xs rounded-full dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-secondary text-light-text-secondary">
            Updated {{ now()->format('H:i:s') }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($checks as $check)
            @php
                $statusClasses = [
                    'ok' => 'bg-green-500/10 text-green-500 border border-green-500/20',
                    'warning' => 'bg-amber-500/10 text-amber-500 border border-amber-500/20',
                    'error' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                ];
            @endphp
            <div class="p-4 rounded-xl dark:bg-dark-bg-tertiary bg-light-bg-tertiary border dark:border-dark-border-primary border-light-border-primary">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $check['name'] }}</h3>
                    <span class="text-xs px-2 py-1 rounded-full {{ $statusClasses[$check['status']] ?? $statusClasses['warning'] }}">
                        {{ strtoupper($check['status']) }}
                    </span>
                </div>
                <p class="mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary break-words">{{ $check['details'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 p-4 rounded-xl dark:bg-dark-bg-tertiary bg-light-bg-tertiary border dark:border-dark-border-primary border-light-border-primary">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright">Scheduled Jobs</h3>
                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Monitoring via Spatie Schedule Monitor</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-sm">
                    <span class="font-semibold dark:text-dark-text-accent text-light-text-accent">{{ $scheduleSummary['monitored'] }}</span>
                    <span class="dark:text-dark-text-secondary text-light-text-secondary">tracked</span>
                </div>
                <div class="text-sm">
                    <span class="font-semibold {{ $scheduleSummary['failing'] > 0 ? 'text-red-500' : 'text-green-500' }}">{{ $scheduleSummary['failing'] }}</span>
                    <span class="dark:text-dark-text-secondary text-light-text-secondary">failing</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(() => window.location.reload(), 5 * 60 * 1000);
</script>
@endsection
