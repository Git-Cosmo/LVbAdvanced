@extends('admin.layouts.app')

@section('header', 'Backup Management')

@section('content')
<div class="max-w-7xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold dark:text-dark-text-bright">Backup Management</h1>
        <form method="POST" action="{{ route('admin.backups.create') }}">
            @csrf
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
                Create Backup
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="dark:text-dark-text-secondary text-sm">Total Backups</div>
            <div class="dark:text-dark-text-bright text-2xl font-bold mt-2">{{ $stats['total_backups'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="dark:text-dark-text-secondary text-sm">Total Size</div>
            <div class="dark:text-dark-text-bright text-2xl font-bold mt-2">{{ number_format($stats['total_size'] / 1024 / 1024, 2) }} MB</div>
        </div>
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="dark:text-dark-text-secondary text-sm">Latest Backup</div>
            <div class="dark:text-dark-text-primary text-sm mt-2">{{ $stats['latest_backup'] ? $stats['latest_backup']['date']->diffForHumans() : 'None' }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="dark:text-dark-text-secondary text-sm">Health Status</div>
            <div class="text-xl font-bold mt-2 {{ $stats['health_status'] == 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                {{ ucfirst($stats['health_status']) }}
            </div>
        </div>
    </div>

    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden">
        <table class="w-full">
            <thead class="dark:bg-dark-bg-tertiary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Disk</th>
                    <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-dark-border-primary">
                @forelse($backups as $backup)
                    <tr class="hover:dark:bg-dark-bg-elevated transition-colors">
                        <td class="px-6 py-4 dark:text-dark-text-primary">{{ $backup['date']->format('Y-m-d H:i:s') }}</td>
                        <td class="px-6 py-4 dark:text-dark-text-secondary">{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                        <td class="px-6 py-4 dark:text-dark-text-secondary">{{ $backup['disk'] }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.backups.download', [$backup['disk'], basename($backup['path'])]) }}" class="text-accent-blue hover:text-accent-blue/80 mr-4">Download</a>
                            <form method="POST" action="{{ route('admin.backups.destroy', [$backup['disk'], basename($backup['path'])]) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this backup?')" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center dark:text-dark-text-tertiary">
                            No backups found. Create your first backup to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
