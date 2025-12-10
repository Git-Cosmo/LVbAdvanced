@extends('portal.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ replyTo: null, editPost: null, quoteContent: '' }">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 dark:text-dark-text-secondary text-light-text-secondary text-sm">
        <a href="{{ route('forum.index') }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">Forums</a>
        <span>›</span>
        <a href="{{ route('forum.show', $thread->forum->slug) }}" class="dark:hover:text-dark-text-accent hover:text-light-text-accent">{{ $thread->forum->name }}</a>
        <span>›</span>
        <span class="dark:text-dark-text-primary text-light-text-primary">{{ $thread->title }}</span>
    </nav>

    <!-- Thread Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    @if($thread->is_pinned)
                    <span class="px-2 py-1 bg-accent-yellow/20 text-accent-yellow text-xs font-semibold rounded">📌 PINNED</span>
                    @endif
                    @if($thread->is_locked)
                    <span class="px-2 py-1 bg-accent-red/20 text-accent-red text-xs font-semibold rounded">🔒 LOCKED</span>
                    @endif
                </div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    {{ $thread->title }}
                </h1>
                <div class="flex items-center space-x-4 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    <span>Started by <strong class="dark:text-dark-text-primary text-light-text-primary">{{ $thread->user->name }}</strong></span>
                    <span>{{ $thread->created_at->diffForHumans() }}</span>
                    <span>{{ number_format($thread->views_count) }} views</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Poll (if exists) -->
    @if($thread->poll)
        @include('forum.poll.show', ['poll' => $thread->poll])
    @endif

    <!-- Posts -->
    @foreach($posts as $post)
    <div id="post-{{ $post->id }}" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl mb-4 overflow-hidden">
        <div class="flex">
            <!-- User Sidebar -->
            <div class="w-48 dark:bg-dark-bg-tertiary bg-light-bg-tertiary p-6 border-r dark:border-dark-border-secondary border-light-border-secondary">
                <div class="text-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">
                        {{ $post->user->name }}
                    </h3>
                    @if($post->user->profile)
                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mb-2">
                        Level {{ $post->user->profile->level }}
                    </p>
                    @endif
                    <div class="text-xs dark:text-dark-text-secondary text-light-text-secondary">
                        Posts: {{ number_format($post->user->posts()->count()) }}
                    </div>
                </div>
            </div>

            <!-- Post Content -->
            <div class="flex-1 p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $post->created_at->format('M d, Y \a\t g:i A') }}
                    </span>
                    <div class="flex items-center space-x-2">
                        <a href="#post-{{ $post->id }}" class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary hover:dark:text-dark-text-accent hover:text-light-text-accent">#</a>
                        @auth
                        @can('update', $post)
                        <button @click="editPost = editPost === {{ $post->id }} ? null : {{ $post->id }}" 
                                class="text-sm dark:text-dark-text-accent text-light-text-accent dark:hover:text-dark-text-bright hover:text-light-text-bright">
                            ✏️ Edit
                        </button>
                        @endcan
                        @endauth
                    </div>
                </div>

                <!-- Edit Form -->
                <div x-show="editPost === {{ $post->id }}" x-cloak class="mb-4">
                    <form action="{{ route('forum.post.update', $post) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="content" rows="6" 
                                  class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">{{ $post->content }}</textarea>
                        <div class="mt-2 flex justify-end space-x-2">
                            <button type="button" @click="editPost = null" class="px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg">Save</button>
                        </div>
                    </form>
                </div>

                <div x-show="editPost !== {{ $post->id }}">
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $post->content_html !!}
                    </div>
                </div>

                @if($post->edited_at)
                <div class="mt-4 pt-4 border-t dark:border-dark-border-secondary border-light-border-secondary text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                    Last edited {{ $post->edited_at->diffForHumans() }}
                    @if($post->editor)
                    by {{ $post->editor->name }}
                    @endif
                </div>
                @endif

                <!-- Reactions -->
                <div class="mt-4 flex items-center space-x-2" x-data="{ showReactions: false }">
                    @auth
                    <div class="relative">
                        <button @click="showReactions = !showReactions" 
                                class="px-3 py-1 rounded-lg dark:bg-dark-bg-elevated bg-light-bg-elevated dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors text-sm">
                            Add Reaction
                        </button>
                        <div x-show="showReactions" @click.away="showReactions = false" x-cloak
                             class="absolute bottom-full mb-2 left-0 dark:bg-dark-bg-elevated bg-light-bg-elevated rounded-lg shadow-xl p-2 flex space-x-1 z-10">
                            @foreach(['like' => '👍', 'love' => '❤️', 'laugh' => '😂', 'wow' => '😮', 'sad' => '😢', 'angry' => '😠'] as $type => $emoji)
                            <form action="{{ route('forum.reaction.toggle', $post) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <button type="submit" class="text-2xl hover:scale-125 transition-transform p-1">{{ $emoji }}</button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                    @endauth
                    
                    @if($post->reactions_count > 0)
                    <div class="px-3 py-1 rounded-lg dark:bg-dark-bg-elevated bg-light-bg-elevated text-sm">
                        👍 {{ $post->reactions_count }}
                    </div>
                    @endif
                    
                    @auth
                    <button @click="quoteContent = '[quote={{ $post->user->name }}]' + `{{ addslashes($post->content) }}` + '[/quote]\n'; document.getElementById('reply-content').focus()" 
                            class="px-3 py-1 rounded-lg dark:bg-dark-bg-elevated bg-light-bg-elevated dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors text-sm">
                        💬 Quote
                    </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="mb-6">
        {{ $posts->links() }}
    </div>
    @endif

    <!-- Reply Form -->
    @auth
    @if(!$thread->is_locked)
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
        <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">
            Post a Reply
        </h3>
        <form action="{{ route('forum.post.store', $thread) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea id="reply-content" 
                      name="content" 
                      rows="6" 
                      x-model="quoteContent"
                      data-mention-enabled
                      class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue" 
                      placeholder="Write your reply... (Type @ to mention users)"></textarea>
            
            <!-- Attachments Section -->
            <div id="attachment-progress" class="mt-2 space-y-1"></div>
            <div id="attachments-list" class="mt-2 space-y-1"></div>
            
            <div class="mt-4 flex justify-between items-center">
                <button type="button"
                        data-upload-attachment
                        data-attachable-type="App\Models\Forum\ForumPost"
                        data-attachable-id="0"
                        class="px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    📎 Attach Files
                </button>
                
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Post Reply
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 text-center">
        <svg class="w-12 h-12 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            This thread is locked. No new replies can be posted.
        </p>
    </div>
    @endif
    @else
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 text-center">
        <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
            You must be logged in to reply to this thread.
        </p>
        <a href="{{ route('login') }}" 
           class="inline-block px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
            Sign In
        </a>
    </div>
    @endauth
</div>
@endsection
