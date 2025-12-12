<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FPSociety Radio - Popout Player</title>
    @vite(['resources/css/app.css'])
    <style>
        body {
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .player-card {
            backdrop-filter: blur(20px);
            background: rgba(0, 0, 0, 0.4);
        }
        .artwork-container {
            position: relative;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .track-info-scroll {
            animation: scroll-text 10s linear infinite;
        }
        @keyframes scroll-text {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>
<body class="dark:bg-dark-bg-primary bg-light-bg-primary dark:text-dark-text-primary text-light-text-primary">
    <div class="h-screen flex flex-col p-6">
        <!-- Sleek Header -->
        <div class="player-card rounded-2xl p-4 mb-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-white">FPSociety Radio</h1>
                        <p class="text-xs text-white/70">Live Stream</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-semibold uppercase rounded-full {{ $stationOnline ?? false ? 'bg-emerald-500/30 text-white' : 'bg-rose-500/30 text-white' }}">
                    {{ $stationOnline ?? false ? '● Live' : '○ Offline' }}
                </span>
            </div>
        </div>

        @if($streamUrl)
            <!-- Now Playing Card -->
            <div class="flex-1 flex flex-col items-center justify-center">
                <!-- Album Artwork -->
                <div class="artwork-container w-48 h-48 mb-6">
                    @if($nowPlaying && isset($nowPlaying['now_playing']['song']['art']))
                        <img src="{{ $nowPlaying['now_playing']['song']['art'] }}" alt="Album Art" class="w-full h-full rounded-2xl shadow-2xl object-cover border-4 border-white/20">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-accent-blue to-accent-purple rounded-2xl shadow-2xl flex items-center justify-center border-4 border-white/20">
                            <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Track Info -->
                <div class="text-center mb-6 px-4 w-full max-w-xs">
                    @if($nowPlaying && isset($nowPlaying['now_playing']['song']))
                        <p class="text-xs uppercase tracking-wide text-white/60 mb-2">Now Playing</p>
                        <h2 class="font-bold text-white text-lg mb-1 truncate">
                            {{ $nowPlaying['now_playing']['song']['title'] ?? 'Unknown Track' }}
                        </h2>
                        <p class="text-sm text-white/80 truncate">
                            {{ $nowPlaying['now_playing']['song']['artist'] ?? 'Unknown Artist' }}
                        </p>
                        @if(isset($nowPlaying['now_playing']['song']['album']))
                            <p class="text-xs text-white/60 mt-1 truncate">
                                {{ $nowPlaying['now_playing']['song']['album'] }}
                            </p>
                        @endif
                    @else
                        <p class="text-sm text-white/80 text-center" id="now-playing">
                            Waiting for track info...
                        </p>
                    @endif
                </div>
            </div>

            <!-- Modern Player Controls -->
            <div class="player-card rounded-2xl p-6 shadow-2xl border border-white/10">
                <!-- Audio Element -->
                <audio id="radio-player" preload="none" class="hidden">
                    <source src="{{ $streamUrl }}" type="audio/mpeg">
                </audio>

                <!-- Control Buttons -->
                <div class="flex justify-center items-center space-x-4 mb-6">
                    <button id="play-btn" class="bg-white hover:bg-white/90 text-purple-600 rounded-full w-16 h-16 flex items-center justify-center shadow-2xl transition-all transform hover:scale-105">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </button>
                    <button id="stop-btn" class="bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg transition-all backdrop-blur">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <!-- Volume Control -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs text-white/60">
                        <span>Volume</span>
                        <span id="volume-display" class="font-semibold text-white">75%</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-white/70 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217z" clip-rule="evenodd"/>
                        </svg>
                        <input type="range" id="volume-control" min="0" max="100" value="75" 
                               class="flex-1 h-2 bg-white/20 rounded-lg appearance-none cursor-pointer accent-white">
                        <svg class="w-5 h-5 text-white/70 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center">
                <div class="player-card rounded-2xl p-8 text-center border border-white/10">
                    <svg class="w-16 h-16 mx-auto mb-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-white/70">
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

        // Icon constants with updated sizes
        const ICON_PLAY = '<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>';
        const ICON_PAUSE = '<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';

        // Set initial volume
        player.volume = 0.75;

        // Play button with smooth transitions
        playBtn.addEventListener('click', () => {
            if (player.paused) {
                player.play();
                playBtn.innerHTML = ICON_PAUSE;
                playBtn.classList.add('scale-95');
                setTimeout(() => playBtn.classList.remove('scale-95'), 150);
            } else {
                player.pause();
                playBtn.innerHTML = ICON_PLAY;
                playBtn.classList.add('scale-95');
                setTimeout(() => playBtn.classList.remove('scale-95'), 150);
            }
        });

        // Stop button with smooth transitions
        stopBtn.addEventListener('click', () => {
            player.pause();
            player.currentTime = 0;
            playBtn.innerHTML = ICON_PLAY;
            stopBtn.classList.add('scale-95');
            setTimeout(() => stopBtn.classList.remove('scale-95'), 150);
        });

        // Volume control with smooth updates
        volumeControl.addEventListener('input', (e) => {
            const volume = e.target.value / 100;
            player.volume = volume;
            volumeDisplay.textContent = e.target.value + '%';
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Prevent shortcuts when typing in input or textarea fields
            const tag = document.activeElement && document.activeElement.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA') return;
            
            if (e.code === 'Space') {
                e.preventDefault();
                playBtn.click();
            } else if (e.code === 'ArrowUp') {
                e.preventDefault();
                const newVolume = Math.min(100, parseInt(volumeControl.value) + 5);
                volumeControl.value = newVolume;
                volumeControl.dispatchEvent(new Event('input'));
            } else if (e.code === 'ArrowDown') {
                e.preventDefault();
                const newVolume = Math.max(0, parseInt(volumeControl.value) - 5);
                volumeControl.value = newVolume;
                volumeControl.dispatchEvent(new Event('input'));
            }
        });
    </script>
    @endif
</body>
</html>
