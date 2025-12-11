@extends('admin.layouts.app')

@section('title', 'News Management')
@section('header', 'News Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="dark:text-dark-text-secondary text-light-text-secondary">Manage news articles and announcements</p>
    <a href="{{ route('admin.news.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Create News Article
    </a>
</div>

@if (session('success'))
    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Published</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Views</th>
                <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse ($news as $article)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if ($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" alt="" class="w-10 h-10 rounded object-cover mr-3">
                            @endif
                            <div>
                                <div class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright">{{ $article->title }}</div>
                                @if ($article->is_featured)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $article->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($article->is_published)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:text-dark-text-bright text-light-text-bright">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $article->views_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('news.show', $article) }}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ route('admin.news.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this news article?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center dark:text-dark-text-secondary text-light-text-secondary">
                        No news articles found. <a href="{{ route('admin.news.create') }}" class="text-primary-600 hover:text-primary-800">Create your first article</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $news->links() }}
</div>
@endsection
