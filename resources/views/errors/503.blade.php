<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Maintenance Mode | FPSociety</title>
    @vite(['resources/css/app.css'])
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-2xl">
        <!-- Maintenance Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center animate-pulse">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <h1 class="text-9xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            503
        </h1>

        <!-- Error Message -->
        <h2 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            Maintenance Mode
        </h2>

        <p class="text-lg dark:text-dark-text-secondary text-light-text-secondary mb-8">
            We're currently performing scheduled maintenance to improve your experience. We'll be back soon!
        </p>

        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="w-full dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-full h-2 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-accent-blue to-accent-purple animate-pulse" style="width: 75%"></div>
            </div>
        </div>

        <!-- Estimated Time (optional) -->
        @if(isset($estimatedTime))
        <p class="dark:text-dark-text-accent text-light-text-accent mb-8">
            Estimated time: {{ $estimatedTime }}
        </p>
        @endif

        <!-- Social Links -->
        <div class="mt-12 pt-8 border-t dark:border-dark-border-primary border-light-border-primary">
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                Stay updated on our progress:
            </p>
            <div class="flex gap-4 justify-center">
                <a href="https://twitter.com/fpsociety" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#1DA1F2] hover:bg-[#1a8cd8] text-white flex items-center justify-center transition-all hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="https://discord.gg/fpsociety" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#5865F2] hover:bg-[#4752c4] text-white flex items-center justify-center transition-all hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
