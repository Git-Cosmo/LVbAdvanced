<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FPSociety Radio</title>
    @vite(['resources/css/app.css'])
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary dark:text-dark-text-primary text-light-text-primary">
    <div class="h-screen flex flex-col p-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-1">
                🎵 FPSociety Radio
            </h1>
            <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Live Stream</p>
        </div>

        @if($streamUrl)
            <!-- Now Playing -->
            <div class="flex-1 flex flex-col items-center justify-center">
                <div class="w-32 h-32 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center shadow-xl animate-pulse mb-4">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary text-center mb-4" id="now-playing">
                    FPSociety Radio Stream
                </p>
            </div>

            <!-- Player Controls -->
            <div class="space-y-4">
                <!-- Audio Element -->
                <audio id="radio-player" preload="none" class="hidden">
                    <source src="{{ $streamUrl }}" type="audio/mpeg">
                </audio>

                <!-- Control Buttons -->
                <div class="flex justify-center items-center space-x-3">
                    <button id="play-btn" class="bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg transition-all">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </button>
                    <button id="stop-btn" class="bg-gray-600 hover:bg-gray-700 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg transition-all">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <!-- Volume Control -->
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 dark:text-dark-text-secondary text-light-text-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"/>
                    </svg>
                    <input type="range" id="volume-control" min="0" max="100" value="75" class="flex-1">
                    <span id="volume-display" class="text-xs dark:text-dark-text-secondary text-light-text-secondary w-8">75%</span>
                </div>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        Stream not configured
                    </p>
                </div>
            </div>
        @endif
    </div>

    @if($streamUrl)
    <script>
        const player = document.getElementById('radio-player');
        const playBtn = document.getElementById('play-btn');
        const stopBtn = document.getElementById('stop-btn');
        const volumeControl = document.getElementById('volume-control');
        const volumeDisplay = document.getElementById('volume-display');

        // Icon constants
        const ICON_PLAY = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>';
        const ICON_PAUSE = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';

        // Set initial volume
        player.volume = 0.75;

        // Play button
        playBtn.addEventListener('click', () => {
            if (player.paused) {
                player.play();
                playBtn.innerHTML = ICON_PAUSE;
            } else {
                player.pause();
                playBtn.innerHTML = ICON_PLAY;
            }
        });

        // Stop button
        stopBtn.addEventListener('click', () => {
            player.pause();
            player.currentTime = 0;
            playBtn.innerHTML = ICON_PLAY;
        });

        // Volume control
        volumeControl.addEventListener('input', (e) => {
            const volume = e.target.value / 100;
            player.volume = volume;
            volumeDisplay.textContent = e.target.value + '%';
        });
    </script>
    @endif
</body>
</html>
