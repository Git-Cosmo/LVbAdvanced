@extends('admin.layouts.app')

@section('title', 'RSS Feed Management')
@section('header', 'RSS Feed Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Manage RSS feeds for automatic news imports</p>
    <a href="{{ route('admin.rss.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add RSS Feed
    </a>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Feed Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imported</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Fetched</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($feeds as $feed)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $feed->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $feed->url }}</td>
                    <td class="px-6 py-4">
                        @if ($feed->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $feed->imported_items_count }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $feed->last_fetched_at ? $feed->last_fetched_at->diffForHumans() : 'Never' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <form action="{{ route('admin.rss.import', $feed) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-900">Import Now</button>
                        </form>
                        <a href="{{ route('admin.rss.edit', $feed) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.rss.destroy', $feed) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No RSS feeds. <a href="{{ route('admin.rss.create') }}" class="text-primary-600">Add one</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $feeds->links() }}
</div>
@endsection
