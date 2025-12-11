@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.moderation.index') }}" 
           class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
            ← Back to Queue
        </a>
    </div>
    
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary dark:bg-gray-800 rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright dark:text-white mb-6">
            Report #{{ $report->id }}
        </h1>
        
        <div class="space-y-6">
            <!-- Report Details -->
            <div>
                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright dark:text-white mb-4">Report Information</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Reporter</dt>
                        <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ $report->reporter->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Reported</dt>
                        <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ $report->created_at->format('M d, Y g:i A') }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Reason</dt>
                        <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ $report->reason }}</dd>
                    </div>
                </dl>
            </div>
            
            <!-- Reported Content -->
            @if($report->reportable)
                <div>
                    <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright dark:text-white mb-4">Reported Content</h3>
                    <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:bg-gray-900 rounded-lg p-4">
                        <p class="text-sm dark:text-dark-text-primary text-light-text-primary dark:text-gray-300">
                            {{ $report->reportable->content ?? $report->reportable->title ?? 'Content not available' }}
                        </p>
                    </div>
                </div>
            @endif
            
            <!-- Resolution Form -->
            @if($report->status === 'pending')
                <form action="{{ route('admin.moderation.resolve', $report) }}" method="POST" class="border-t dark:border-gray-700 pt-6">
                    @csrf
                    
                    <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright dark:text-white mb-4">Take Action</h3>
                    
                    <div class="mb-4">
                        <label for="action" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary dark:text-gray-300 mb-2">
                            Action
                        </label>
                        <select id="action" 
                                name="action" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="dismiss">Dismiss Report</option>
                            <option value="delete_content">Delete Content</option>
                            <option value="warn_user">Warn User</option>
                            <option value="ban_user">Ban User (7 days)</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary dark:text-gray-300 mb-2">
                            Moderator Notes (optional)
                        </label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                                  placeholder="Add any notes about this decision..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.moderation.index') }}" 
                           class="px-6 py-2 bg-gray-200 dark:bg-gray-700 dark:text-dark-text-bright text-light-text-bright dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Resolve Report
                        </button>
                    </div>
                </form>
            @else
                <div class="border-t dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright dark:text-white mb-4">Resolution</h3>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ ucfirst($report->status) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Moderator</dt>
                            <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ $report->moderator->name ?? 'N/A' }}</dd>
                        </div>
                        @if($report->moderator_notes)
                            <div class="col-span-2">
                                <dt class="text-sm font-medium dark:text-dark-text-secondary text-light-text-secondary dark:text-gray-400">Notes</dt>
                                <dd class="mt-1 text-sm dark:text-dark-text-bright text-light-text-bright dark:text-white">{{ $report->moderator_notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
