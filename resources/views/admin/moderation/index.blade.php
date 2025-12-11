@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold dark:text-white">
            🛡️ Moderation Queue
        </h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.moderation.warnings') }}" 
               class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                Warnings
            </a>
            <a href="{{ route('admin.moderation.bans') }}" 
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Bans
            </a>
        </div>
    </div>
    
    @if($pendingCount > 0)
        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-6">
            <strong>{{ $pendingCount }}</strong> pending {{ Str::plural('report', $pendingCount) }} require attention
        </div>
    @endif
    
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary dark:divide-gray-700">
            <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Content
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Reporter
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Reason
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary dark:bg-gray-800 divide-y dark:divide-dark-border-primary divide-light-border-primary dark:divide-gray-700">
                @forelse($reports as $report)
                    <tr class="{{ $report->status === 'pending' ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright dark:text-white">
                                {{ class_basename($report->reportable_type) }}
                                @if($report->reportable)
                                    <div class="text-xs dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400 mt-1">
                                        {{ Str::limit($report->reportable->content ?? $report->reportable->title ?? 'N/A', 50) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">
                            {{ $report->reporter->name }}
                        </td>
                        <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-300">
                            {{ Str::limit($report->reason, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($report->status === 'pending')
                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full">
                                    Pending
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                    {{ ucfirst($report->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">
                            {{ $report->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.moderation.show', $report) }}" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">
                            No reports found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
@endsection
