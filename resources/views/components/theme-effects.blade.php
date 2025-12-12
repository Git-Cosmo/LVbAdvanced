@php
    $activeTheme = \App\Models\SiteTheme::getActiveTheme();
    $effects = $activeTheme?->effects ?? [];
@endphp

@if($activeTheme)
    {{-- Snowfall Effect --}}
    @if($effects['snow']['enabled'] ?? false)
        <div id="snowfall-container" class="fixed inset-0 pointer-events-none z-50 overflow-hidden">
            <style>
                .snowflake {
                    position: absolute;
                    top: -10px;
                    color: #fff;
                    font-size: {{ ($effects['snow']['intensity'] ?? 'medium') === 'heavy' ? '1.2em' : (($effects['snow']['intensity'] ?? 'medium') === 'light' ? '0.8em' : '1em') }};
                    font-family: Arial, sans-serif;
                    text-shadow: 0 0 5px rgba(255,255,255,0.8);
                    animation: fall linear infinite;
                    opacity: 0.8;
                }
                @keyframes fall {
                    to { transform: translateY(100vh); }
                }
            </style>
        </div>
        <script>
            (function() {
                const intensity = '{{ $effects['snow']['intensity'] ?? 'medium' }}';
                const flakeCount = intensity === 'heavy' ? 100 : (intensity === 'light' ? 30 : 50);
                const container = document.getElementById('snowfall-container');
                
                for (let i = 0; i < flakeCount; i++) {
                    const snowflake = document.createElement('div');
                    snowflake.className = 'snowflake';
                    snowflake.innerHTML = '❄';
                    snowflake.style.left = Math.random() * 100 + '%';
                    snowflake.style.animationDuration = (Math.random() * 3 + 7) + 's';
                    snowflake.style.animationDelay = Math.random() * 5 + 's';
                    container.appendChild(snowflake);
                }
            })();
        </script>
    @endif

    {{-- Christmas Lights Effect --}}
    @if($effects['lights']['enabled'] ?? false)
        <div id="lights-container" class="fixed top-0 left-0 right-0 pointer-events-none z-50 h-16">
            <style>
                .christmas-lights {
                    display: flex;
                    justify-content: space-around;
                    padding: 10px 0;
                }
                .light {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    animation: blink 1.5s infinite;
                    box-shadow: 0 0 10px currentColor;
                }
                .light:nth-child(odd) { animation-delay: 0.75s; }
                @keyframes blink {
                    0%, 49%, 100% { opacity: 1; }
                    50%, 99% { opacity: 0.3; }
                }
            </style>
            <div class="christmas-lights">
                @for($i = 0; $i < 40; $i++)
                    @php
                        $colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
                        $color = $colors[$i % count($colors)];
                    @endphp
                    <div class="light" style="background-color: {{ $color }}; color: {{ $color }};"></div>
                @endfor
            </div>
        </div>
    @endif

    {{-- Confetti Effect --}}
    @if($effects['confetti']['enabled'] ?? false)
        <div id="confetti-container" class="fixed inset-0 pointer-events-none z-50 overflow-hidden">
            <style>
                .confetti {
                    position: absolute;
                    width: 10px;
                    height: 10px;
                    top: -10px;
                    animation: confetti-fall linear infinite;
                }
                @keyframes confetti-fall {
                    to {
                        transform: translateY(100vh) rotate(720deg);
                    }
                }
            </style>
        </div>
        <script>
            (function() {
                const container = document.getElementById('confetti-container');
                const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
                
                for (let i = 0; i < 50; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDuration = (Math.random() * 3 + 3) + 's';
                    confetti.style.animationDelay = Math.random() * 3 + 's';
                    container.appendChild(confetti);
                }
            })();
        </script>
    @endif

    {{-- Fireworks Effect --}}
    @if($effects['fireworks']['enabled'] ?? false)
        <div id="fireworks-container" class="fixed inset-0 pointer-events-none z-50"></div>
        <script>
            (function() {
                const container = document.getElementById('fireworks-container');
                
                function createFirework() {
                    const firework = document.createElement('div');
                    firework.style.position = 'absolute';
                    firework.style.left = Math.random() * window.innerWidth + 'px';
                    firework.style.top = Math.random() * (window.innerHeight / 2) + 'px';
                    firework.style.width = '4px';
                    firework.style.height = '4px';
                    firework.style.borderRadius = '50%';
                    firework.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
                    firework.style.boxShadow = `0 0 10px hsl(${Math.random() * 360}, 100%, 50%)`;
                    
                    container.appendChild(firework);
                    
                    setTimeout(() => firework.remove(), 1000);
                }
                
                setInterval(createFirework, 500);
            })();
        </script>
    @endif
@endif
