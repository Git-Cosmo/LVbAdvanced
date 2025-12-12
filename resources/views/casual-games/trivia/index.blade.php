<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Trivia Games</h1>
            <p class="text-gray-400">Test your knowledge and earn points!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($games as $game)
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-750 transition">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-white">{{ $game->title }}</h3>
                        <span class="px-3 py-1 rounded text-sm
                            @if($game->difficulty == 'easy') bg-green-500/20 text-green-400
                            @elseif($game->difficulty == 'medium') bg-yellow-500/20 text-yellow-400
                            @else bg-red-500/20 text-red-400
                            @endif">
                            {{ ucfirst($game->difficulty) }}
                        </span>
                    </div>

                    <p class="text-gray-400 mb-4">{{ $game->description }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                        <span>🧠 {{ $game->questions_count }} Questions</span>
                        <span>⏱️ {{ $game->time_limit }}s</span>
                        <span>💰 {{ $game->points_reward }} pts</span>
                    </div>

                    <a href="{{ route('casual-games.trivia.show', $game) }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded">
                        Play Now
                    </a>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-400 text-lg">No trivia games available.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $games->links() }}</div>
    </div>
</x-app-layout>
