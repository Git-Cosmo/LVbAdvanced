@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-blue to-accent-purple rounded-2xl flex items-center justify-center transform hover:scale-105 transition-transform shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold dark:text-dark-text-bright text-light-text-bright">
                Create your account
            </h2>
            <p class="mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                Join our community today
            </p>
        </div>
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/50 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                        Username
                    </label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('name') ring-2 ring-red-500 @enderror"
                           placeholder="Choose a username">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                        Email address
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('email') ring-2 ring-red-500 @enderror"
                           placeholder="you@example.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                        Password
                    </label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('password') ring-2 ring-red-500 @enderror"
                           placeholder="Create a strong password">
                    <p class="mt-1 text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                        Must be at least 8 characters
                    </p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                           placeholder="Confirm your password">
                </div>

                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 mt-1 text-accent-blue focus:ring-accent-blue border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        I agree to the <a href="#" class="text-accent-blue hover:text-accent-purple">Terms of Service</a> and <a href="#" class="text-accent-blue hover:text-accent-purple">Privacy Policy</a>
                    </label>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-accent-blue to-accent-purple hover:shadow-lg hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-blue">
                        Create Account
                    </button>
                </div>

                <!-- OAuth Buttons -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t dark:border-dark-border-primary border-light-border-primary"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-tertiary text-light-text-tertiary">
                            Or sign up with
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('oauth.redirect', 'steam') }}" 
                       class="flex justify-center items-center px-4 py-2 border dark:border-dark-border-primary border-light-border-primary rounded-lg dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                        <span class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary">Steam</span>
                    </a>
                    <a href="{{ route('oauth.redirect', 'discord') }}" 
                       class="flex justify-center items-center px-4 py-2 border dark:border-dark-border-primary border-light-border-primary rounded-lg dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                        <span class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary">Discord</span>
                    </a>
                    <a href="{{ route('oauth.redirect', 'battlenet') }}" 
                       class="flex justify-center items-center px-4 py-2 border dark:border-dark-border-primary border-light-border-primary rounded-lg dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                        <span class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary">Battle.net</span>
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-medium text-accent-blue hover:text-accent-purple transition-colors">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection
