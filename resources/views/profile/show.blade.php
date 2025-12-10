@extends('portal.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Profile Header with Cover Image -->
    <div class="relative mb-6">
        @if($user->profile?->cover_image)
        <div class="h-64 rounded-t-xl bg-cover-image" data-bg-image="{{ Storage::url($user->profile->cover_image) }}"></div>
        @else
        <div class="h-64 rounded-t-xl bg-gradient-to-r from-accent-blue via-accent-purple to-accent-blue"></div>
        @endif
        
        <!-- Profile Info Overlay -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-b-xl p-6 -mt-16 relative">
            <div class="flex flex-col md:flex-row items-start md:items-end space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar -->
                <div class="relative">
                    @if($user->profile?->avatar)
                    <img src="{{ Storage::url($user->profile->avatar) }}" 
                         alt="{{ $user->name }}" 
                         class="w-32 h-32 rounded-full border-4 dark:border-dark-bg-secondary border-light-bg-secondary">
                    @else
                    <div class="w-32 h-32 rounded-full border-4 dark:border-dark-bg-secondary border-light-bg-secondary bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                        <span class="text-5xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    @endif
                    
                    <!-- Level Badge -->
                    @if($user->profile)
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-full text-sm font-bold">
                        Level {{ $user->profile->level }}
                    </div>
                    @endif
                </div>
                
                <!-- User Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        {{ $user->name }}
                    </h1>
                    @if($user->profile?->user_title)
                    <p class="dark:text-dark-text-accent text-light-text-accent font-medium">
                        {{ $user->profile->user_title }}
                    </p>
                    @endif
                    
                    <!-- Stats Row -->
                    <div class="flex items-center space-x-6 mt-4 text-sm">
                        <div>
                            <span class="dark:text-dark-text-accent text-light-text-accent font-bold">{{ number_format($user->posts()->count()) }}</span>
                            <span class="dark:text-dark-text-secondary text-light-text-secondary">Posts</span>
                        </div>
                        <div>
                            <span class="dark:text-dark-text-accent text-light-text-accent font-bold">{{ number_format($user->threads()->count()) }}</span>
                            <span class="dark:text-dark-text-secondary text-light-text-secondary">Threads</span>
                        </div>
                        @if($user->profile)
                        <div>
                            <span class="dark:text-dark-text-accent text-light-text-accent font-bold">{{ number_format($user->profile->xp) }}</span>
                            <span class="dark:text-dark-text-secondary text-light-text-secondary">XP</span>
                        </div>
                        <div>
                            <span class="dark:text-dark-text-accent text-light-text-accent font-bold">{{ number_format($user->profile->karma) }}</span>
                            <span class="dark:text-dark-text-secondary text-light-text-secondary">Karma</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('forum.gallery.index', $user) }}" 
                       class="px-6 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                        🖼️ Gallery
                    </a>
                    @auth
                        @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}" 
                           class="px-6 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                            Edit Profile
                        </a>
                        @else
                            @if(auth()->user()->following->contains($user->id))
                            <form action="{{ route('profile.unfollow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-opacity-80 transition-colors">
                                    Unfollow
                                </button>
                            </form>
                            @else
                            <form action="{{ route('profile.follow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all">
                                    Follow
                                </button>
                            </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Sidebar -->
        <div class="space-y-6">
            <!-- About -->
            @if($user->profile?->about_me)
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-3">About Me</h3>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">{{ $user->profile->about_me }}</p>
            </div>
            @endif
            
            <!-- Contact Info -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Contact & Links</h3>
                <div class="space-y-3">
                    @if($user->profile?->location)
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $user->profile->location }}</span>
                    </div>
                    @endif
                    
                    @if($user->profile?->website)
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <a href="{{ $user->profile->website }}" target="_blank" class="dark:text-dark-text-accent text-light-text-accent hover:underline">Website</a>
                    </div>
                    @endif
                    
                    @if($user->profile?->steam_id)
                    <div class="flex items-center space-x-3">
                        <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Steam:</span>
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $user->profile->steam_id }}</span>
                    </div>
                    @endif
                    
                    @if($user->profile?->discord_id)
                    <div class="flex items-center space-x-3">
                        <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Discord:</span>
                        <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $user->profile->discord_id }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Badges -->
            @if($user->badges->isNotEmpty())
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Badges</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($user->badges as $badge)
                    <div class="px-3 py-1 rounded-lg text-sm font-medium" data-badge-color="{{ $badge->color }}">
                        {{ $badge->name }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Followers/Following -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Community</h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                            {{ $user->profile?->followers_count ?? 0 }}
                        </div>
                        <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Followers</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                            {{ $user->profile?->following_count ?? 0 }}
                        </div>
                        <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Following</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Wall -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Profile Wall</h3>
                
                <!-- Post Form -->
                @auth
                @if(auth()->id() !== $user->id)
                <form action="{{ route('profile.wall.post', $user) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="content" rows="3" 
                              class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue" 
                              placeholder="Write something on {{ $user->name }}'s wall..."></textarea>
                    <div class="mt-2 flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                            Post
                        </button>
                    </div>
                </form>
                @endif
                @endauth
                
                <!-- Wall Posts -->
                <div class="space-y-4">
                    @forelse($profilePosts as $post)
                    <div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                {{ substr($post->author->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $post->author->name }}</span>
                                    <span class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="dark:text-dark-text-secondary text-light-text-secondary">{{ $post->content }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center dark:text-dark-text-tertiary text-light-text-tertiary py-8">No wall posts yet</p>
                    @endforelse
                </div>
                
                @if($profilePosts->hasPages())
                <div class="mt-4">
                    {{ $profilePosts->links() }}
                </div>
                @endif
            </div>
            
            <!-- Recent Threads -->
            @if($recentThreads->isNotEmpty())
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Recent Threads</h3>
                <div class="space-y-3">
                    @foreach($recentThreads as $thread)
                    <a href="{{ route('forum.thread.show', $thread->slug) }}" 
                       class="block dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg p-4 dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors">
                        <h4 class="font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">{{ $thread->title }}</h4>
                        <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                            in {{ $thread->forum->name }} • {{ $thread->created_at->diffForHumans() }}
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
