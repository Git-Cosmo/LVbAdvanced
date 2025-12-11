@extends('admin.layouts.app')

@section('title', 'Add RSS Feed')
@section('header', 'Add RSS Feed')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.rss.store') }}" method="POST">
        @csrf
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Feed Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="url" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Feed URL *</label>
                <input type="url" name="url" id="url" value="{{ old('url') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('url') border-red-500 @enderror">
                @error('url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="refresh_interval" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Refresh Interval (minutes) *</label>
                <input type="number" name="refresh_interval" id="refresh_interval" value="{{ old('refresh_interval', 60) }}" min="15" max="1440" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Min: 15, Max: 1440 (24 hours)</p>
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Auto-apply Tags</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Comma-separated tags for all imported articles</p>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-gray-300 text-primary-600">
                    <span class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">Active</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.rss.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg dark:text-dark-text-primary text-light-text-primary hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">Add Feed</button>
        </div>
    </form>
</div>
@endsection
