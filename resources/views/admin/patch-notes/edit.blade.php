@extends('admin.layouts.app')

@section('title', 'Edit Patch Note')
@section('header', 'Edit Patch Note')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.patch-notes.update', $patchNote) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Patch Note Details</h3>
            
            <div class="mb-4">
                <label for="game_name" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Game Name *</label>
                <input type="text" name="game_name" id="game_name" value="{{ old('game_name', $patchNote->game_name) }}" required
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright @error('game_name') border-red-500 @enderror">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">E.g., "Counter Strike 2", "GTA V", "Fortnite"</p>
                @error('game_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="version" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Version</label>
                <input type="text" name="version" id="version" value="{{ old('version', $patchNote->version) }}"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">E.g., "1.2.3", "Season 5", "Update 2.0"</p>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $patchNote->title) }}" required
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Description</label>
                <textarea name="description" id="description" rows="2"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright @error('description') border-red-500 @enderror">{{ old('description', $patchNote->description) }}</textarea>
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Brief summary of changes</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Patch Notes Content *</label>
                <textarea name="content" id="content" rows="15" required
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright font-mono text-sm @error('content') border-red-500 @enderror">{{ old('content', $patchNote->content) }}</textarea>
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Full patch notes. Supports HTML and markdown.</p>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="source_url" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Source URL</label>
                <input type="url" name="source_url" id="source_url" value="{{ old('source_url', $patchNote->source_url) }}"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Official patch notes URL</p>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Publishing Options</h3>
            
            <div class="mb-4">
                <label for="released_at" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Release Date</label>
                <input type="datetime-local" name="released_at" id="released_at" 
                    value="{{ old('released_at', $patchNote->released_at ? $patchNote->released_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
            </div>

            <div class="flex items-center mb-4">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $patchNote->is_published) ? 'checked' : '' }}
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="is_published" class="ml-2 block text-sm dark:text-dark-text-primary text-light-text-primary">
                    Publish immediately
                </label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $patchNote->is_featured) ? 'checked' : '' }}
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="is_featured" class="ml-2 block text-sm dark:text-dark-text-primary text-light-text-primary">
                    Feature this patch note
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                Update Patch Note
            </button>
            <a href="{{ route('admin.patch-notes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
