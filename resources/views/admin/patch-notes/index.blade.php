@extends('admin.layouts.app')

@section('title', 'Patch Notes Management')
@section('header', 'Patch Notes Management')

@section('content')
<div class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Total Patch Notes</div>
            <div class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['total'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Published</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Featured</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['featured'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Games Covered</div>
            <div class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['games'] }}</div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <p class="dark:text-dark-text-secondary text-light-text-secondary">Manage game patch notes and updates</p>
        <a href="{{ route('admin.patch-notes.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Patch Note
        </a>
    </div>
</div>

@if (session('success'))
    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
        <thead class="bg-gray-50 dark:bg-dark-bg-tertiary">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Game & Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Version</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Released</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Views</th>
                <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse ($patchNotes as $patchNote)
                <tr>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-xs font-medium text-primary-600 dark:text-primary-400">{{ $patchNote->game_name }}</div>
                            <div class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright mt-1">{{ $patchNote->title }}</div>
                            @if ($patchNote->is_featured)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $patchNote->version ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($patchNote->is_published)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $patchNote->released_at ? $patchNote->released_at->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $patchNote->views_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="{{ route('patch-notes.show', $patchNote) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                        <form action="{{ route('admin.patch-notes.toggle-publish', $patchNote) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-green-600 hover:text-green-900">
                                {{ $patchNote->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.patch-notes.toggle-featured', $patchNote) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                {{ $patchNote->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.patch-notes.edit', $patchNote) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.patch-notes.destroy', $patchNote) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this patch note?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">
                        No patch notes found. <a href="{{ route('admin.patch-notes.create') }}" class="text-primary-600 hover:text-primary-800">Create your first patch note</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $patchNotes->links() }}
</div>
@endsection
