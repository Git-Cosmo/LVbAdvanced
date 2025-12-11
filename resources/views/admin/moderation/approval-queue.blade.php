@extends('admin.layouts.app')

@section('title', 'Approval Queue')
@section('header', 'Content Approval Queue')

@section('content')
@if (session('success'))
    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Thread</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Forum</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse ($pendingThreads as $thread)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium dark:text-dark-text-bright text-light-text-bright">{{ $thread->title }}</td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $thread->user->name }}</td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $thread->forum->name }}</td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $thread->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <form action="{{ route('admin.moderation.approve') }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="type" value="thread">
                            <input type="hidden" name="id" value="{{ $thread->id }}">
                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                        </form>
                        <form action="{{ route('admin.moderation.deny') }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this thread?');">
                            @csrf
                            <input type="hidden" name="type" value="thread">
                            <input type="hidden" name="id" value="{{ $thread->id }}">
                            <button type="submit" class="text-red-600 hover:text-red-900">Deny</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">No pending content to review.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $pendingThreads->links() }}
</div>
@endsection
