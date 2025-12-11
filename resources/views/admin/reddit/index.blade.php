@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            Reddit Management
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Manage Reddit scraping and content from r/LivestreamFail and r/AITAH
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Total Posts</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['total_posts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-blue/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">Published</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['published_posts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-green/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">LSF Posts</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['lsf_posts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-purple/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-1">AITAH Posts</p>
                    <p class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['aitah_posts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-orange/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8">
        <form action="{{ route('admin.reddit.scrape') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-accent-blue hover:bg-blue-600 text-white rounded-lg transition-colors font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Scrape Reddit Now
            </button>
        </form>
    </div>

    <!-- Subreddit Configuration -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Subreddit Configuration
        </h2>
        
        <div class="space-y-4">
            @foreach($subreddits as $subreddit)
                <div class="p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">
                            {{ $subreddit->display_name }}
                        </h3>
                        <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                            <span>Type: {{ ucfirst($subreddit->content_type) }}</span>
                            <span>Limit: {{ $subreddit->scrape_limit }} posts</span>
                            <span>Posts: {{ $subreddit->posts_count }}</span>
                            @if($subreddit->last_scraped_at)
                                <span>Last scraped: {{ $subreddit->last_scraped_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.reddit.subreddit.toggle', $subreddit) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg font-medium transition-colors {{ $subreddit->is_enabled ? 'bg-accent-green hover:bg-green-600 text-white' : 'bg-gray-500 hover:bg-gray-600 text-white' }}">
                            {{ $subreddit->is_enabled ? 'Enabled' : 'Disabled' }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
            Recent Posts
        </h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b dark:border-dark-border-primary border-light-border-primary">
                        <th class="text-left py-3 px-4 dark:text-dark-text-primary text-light-text-primary font-semibold">Title</th>
                        <th class="text-left py-3 px-4 dark:text-dark-text-primary text-light-text-primary font-semibold">Subreddit</th>
                        <th class="text-left py-3 px-4 dark:text-dark-text-primary text-light-text-primary font-semibold">Score</th>
                        <th class="text-left py-3 px-4 dark:text-dark-text-primary text-light-text-primary font-semibold">Status</th>
                        <th class="text-left py-3 px-4 dark:text-dark-text-primary text-light-text-primary font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPosts as $post)
                        <tr class="border-b dark:border-dark-border-primary border-light-border-primary hover:bg-gray-800/50">
                            <td class="py-3 px-4">
                                <a href="{{ route('reddit.show', $post) }}" target="_blank" class="dark:text-dark-text-bright text-light-text-bright hover:text-accent-blue line-clamp-2">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="py-3 px-4 dark:text-dark-text-secondary text-light-text-secondary">
                                r/{{ $post->subreddit }}
                            </td>
                            <td class="py-3 px-4 dark:text-dark-text-secondary text-light-text-secondary">
                                {{ number_format($post->score) }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $post->is_published ? 'bg-green-500/10 text-green-500' : 'bg-gray-500/10 text-gray-500' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.reddit.post.toggle-publish', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-accent-blue hover:underline text-sm">
                                            {{ $post->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reddit.post.delete', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                                No posts found. Scrape Reddit to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
