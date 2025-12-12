@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 dark:text-dark-text-secondary text-light-text-secondary text-sm">
        <a href="{{ route('forum.index') }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">Forums</a>
        <span>›</span>
        <a href="{{ route('forum.show', $forum->category->slug) }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">{{ $forum->category->name }}</a>
        <span>›</span>
        <a href="{{ route('forum.show', $forum->slug) }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">{{ $forum->name }}</a>
        <span>›</span>
        <span class="dark:text-dark-text-primary text-light-text-primary">Create Thread</span>
    </nav>

    <!-- Create Thread Form -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Create New Thread
        </h1>

        <form action="{{ route('forum.thread.store', $forum) }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Thread Title
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('title') ring-2 ring-accent-red @enderror" 
                       placeholder="Enter a descriptive title for your thread">
                @error('title')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Content
                </label>
                <x-rich-text-editor 
                    name="content" 
                    :value="old('content', '')" 
                    placeholder="Write your thread content here..." 
                />
                @error('content')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
                
                <div class="mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    <p>Use the toolbar to format your content. HTML formatting supported.</p>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="{{ route('forum.show', $forum->slug) }}" 
                   class="px-6 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:bg-opacity-80 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Create Thread
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
