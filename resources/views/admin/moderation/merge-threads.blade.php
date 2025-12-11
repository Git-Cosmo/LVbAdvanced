@extends('admin.layouts.app')

@section('title', 'Merge Threads')
@section('header', 'Merge Threads')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.moderation.merge-threads') }}" method="POST">
        @csrf
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">Merge posts from one thread into another. The source thread will be deleted.</p>
            
            <div class="mb-4">
                <label for="source_thread_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Source Thread ID *</label>
                <input type="number" name="source_thread_id" id="source_thread_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Thread to merge FROM (will be deleted)</p>
            </div>

            <div class="mb-4">
                <label for="target_thread_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Target Thread ID *</label>
                <input type="number" name="target_thread_id" id="target_thread_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-1 text-sm dark:text-dark-text-secondary text-light-text-secondary">Thread to merge INTO (will keep all posts)</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.moderation.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg dark:text-dark-text-primary text-light-text-primary hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg" onclick="return confirm('Are you sure? The source thread will be deleted.')">Merge Threads</button>
        </div>
    </form>
</div>
@endsection
