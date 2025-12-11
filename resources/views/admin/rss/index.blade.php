@extends('admin.layouts.app')

@section('title', 'RSS Feed Management')
@section('header', 'RSS Feed Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="dark:text-dark-text-secondary text-light-text-secondary">Manage RSS feeds for automatic news imports</p>
    <a href="{{ route('admin.rss.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add RSS Feed
    </a>
</div>

@if (session('success'))
    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
        <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Feed Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">URL</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Imported</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Last Fetched</th>
                <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse ($feeds as $feed)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium dark:text-dark-text-bright text-light-text-bright">{{ $feed->name }}</td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary truncate max-w-xs">{{ $feed->url }}</td>
                    <td class="px-6 py-4">
                        @if ($feed->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400">Active</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-secondary text-light-text-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $feed->imported_items_count }}</td>
                    <td class="px-6 py-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $feed->last_fetched_at ? $feed->last_fetched_at->diffForHumans() : 'Never' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <form action="{{ route('admin.rss.import', $feed) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-blue-400 hover:text-blue-300">Import Now</button>
                        </form>
                        <a href="{{ route('admin.rss.edit', $feed) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                        <form action="{{ route('admin.rss.destroy', $feed) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete the RSS feed &quot;{{ $feed->name }}&quot;? All import history will be lost.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">No RSS feeds. <a href="{{ route('admin.rss.create') }}" class="text-primary-600">Add one</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $feeds->links() }}
</div>
@endsection
