@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            Account Settings
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Manage your account, privacy, and notification preferences
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-accent-green/10 border border-accent-green rounded-lg">
            <p class="text-accent-green">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-6" x-data="{ activeTab: 'account' }">
        <div class="flex space-x-2 border-b dark:border-dark-border-primary border-light-border-primary">
            <button @click="activeTab = 'account'" 
                    :class="activeTab === 'account' ? 'border-b-2 border-accent-blue text-accent-blue' : 'dark:text-dark-text-secondary text-light-text-secondary'"
                    class="px-4 py-2 font-medium transition-colors">
                Account
            </button>
            <button @click="activeTab = 'password'" 
                    :class="activeTab === 'password' ? 'border-b-2 border-accent-blue text-accent-blue' : 'dark:text-dark-text-secondary text-light-text-secondary'"
                    class="px-4 py-2 font-medium transition-colors">
                Password
            </button>
            <button @click="activeTab = 'privacy'" 
                    :class="activeTab === 'privacy' ? 'border-b-2 border-accent-blue text-accent-blue' : 'dark:text-dark-text-secondary text-light-text-secondary'"
                    class="px-4 py-2 font-medium transition-colors">
                Privacy
            </button>
            <button @click="activeTab = 'notifications'" 
                    :class="activeTab === 'notifications' ? 'border-b-2 border-accent-blue text-accent-blue' : 'dark:text-dark-text-secondary text-light-text-secondary'"
                    class="px-4 py-2 font-medium transition-colors">
                Notifications
            </button>
        </div>

        <!-- Account Settings -->
        <div x-show="activeTab === 'account'" class="mt-6">
            <form action="{{ route('settings.update.account') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    Account Information
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            Username
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(!$user->email_verified_at)
                        <div class="p-4 bg-yellow-500/10 border border-yellow-500 rounded-lg">
                            <p class="text-yellow-500 text-sm">
                                Your email address is not verified. 
                                <a href="{{ route('verification.notice') }}" class="underline font-medium">Click here to verify</a>
                            </p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Settings -->
        <div x-show="activeTab === 'password'" class="mt-6" style="display: none;">
            <form action="{{ route('settings.update.password') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    Change Password
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            Current Password
                        </label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            New Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Privacy Settings -->
        <div x-show="activeTab === 'privacy'" class="mt-6" style="display: none;">
            <form action="{{ route('settings.update.privacy') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    Privacy Settings
                </h2>

                @php
                    $privacySettings = $profile->privacy_settings ?? [];
                @endphp

                <div class="space-y-4">
                    <div>
                        <label for="profile_visibility" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                            Profile Visibility
                        </label>
                        <select name="profile_visibility" 
                                id="profile_visibility"
                                class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                            <option value="public" {{ ($privacySettings['profile_visibility'] ?? 'public') === 'public' ? 'selected' : '' }}>
                                Public (Everyone can view)
                            </option>
                            <option value="members" {{ ($privacySettings['profile_visibility'] ?? 'public') === 'members' ? 'selected' : '' }}>
                                Members Only
                            </option>
                            <option value="private" {{ ($privacySettings['profile_visibility'] ?? 'public') === 'private' ? 'selected' : '' }}>
                                Private (Only you)
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="show_email" 
                               id="show_email" 
                               value="1"
                               {{ ($privacySettings['show_email'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="show_email" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Show email address on profile
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="show_online_status" 
                               id="show_online_status" 
                               value="1"
                               {{ ($privacySettings['show_online_status'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="show_online_status" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Show when I'm online
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="allow_messages" 
                               id="allow_messages" 
                               value="1"
                               {{ ($privacySettings['allow_messages'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="allow_messages" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Allow private messages
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="allow_profile_posts" 
                               id="allow_profile_posts" 
                               value="1"
                               {{ ($privacySettings['allow_profile_posts'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="allow_profile_posts" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Allow posts on my profile wall
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Save Privacy Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Notification Settings -->
        <div x-show="activeTab === 'notifications'" class="mt-6" style="display: none;">
            <form action="{{ route('settings.update.notifications') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    Email Notifications
                </h2>

                @php
                    $emailNotifications = $profile->custom_fields['email_notifications'] ?? [];
                @endphp

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="email_replies" 
                               id="email_replies" 
                               value="1"
                               {{ ($emailNotifications['replies'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="email_replies" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Notify me when someone replies to my posts
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="email_mentions" 
                               id="email_mentions" 
                               value="1"
                               {{ ($emailNotifications['mentions'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="email_mentions" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Notify me when someone mentions me
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="email_follows" 
                               id="email_follows" 
                               value="1"
                               {{ ($emailNotifications['follows'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="email_follows" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Notify me when someone follows me
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="email_messages" 
                               id="email_messages" 
                               value="1"
                               {{ ($emailNotifications['messages'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="email_messages" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Notify me about new private messages
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="email_digest" 
                               id="email_digest" 
                               value="1"
                               {{ ($emailNotifications['digest'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary text-accent-blue focus:ring-2 focus:ring-accent-blue">
                        <label for="email_digest" class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">
                            Send me a weekly digest of community activity
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Save Notification Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
