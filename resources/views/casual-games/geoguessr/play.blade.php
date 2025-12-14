@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Location Image -->
        <div class="lg:col-span-2">
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-4 mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold dark:text-dark-text-bright">Round {{ $currentRound }} of {{ $game->rounds }}</h2>
                    <span class="text-sm dark:text-dark-text-tertiary">Score: {{ $attempt->total_score }}</span>
                </div>
                
                <img src="{{ $location->image_url }}" alt="Location" class="w-full rounded-lg mb-4">
                
                <p class="text-sm dark:text-dark-text-secondary mb-4">Where is this location? Click on the map to make your guess.</p>
                
                <!-- Simplified Map Placeholder -->
                <div id="map" class="w-full h-96 bg-gray-800 rounded-lg flex items-center justify-center">
                    <p class="dark:text-dark-text-secondary">Click anywhere on this map to guess the location</p>
                </div>

                <button onclick="submitGuess()" 
                        id="submit-btn"
                        disabled
                        class="mt-4 w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold disabled:opacity-50">
                    Submit Guess
                </button>
            </div>
        </div>

        <!-- Stats Sidebar -->
        <div class="lg:col-span-1">
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 sticky top-4">
                <h3 class="font-semibold dark:text-dark-text-bright mb-4">Progress</h3>
                <div class="space-y-4">
                    @for($i = 1; $i <= $game->rounds; $i++)
                        <div class="flex items-center justify-between p-3 rounded {{ $i === $currentRound ? 'bg-green-500/20 border border-green-500' : ($i < $currentRound ? 'dark:bg-dark-bg-tertiary' : 'dark:bg-dark-bg-primary') }}">
                            <span class="dark:text-dark-text-bright">Round {{ $i }}</span>
                            @if($i < $currentRound)
                                <span class="text-green-500">✓</span>
                            @elseif($i === $currentRound)
                                <span class="text-yellow-500">●</span>
                            @else
                                <span class="dark:text-dark-text-tertiary">-</span>
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="mt-6 pt-6 border-t dark:border-dark-border-primary">
                    <div class="text-center">
                        <div class="text-sm dark:text-dark-text-tertiary mb-1">Total Score</div>
                        <div class="text-3xl font-bold text-green-500">{{ $attempt->total_score }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let guessLat = null;
let guessLng = null;

// Toast notification function
function showToast(message, type = 'success') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 z-50 max-w-sm';
    toast.innerHTML = `
        <div class="${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'} rounded-lg shadow-lg p-4 text-white">
            <p>${message}</p>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Simplified map click handler (would use Google Maps or Leaflet in production)
document.getElementById('map').addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // Convert to rough lat/lng (simplified for demo)
    guessLat = 90 - (y / rect.height * 180);
    guessLng = -180 + (x / rect.width * 360);
    
    this.innerHTML = `<div class="text-green-500 font-semibold">📍 Guess placed at ${guessLat.toFixed(2)}, ${guessLng.toFixed(2)}</div>`;
    document.getElementById('submit-btn').disabled = false;
});

function submitGuess() {
    if (guessLat === null || guessLng === null) return;
    
    fetch('{{ route('casual-games.geoguessr.guess', [$game, $attempt]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            location_id: {{ $location->id }},
            guess_lat: guessLat,
            guess_lng: guessLng
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast(`Distance: ${data.distance}km | Score: ${data.score} | Total: ${data.total_score}`, 'success');
        setTimeout(() => {
            if (data.rounds_completed >= {{ $game->rounds }}) {
                window.location.href = '{{ route('casual-games.geoguessr.result', [$game, $attempt]) }}';
            } else {
                window.location.reload();
            }
        }, 2000);
    });
}
</script>
@endsection
