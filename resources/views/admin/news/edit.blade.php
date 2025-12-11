@extends('admin.layouts.app')

@section('title', 'Edit News Article')
@section('header', 'Edit News Article')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Article Details</h3>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="excerpt" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Excerpt</label>
                <textarea name="excerpt" id="excerpt" rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $news->excerpt) }}</textarea>
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Short summary (optional, 500 characters max)</p>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Content *</label>
                <textarea name="content" id="content" rows="12" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Featured Image</label>
                @if ($news->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Max 2MB, JPG, PNG, GIF. Leave empty to keep current image.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Source Information</h3>
            
            <div class="mb-4">
                <label for="source" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Source Name</label>
                <input type="text" name="source" id="source" value="{{ old('source', $news->source) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">E.g., "PC Gamer", "IGN"</p>
            </div>

            <div class="mb-4">
                <label for="source_url" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Source URL</label>
                <input type="url" name="source_url" id="source_url" value="{{ old('source_url', $news->source_url) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Publishing Options</h3>
            
            <div class="mb-4">
                <label for="published_at" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Publish Date</label>
                <input type="datetime-local" name="published_at" id="published_at" 
                    value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Tags</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags', $news->tags->pluck('name')->implode(', ')) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Comma-separated (e.g., "CS2, Counter Strike, Update")</p>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">Publish immediately</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">Feature this article</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.news.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg dark:text-dark-text-primary text-light-text-primary hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                Update Article
            </button>
        </div>
    </form>
</div>
@endsection
