@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-blue to-accent-purple rounded-2xl flex items-center justify-center transform hover:scale-105 transition-transform shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold dark:text-dark-text-bright text-light-text-bright">
                Setup Two-Factor Authentication
            </h2>
            <p class="mt-2 text-sm dark:text-dark-text-secondary text-light-text-secondary">
                Scan the QR code with your authenticator app
            </p>
        </div>
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
            <div class="space-y-6">
                <!-- QR Code -->
                <div class="flex justify-center">
                    <div class="p-4 bg-white rounded-lg">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" alt="QR Code" class="w-48 h-48">
                    </div>
                </div>

                <!-- Secret Key -->
                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                        Or enter this code manually:
                    </label>
                    <div class="px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <code class="text-sm dark:text-dark-text-accent text-light-text-accent font-mono">{{ $secret }}</code>
                    </div>
                </div>

                <!-- Verification Form -->
                <form method="POST" action="{{ route('2fa.enable') }}" class="space-y-4">
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
                        <label for="code" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Enter code to confirm
                        </label>
                        <input id="code" name="code" type="text" inputmode="numeric" required 
                               class="w-full px-4 py-3 text-center text-2xl tracking-widest dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue"
                               placeholder="000000"
                               maxlength="6">
                    </div>

                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-accent-blue to-accent-purple hover:shadow-lg hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-blue">
                        Enable 2FA
                    </button>
                </form>
            </div>
        </div>
        
        <p class="text-center text-sm dark:text-dark-text-tertiary text-light-text-tertiary">
            <a href="{{ route('profile.edit') }}" class="font-medium text-accent-blue hover:text-accent-purple transition-colors">
                Cancel
            </a>
        </p>
    </div>
</div>
@endsection
