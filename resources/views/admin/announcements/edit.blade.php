@extends('admin.layouts.app')

@section('title', 'Edit Announcement')
@section('header', 'Edit Announcement')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 dark:text-dark-text-bright text-light-text-bright">Announcement Details</h3>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-light-border-primary dark:bg-dark-bg-tertiary bg-white rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:text-dark-text-primary text-light-text-primary @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Message *</label>
                <textarea name="message" id="message" rows="8" required
                    class="w-full px-3 py-2 border dark:border-dark-border-primary border-light-border-primary dark:bg-dark-bg-tertiary bg-white rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:text-dark-text-primary text-light-text-primary @error('message') border-red-500 @enderror">{{ old('message', $announcement->message) }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 dark:text-dark-text-bright text-light-text-bright">Publishing Options</h3>
            
            <div class="flex items-center mb-4">
                <input type="checkbox" name="publish_now" id="publish_now" value="1" {{ $announcement->published_at ? 'checked' : '' }}
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="publish_now" class="ml-2 block text-sm dark:text-dark-text-primary text-light-text-primary">
                    Published
                </label>
            </div>
            
            @if ($announcement->published_at)
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    Published {{ $announcement->published_at->diffForHumans() }}
                </p>
            @endif
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                Update Announcement
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
