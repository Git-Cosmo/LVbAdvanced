<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page->meta_title ?? $page->title ?? config('app.name', 'vBadvanced Portal') }}</title>
    
    @if(isset($page->meta_description))
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    
    @if(isset($page->meta_keywords))
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-primary-600 to-primary-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold">
                    <a href="/" class="hover:text-primary-100 transition">
                        {{ config('app.name', 'vBadvanced Portal') }}
                    </a>
                </h1>
                
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="hover:text-primary-100 transition">Home</a>
                    @auth
                        <a href="/admin" class="hover:text-primary-100 transition">Admin</a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-primary-100 transition">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="hover:text-primary-100 transition">Login</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="text-sm text-gray-400 mt-2">Powered by vBadvanced Portal System</p>
            </div>
        </div>
    </footer>
</body>
</html>
