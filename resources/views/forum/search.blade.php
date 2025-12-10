@extends('portal.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Search Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Search Results</h1>
        
        <!-- Search Form -->
        <form action="{{ route('forum.search') }}" method="GET" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}" 
                           placeholder="Search threads, posts, and users..." 
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">
                </div>
                
                <div>
                    <select name="filter" class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All Results</option>
                        <option value="threads" {{ $filter === 'threads' ? 'selected' : '' }}>Threads Only</option>
                        <option value="posts" {{ $filter === 'posts' ? 'selected' : '' }}>Posts Only</option>
                        <option value="users" {{ $filter === 'users' ? 'selected' : '' }}>Users Only</option>
                    </select>
                </div>
                
                <div>
                    <input type="date" 
                           name="date_from" 
                           value="{{ $dateFrom }}" 
                           placeholder="From date"
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">
                </div>
                
                <div class="md:col-span-2 flex justify-end space-x-3">
                    <a href="{{ route('forum.search') }}" class="px-6 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-opacity-80 transition-colors">
                        Clear
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($query)
        <!-- Threads Results -->
        @if(in_array($filter, ['all', 'threads']) && $threads->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Threads ({{ $threads->total() }})
            </h2>
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden">
                @foreach($threads as $thread)
                <a href="{{ route('forum.thread.show', $thread->slug) }}" 
                   class="block p-6 dark:border-b dark:border-dark-border-secondary border-light-border-secondary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                    <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                        {{ $thread->title }}
                    </h3>
                    <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        <span>{{ $thread->user->name }}</span>
                        <span>•</span>
                        <span>{{ $thread->forum->name }}</span>
                        <span>•</span>
                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                        <span>•</span>
                        <span>{{ $thread->posts_count }} replies</span>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $threads->appends(request()->except('threads_page'))->links() }}
            </div>
        </div>
        @endif

        <!-- Posts Results -->
        @if(in_array($filter, ['all', 'posts']) && $posts->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Posts ({{ $posts->total() }})
            </h2>
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl overflow-hidden">
                @foreach($posts as $post)
                <a href="{{ route('forum.thread.show', $post->thread->slug) }}#post-{{ $post->id }}" 
                   class="block p-6 dark:border-b dark:border-dark-border-secondary border-light-border-secondary dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                    <div class="prose dark:prose-invert max-w-none mb-2">
                        {{ Str::limit(strip_tags($post->content_html), 200) }}
                    </div>
                    <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        <span>{{ $post->user->name }}</span>
                        <span>•</span>
                        <span>in {{ $post->thread->title }}</span>
                        <span>•</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $posts->appends(request()->except('posts_page'))->links() }}
            </div>
        </div>
        @endif

        <!-- Users Results -->
        @if(in_array($filter, ['all', 'users']) && $users->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Users ({{ $users->total() }})
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($users as $user)
                <a href="{{ route('profile.show', $user) }}" 
                   class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                {{ $user->threads_count }} threads • {{ $user->posts_count }} posts
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $users->appends(request()->except('users_page'))->links() }}
            </div>
        </div>
        @endif

        @if($threads->isEmpty() && $posts->isEmpty() && $users->isEmpty())
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                No Results Found
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Try different keywords or filters
            </p>
        </div>
        @endif
    @else
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                Start Searching
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Enter keywords to search threads, posts, and users
            </p>
        </div>
    @endif
</div>
@endsection
