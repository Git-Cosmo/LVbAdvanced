@extends('admin.layouts.app')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="flex-1">
    <header class="dark:bg-dark-bg-secondary bg-light-bg-secondary border-b dark:border-dark-border-primary border-light-border-primary p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">Edit User: {{ $user->name }}</h1>
                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary mt-1">Manage user details, roles, and achievements</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg dark:text-dark-text-primary text-light-text-primary hover:opacity-80 transition-opacity">
                Back to Users
            </a>
        </div>
    </header>

    <main class="p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                <p class="text-green-500">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                <ul class="text-red-500 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <!-- Left Column - User Info and Roles -->
            <div class="col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">Basic Information</h2>
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">Roles</label>
                                <div class="space-y-2">
                                    @foreach($roles as $role)
                                        <label class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="roles[]" 
                                                value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-accent-blue focus:ring-accent-blue"
                                            >
                                            <span class="ml-2 dark:text-dark-text-primary text-light-text-primary">{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button 
                                type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity"
                            >
                                Update User
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Profile Stats -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">Profile Stats</h2>
                    <form method="POST" action="{{ route('admin.users.updateProfile', $user) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">XP</label>
                                <input 
                                    type="number" 
                                    name="xp" 
                                    value="{{ old('xp', $user->profile->xp ?? 0) }}"
                                    min="0"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">Level</label>
                                <input 
                                    type="number" 
                                    name="level" 
                                    value="{{ old('level', $user->profile->level ?? 1) }}"
                                    min="1"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">Karma</label>
                                <input 
                                    type="number" 
                                    name="karma" 
                                    value="{{ old('karma', $user->profile->karma ?? 0) }}"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">User Title</label>
                                <input 
                                    type="text" 
                                    name="user_title" 
                                    value="{{ old('user_title', $user->profile->user_title) }}"
                                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                    placeholder="e.g., Forum Legend"
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">About Me</label>
                            <textarea 
                                name="about_me" 
                                rows="4"
                                class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                            >{{ old('about_me', $user->profile->about_me) }}</textarea>
                        </div>

                        <button 
                            type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity"
                        >
                            Update Profile
                        </button>
                    </form>
                </div>

                <!-- Achievements Management -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">Achievements</h2>
                    
                    <!-- Current Achievements -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-3">Current Achievements</h3>
                        <div class="space-y-2">
                            @forelse($user->achievements as $achievement)
                                <div class="flex items-center justify-between p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                                    <div class="flex items-center">
                                        <div class="text-2xl mr-3">{{ $achievement->icon ?? '🏆' }}</div>
                                        <div>
                                            <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $achievement->name }}</div>
                                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">{{ $achievement->points }} XP</div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.users.revokeAchievement', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="achievement_id" value="{{ $achievement->id }}">
                                        <button 
                                            type="submit"
                                            class="text-red-500 hover:text-red-400 text-sm"
                                            onclick="return confirm('Are you sure you want to revoke this achievement?')"
                                        >
                                            Revoke
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">No achievements earned yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Grant Achievement -->
                    <div>
                        <h3 class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-3">Grant Achievement</h3>
                        <form method="POST" action="{{ route('admin.users.grantAchievement', $user) }}" class="flex gap-2">
                            @csrf
                            <select 
                                name="achievement_id"
                                class="flex-1 px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                required
                            >
                                <option value="">Select Achievement...</option>
                                @foreach($allAchievements as $achievement)
                                    <option value="{{ $achievement->id }}">{{ $achievement->name }} ({{ $achievement->points }} XP)</option>
                                @endforeach
                            </select>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity"
                            >
                                Grant
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Badges Management -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <h2 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-4">Badges</h2>
                    
                    <!-- Current Badges -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-3">Current Badges</h3>
                        <div class="grid grid-cols-3 gap-3">
                            @forelse($user->badges as $badge)
                                <div class="p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg text-center relative">
                                    <div class="text-3xl mb-1">{{ $badge->icon ?? '🎖️' }}</div>
                                    <div class="text-xs dark:text-dark-text-primary text-light-text-primary">{{ $badge->name }}</div>
                                    <form method="POST" action="{{ route('admin.users.revokeBadge', $user) }}" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="badge_id" value="{{ $badge->id }}">
                                        <button 
                                            type="submit"
                                            class="text-red-500 hover:text-red-400 text-xs"
                                            onclick="return confirm('Are you sure you want to revoke this badge?')"
                                        >
                                            Revoke
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="col-span-3 text-sm dark:text-dark-text-tertiary text-light-text-tertiary">No badges earned yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Grant Badge -->
                    <div>
                        <h3 class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-3">Grant Badge</h3>
                        <form method="POST" action="{{ route('admin.users.grantBadge', $user) }}" class="flex gap-2">
                            @csrf
                            <select 
                                name="badge_id"
                                class="flex-1 px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                                required
                            >
                                <option value="">Select Badge...</option>
                                @foreach($allBadges as $badge)
                                    <option value="{{ $badge->id }}">{{ $badge->icon }} {{ $badge->name }}</option>
                                @endforeach
                            </select>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity"
                            >
                                Grant
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats Summary -->
            <div class="space-y-6">
                <!-- User Card -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
                    <div class="text-center">
                        <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</h3>
                        <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary mt-1">{{ $user->email }}</p>
                        @if($user->profile && $user->profile->user_title)
                            <p class="text-sm text-accent-blue mt-2">{{ $user->profile->user_title }}</p>
                        @endif
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="space-y-4">
                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Level</span>
                            <span class="text-lg font-bold text-accent-blue">{{ $user->profile->level ?? 1 }}</span>
                        </div>
                    </div>

                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">XP</span>
                            <span class="text-lg font-bold text-accent-purple">{{ number_format($user->profile->xp ?? 0) }}</span>
                        </div>
                    </div>

                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Karma</span>
                            <span class="text-lg font-bold text-green-500">{{ number_format($user->profile->karma ?? 0) }}</span>
                        </div>
                    </div>

                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Posts</span>
                            <span class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">{{ $user->posts->count() }}</span>
                        </div>
                    </div>

                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Achievements</span>
                            <span class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">{{ $user->achievements->count() }}</span>
                        </div>
                    </div>

                    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Badges</span>
                            <span class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">{{ $user->badges->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                @if($user->id !== auth()->id())
                    <div class="dark:bg-red-900/20 bg-red-100 border border-red-500/50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-red-500 mb-3">Danger Zone</h3>
                        <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary mb-4">Permanently delete this user and all associated data.</p>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone!');">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                            >
                                Delete User
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
