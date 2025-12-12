@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            🎵 Live Radio
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Listen to FPSociety live radio featuring gaming music and community shows
        </p>
    </div>

    <!-- Radio Player -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden">
        @if($streamUrl)
            <div class="p-8">
                <!-- Now Playing Section -->
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <div class="w-48 h-48 mx-auto bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center shadow-2xl animate-pulse">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                        Now Playing
                    </h2>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary" id="now-playing">
                        FPSociety Radio Stream
                    </p>
                </div>

                <!-- Audio Player -->
                <div class="mb-6">
                    <audio id="radio-player" controls class="w-full" preload="none">
                        <source src="{{ $streamUrl }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>

                <!-- Player Controls -->
                <div class="flex justify-center items-center space-x-4 mb-6">
                    <button id="play-btn" class="bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg transition-all transform hover:scale-105">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </button>
                    <button id="stop-btn" class="bg-gray-600 hover:bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg transition-all transform hover:scale-105">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <!-- Volume Control -->
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <svg class="w-5 h-5 dark:text-dark-text-secondary text-light-text-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"/>
                    </svg>
                    <input type="range" id="volume-control" min="0" max="100" value="75" class="w-48">
                    <span id="volume-display" class="text-sm dark:text-dark-text-secondary text-light-text-secondary w-10">75%</span>
                </div>

                <!-- Popout Button -->
                <div class="text-center">
                    <button onclick="openPopout()" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Open in Popout Window
                    </button>
                </div>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">Stream Not Configured</h3>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    The radio stream URL has not been configured. Please contact an administrator.
                </p>
            </div>
        @endif
    </div>
</div>

@if($streamUrl)
<script>
    const player = document.getElementById('radio-player');
    const playBtn = document.getElementById('play-btn');
    const stopBtn = document.getElementById('stop-btn');
    const volumeControl = document.getElementById('volume-control');
    const volumeDisplay = document.getElementById('volume-display');

    // Icon constants
    const ICON_PLAY = '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>';
    const ICON_PAUSE = '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';

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

    // Open popout window
    function openPopout() {
        window.open('{{ route("radio.popout") }}', 'RadioPopout', 'width=400,height=500,resizable=yes,scrollbars=no');
    }
</script>
@endif
@endsection
