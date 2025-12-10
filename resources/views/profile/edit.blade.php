@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">Edit Profile</h1>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            
            <!-- Avatar Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Avatar
                </label>
                <div class="flex items-center space-x-4">
                    @if($user->profile?->avatar)
                    <img src="{{ Storage::url($user->profile->avatar) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full">
                    @else
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    @endif
                    <input type="file" 
                           name="avatar" 
                           accept="image/*"
                           class="block w-full text-sm dark:text-dark-text-secondary text-light-text-secondary
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-gradient-to-r file:from-accent-blue file:to-accent-purple file:text-white
                                  hover:file:opacity-80">
                </div>
                @error('avatar')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Cover Image Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Cover Image
                </label>
                <input type="file" 
                       name="cover_image" 
                       accept="image/*"
                       class="block w-full text-sm dark:text-dark-text-secondary text-light-text-secondary
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-gradient-to-r file:from-accent-blue file:to-accent-purple file:text-white
                              hover:file:opacity-80">
                @error('cover_image')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- About Me -->
            <div class="mb-6">
                <label for="about_me" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    About Me
                </label>
                <textarea id="about_me" 
                          name="about_me" 
                          rows="4" 
                          class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('about_me') ring-2 ring-accent-red @enderror"
                          placeholder="Tell us about yourself...">{{ old('about_me', $user->profile?->about_me) }}</textarea>
                @error('about_me')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Location -->
            <div class="mb-6">
                <label for="location" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Location
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location', $user->profile?->location) }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('location') ring-2 ring-accent-red @enderror"
                       placeholder="City, Country">
                @error('location')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Website -->
            <div class="mb-6">
                <label for="website" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Website
                </label>
                <input type="url" 
                       id="website" 
                       name="website" 
                       value="{{ old('website', $user->profile?->website) }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('website') ring-2 ring-accent-red @enderror"
                       placeholder="https://example.com">
                @error('website')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Gaming IDs Section -->
            <div class="mb-6">
                <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4">Gaming IDs</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Steam ID -->
                    <div>
                        <label for="steam_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Steam ID
                        </label>
                        <input type="text" 
                               id="steam_id" 
                               name="steam_id" 
                               value="{{ old('steam_id', $user->profile?->steam_id) }}"
                               class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="Your Steam ID">
                    </div>
                    
                    <!-- Discord ID -->
                    <div>
                        <label for="discord_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Discord
                        </label>
                        <input type="text" 
                               id="discord_id" 
                               name="discord_id" 
                               value="{{ old('discord_id', $user->profile?->discord_id) }}"
                               class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="username#0000">
                    </div>
                    
                    <!-- Battle.net ID -->
                    <div>
                        <label for="battlenet_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Battle.net
                        </label>
                        <input type="text" 
                               id="battlenet_id" 
                               name="battlenet_id" 
                               value="{{ old('battlenet_id', $user->profile?->battlenet_id) }}"
                               class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="BattleTag#1234">
                    </div>
                    
                    <!-- Xbox Gamertag -->
                    <div>
                        <label for="xbox_gamertag" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Xbox Gamertag
                        </label>
                        <input type="text" 
                               id="xbox_gamertag" 
                               name="xbox_gamertag" 
                               value="{{ old('xbox_gamertag', $user->profile?->xbox_gamertag) }}"
                               class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="Your Gamertag">
                    </div>
                    
                    <!-- PSN ID -->
                    <div>
                        <label for="psn_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            PlayStation Network
                        </label>
                        <input type="text" 
                               id="psn_id" 
                               name="psn_id" 
                               value="{{ old('psn_id', $user->profile?->psn_id) }}"
                               class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="Your PSN ID">
                    </div>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t dark:border-dark-border-primary border-light-border-primary">
                <a href="{{ route('profile.show', $user) }}" 
                   class="px-6 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:bg-opacity-80 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
