@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-blue to-accent-purple rounded-2xl flex items-center justify-center transform hover:scale-105 transition-transform shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold dark:text-dark-text-bright text-light-text-bright">
                Forgot your password?
            </h2>
            <p class="mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                No problem. Just let us know your email address and we will email you a password reset link.
            </p>
        </div>
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                @if(session('status'))
                    <div class="bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg">
                        <p class="text-sm">{{ session('status') }}</p>
                    </div>
                @endif

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
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-accent-blue to-accent-purple hover:shadow-lg hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-blue">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
            Remember your password? 
            <a href="{{ route('login') }}" class="font-medium text-accent-blue hover:text-accent-purple transition-colors">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection
