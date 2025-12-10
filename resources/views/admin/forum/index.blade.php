@extends('admin.layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">Forum Management</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.forum.category.create') }}" 
               class="px-4 py-2 bg-gradient-to-r from-accent-purple to-accent-blue text-white rounded-lg hover:shadow-lg transition-all">
                New Category
            </a>
            <a href="{{ route('admin.forum.forum.create') }}" 
               class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:shadow-lg transition-all">
                New Forum
            </a>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="mb-8">
    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Categories</h2>
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Forums</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-dark-border-secondary divide-light-border-secondary">
                @forelse($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $category->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $category->slug }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-accent text-light-text-accent font-semibold">{{ $category->forums_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $category->order }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($category->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.forum.category.edit', $category) }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.forum.category.delete', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-accent-red hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                        No categories yet. Create one to get started!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Forums Section -->
<div>
    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Forums</h2>
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Threads</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Subforums</th>
                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-dark-border-secondary divide-light-border-secondary">
                @forelse($forums as $forum)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $forum->name }}</div>
                        <div class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">{{ $forum->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $forum->category->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-accent text-light-text-accent font-semibold">{{ $forum->threads_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $forum->children_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($forum->is_locked)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Locked</span>
                        @elseif($forum->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.forum.forum.edit', $forum) }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.forum.forum.delete', $forum) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-accent-red hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                        No forums yet. Create one to get started!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
