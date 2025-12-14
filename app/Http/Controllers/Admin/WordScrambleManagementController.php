<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WordScrambleGame;
use App\Models\WordScrambleWord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WordScrambleManagementController extends Controller
{
    public function index()
    {
        $games = WordScrambleGame::withCount('words', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.word-scramble.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Word Scramble Games'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.word-scramble.create', [
            'page' => (object) ['title' => 'Create Word Scramble Game'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_per_word' => 'required|integer|min:10|max:120',
            'words_per_game' => 'required|integer|min:5|max:50',
            'hint_penalty' => 'required|integer|min:0|max:20',
            'points_per_word' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        WordScrambleGame::create($validated);

        return redirect()->route('admin.casual-games.word-scramble.index')
            ->with('success', 'Word Scramble game created successfully!');
    }

    public function edit(WordScrambleGame $wordScrambleGame)
    {
        $wordScrambleGame->load('words');

        return view('admin.casual-games.word-scramble.edit', [
            'game' => $wordScrambleGame,
            'page' => (object) ['title' => 'Edit: ' . $wordScrambleGame->title],
        ]);
    }

    public function update(Request $request, WordScrambleGame $wordScrambleGame)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_per_word' => 'required|integer|min:10|max:120',
            'words_per_game' => 'required|integer|min:5|max:50',
            'hint_penalty' => 'required|integer|min:0|max:20',
            'points_per_word' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        $wordScrambleGame->update($validated);

        return redirect()->route('admin.casual-games.word-scramble.index')
            ->with('success', 'Word Scramble game updated successfully!');
    }

    public function destroy(WordScrambleGame $wordScrambleGame)
    {
        $wordScrambleGame->delete();

        return redirect()->route('admin.casual-games.word-scramble.index')
            ->with('success', 'Word Scramble game deleted successfully!');
    }

    public function addWord(Request $request, WordScrambleGame $wordScrambleGame)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:50',
            'hint' => 'nullable|string|max:255',
            'category' => 'required|string|in:game,character,streamer,esports_team,platform,weapon,map',
            'difficulty_level' => 'required|integer|min:1|max:3',
        ]);

        $validated['word_scramble_game_id'] = $wordScrambleGame->id;
        $validated['order'] = $wordScrambleGame->words()->count();

        WordScrambleWord::create($validated);

        return redirect()->route('admin.casual-games.word-scramble.edit', $wordScrambleGame)
            ->with('success', 'Word added successfully!');
    }

    public function deleteWord(WordScrambleGame $wordScrambleGame, WordScrambleWord $word)
    {
        $word->delete();

        return redirect()->route('admin.casual-games.word-scramble.edit', $wordScrambleGame)
            ->with('success', 'Word deleted successfully!');
    }

    public function seedPopularWords(WordScrambleGame $wordScrambleGame)
    {
        $popularWords = $this->getPopularGamingWords();
        
        foreach ($popularWords as $wordData) {
            WordScrambleWord::create([
                'word_scramble_game_id' => $wordScrambleGame->id,
                'word' => $wordData['word'],
                'hint' => $wordData['hint'],
                'category' => $wordData['category'],
                'difficulty_level' => $wordData['difficulty'],
                'order' => $wordScrambleGame->words()->count(),
            ]);
        }

        return redirect()->route('admin.casual-games.word-scramble.edit', $wordScrambleGame)
            ->with('success', 'Seeded ' . count($popularWords) . ' popular gaming words!');
    }

    private function getPopularGamingWords()
    {
        return [
            // Popular Games
            ['word' => 'MINECRAFT', 'hint' => 'Block-building sandbox game', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'FORTNITE', 'hint' => 'Battle royale with building mechanics', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'VALORANT', 'hint' => 'Riot\'s tactical shooter', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'OVERWATCH', 'hint' => 'Team-based hero shooter', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'APEX', 'hint' => 'Legends battle royale', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'WARZONE', 'hint' => 'Call of Duty battle royale', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'LEAGUE', 'hint' => 'MOBA of Legends', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'DOTA', 'hint' => 'Defense of the Ancients', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'CSGO', 'hint' => 'Counter Strike version', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'PUBG', 'hint' => 'Original battle royale', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'ROBLOX', 'hint' => 'Platform for user-created games', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'TERRARIA', 'hint' => '2D sandbox adventure', 'category' => 'game', 'difficulty' => 3],
            ['word' => 'WARCRAFT', 'hint' => 'World of fantasy MMORPG', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'STARCRAFT', 'hint' => 'Blizzard\'s RTS game', 'category' => 'game', 'difficulty' => 3],
            ['word' => 'HEARTHSTONE', 'hint' => 'Digital card game', 'category' => 'game', 'difficulty' => 3],
            
            // Popular Characters
            ['word' => 'MARIO', 'hint' => 'Nintendo\'s plumber', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'SONIC', 'hint' => 'Blue hedgehog speedster', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'PIKACHU', 'hint' => 'Electric mouse Pokemon', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'KRATOS', 'hint' => 'God of War protagonist', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'MASTERCHIEF', 'hint' => 'Halo\'s Spartan soldier', 'category' => 'character', 'difficulty' => 3],
            ['word' => 'LINK', 'hint' => 'Zelda hero with sword', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'TRACER', 'hint' => 'Overwatch time-bending hero', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'EZIO', 'hint' => 'Assassin\'s Creed assassin', 'category' => 'character', 'difficulty' => 2],
            
            // Popular Streamers/Content Creators
            ['word' => 'NINJA', 'hint' => 'Fortnite streaming legend', 'category' => 'streamer', 'difficulty' => 1],
            ['word' => 'SHROUD', 'hint' => 'FPS god streamer', 'category' => 'streamer', 'difficulty' => 1],
            ['word' => 'POKIMANE', 'hint' => 'Popular variety streamer', 'category' => 'streamer', 'difficulty' => 2],
            ['word' => 'LUDWIG', 'hint' => 'Chess and variety creator', 'category' => 'streamer', 'difficulty' => 2],
            ['word' => 'XQCOW', 'hint' => 'High-energy variety streamer', 'category' => 'streamer', 'difficulty' => 2],
            
            // Esports Teams
            ['word' => 'FNATIC', 'hint' => 'European esports org', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'LIQUID', 'hint' => 'Team with horse logo', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'CLOUD', 'hint' => '___ Nine esports team', 'category' => 'esports_team', 'difficulty' => 1],
            ['word' => 'FAZE', 'hint' => 'Content creation esports org', 'category' => 'esports_team', 'difficulty' => 1],
            
            // Gaming Platforms
            ['word' => 'STEAM', 'hint' => 'Valve\'s PC gaming platform', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'EPIC', 'hint' => '___ Games Store', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'XBOX', 'hint' => 'Microsoft\'s console', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'PLAYSTATION', 'hint' => 'Sony\'s gaming console', 'category' => 'platform', 'difficulty' => 3],
            ['word' => 'DISCORD', 'hint' => 'Gaming communication app', 'category' => 'platform', 'difficulty' => 2],
            ['word' => 'TWITCH', 'hint' => 'Live streaming platform', 'category' => 'platform', 'difficulty' => 1],
            
            // Weapons/Items
            ['word' => 'SHOTGUN', 'hint' => 'Close-range powerhouse', 'category' => 'weapon', 'difficulty' => 2],
            ['word' => 'SNIPER', 'hint' => 'Long-range precision weapon', 'category' => 'weapon', 'difficulty' => 2],
            ['word' => 'PISTOL', 'hint' => 'Basic sidearm', 'category' => 'weapon', 'difficulty' => 2],
            ['word' => 'GRENADE', 'hint' => 'Explosive throwable', 'category' => 'weapon', 'difficulty' => 2],
            
            // Maps
            ['word' => 'DUST', 'hint' => 'CS:GO classic map', 'category' => 'map', 'difficulty' => 1],
            ['word' => 'MIRAGE', 'hint' => 'CS:GO desert map', 'category' => 'map', 'difficulty' => 2],
            ['word' => 'HAVEN', 'hint' => 'Valorant three-site map', 'category' => 'map', 'difficulty' => 2],
        ];
    }
}
