<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | FPSociety</title>
    @vite(['resources/css/app.css'])
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-2xl">
        <!-- Error Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <h1 class="text-9xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            404
        </h1>

        <!-- Error Message -->
        <h2 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            Page Not Found
        </h2>

        <p class="text-lg dark:text-dark-text-secondary text-light-text-secondary mb-8">
            Sorry, we couldn't find the page you're looking for. It might have been moved, deleted, or never existed.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="px-8 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all inline-flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Go Home</span>
            </a>
            
            <button onclick="history.back()" class="px-8 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-primary text-light-text-primary rounded-lg font-medium hover:opacity-80 transition-opacity inline-flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Go Back</span>
            </button>
        </div>

        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t dark:border-dark-border-primary border-light-border-primary">
            <p class="dark:text-dark-text-tertiary text-light-text-tertiary mb-4">
                Here are some helpful links instead:
            </p>
            <div class="flex flex-wrap gap-4 justify-center text-sm">
                <a href="{{ route('forum.index') }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline">Forums</a>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <a href="{{ route('news.index') }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline">News</a>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <a href="{{ route('games.deals') }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline">Deals</a>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <a href="{{ route('events.index') }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline">Events</a>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <a href="{{ route('contact') }}" class="dark:text-dark-text-accent text-light-text-accent hover:underline">Contact</a>
            </div>
        </div>
    </div>
</body>
</html>
