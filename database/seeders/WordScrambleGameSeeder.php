<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WordScrambleGame;
use App\Models\WordScrambleWord;

class WordScrambleGameSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default Word Scramble game
        $game = WordScrambleGame::create([
            'title' => 'Gaming Word Challenge',
            'slug' => 'gaming-word-challenge',
            'description' => 'Unscramble popular gaming-related words! Test your knowledge of games, characters, streamers, and more. Solve quickly for bonus points!',
            'time_limit' => 300, // 5 minutes total
            'points_per_word' => 10,
            'hint_penalty' => 5,
            'is_active' => true,
        ]);

        // Add 45+ popular gaming words
        $words = [
            // Games
            ['word' => 'Minecraft', 'hint' => 'Blocky sandbox survival game', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Fortnite', 'hint' => 'Battle royale with building mechanics', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Valorant', 'hint' => 'Riot\'s tactical shooter', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Overwatch', 'hint' => 'Team-based hero shooter', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'League', 'hint' => 'Popular MOBA by Riot', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'DOTA', 'hint' => 'Valve\'s MOBA classic', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'CSGO', 'hint' => 'Counter-Strike tactical shooter', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'PUBG', 'hint' => 'PlayerUnknown\'s battle royale', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Apex', 'hint' => 'Respawn\'s battle royale', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Warzone', 'hint' => 'Call of Duty battle royale', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Roblox', 'hint' => 'User-generated game platform', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Terraria', 'hint' => '2D sandbox adventure', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Warcraft', 'hint' => 'Blizzard\'s RTS series', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'StarCraft', 'hint' => 'Sci-fi RTS by Blizzard', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Hearthstone', 'hint' => 'Digital card game', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Skyrim', 'hint' => 'Elder Scrolls open-world RPG', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Zelda', 'hint' => 'Nintendo adventure series', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Pokemon', 'hint' => 'Catch \'em all RPG', 'category' => 'game', 'difficulty' => 1],
            ['word' => 'Diablo', 'hint' => 'Action RPG with loot', 'category' => 'game', 'difficulty' => 2],
            ['word' => 'Cyberpunk', 'hint' => 'Futuristic RPG by CDPR', 'category' => 'game', 'difficulty' => 2],
            
            // Characters
            ['word' => 'Mario', 'hint' => 'Nintendo\'s plumber mascot', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'Sonic', 'hint' => 'Blue hedgehog speedster', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'Pikachu', 'hint' => 'Electric mouse Pokemon', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'Kratos', 'hint' => 'God of War protagonist', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'Chief', 'hint' => 'Master ___, Halo hero', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'Link', 'hint' => 'Hero of Hyrule', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'Tracer', 'hint' => 'Time-traveling Overwatch hero', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'Lara', 'hint' => '___ Croft, tomb raider', 'category' => 'character', 'difficulty' => 1],
            ['word' => 'Samus', 'hint' => 'Metroid bounty hunter', 'category' => 'character', 'difficulty' => 2],
            ['word' => 'Geralt', 'hint' => 'White-haired Witcher', 'category' => 'character', 'difficulty' => 2],
            
            // Streamers
            ['word' => 'Ninja', 'hint' => 'Blue-haired Fortnite streamer', 'category' => 'streamer', 'difficulty' => 1],
            ['word' => 'Shroud', 'hint' => 'FPS accuracy legend', 'category' => 'streamer', 'difficulty' => 2],
            ['word' => 'Pokimane', 'hint' => 'Popular variety streamer', 'category' => 'streamer', 'difficulty' => 2],
            ['word' => 'Ludwig', 'hint' => 'Chess boxing host', 'category' => 'streamer', 'difficulty' => 2],
            ['word' => 'xQcOW', 'hint' => 'High-energy variety streamer', 'category' => 'streamer', 'difficulty' => 2],
            
            // Esports Teams
            ['word' => 'Fnatic', 'hint' => 'Orange and black esports org', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'Liquid', 'hint' => 'Team ___, blue horse logo', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'Cloud9', 'hint' => 'Cloud ___, blue/white team', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'FaZe', 'hint' => '___ Clan, red esports team', 'category' => 'esports_team', 'difficulty' => 2],
            ['word' => 'Sentinels', 'hint' => 'Valorant champions 2021', 'category' => 'esports_team', 'difficulty' => 3],
            
            // Platforms
            ['word' => 'Steam', 'hint' => 'PC gaming storefront by Valve', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'Epic', 'hint' => '___ Games Store', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'Xbox', 'hint' => 'Microsoft console', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'PlayStation', 'hint' => 'Sony gaming console', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'Discord', 'hint' => 'Gamer voice chat platform', 'category' => 'platform', 'difficulty' => 1],
            ['word' => 'Twitch', 'hint' => 'Purple streaming platform', 'category' => 'platform', 'difficulty' => 1],
            
            // Weapons
            ['word' => 'Shotgun', 'hint' => 'Close-range spread weapon', 'category' => 'weapon', 'difficulty' => 1],
            ['word' => 'Sniper', 'hint' => 'Long-range precision rifle', 'category' => 'weapon', 'difficulty' => 1],
            ['word' => 'Rifle', 'hint' => 'Standard assault weapon', 'category' => 'weapon', 'difficulty' => 1],
            ['word' => 'Pistol', 'hint' => 'Basic handgun', 'category' => 'weapon', 'difficulty' => 1],
            ['word' => 'Grenade', 'hint' => 'Throwable explosive', 'category' => 'weapon', 'difficulty' => 1],
            
            // Maps
            ['word' => 'Dust', 'hint' => '___ 2, iconic CS map', 'category' => 'map', 'difficulty' => 2],
            ['word' => 'Mirage', 'hint' => 'CS:GO desert map', 'category' => 'map', 'difficulty' => 2],
            ['word' => 'Haven', 'hint' => 'Valorant three-site map', 'category' => 'map', 'difficulty' => 2],
            ['word' => 'Bind', 'hint' => 'Valorant teleporter map', 'category' => 'map', 'difficulty' => 2],
        ];

        foreach ($words as $wordData) {
            WordScrambleWord::create([
                'word_scramble_game_id' => $game->id,
                'word' => $wordData['word'],
                'hint' => $wordData['hint'],
                'category' => $wordData['category'],
                'difficulty' => $wordData['difficulty'],
            ]);
        }

        $this->command->info('Word Scramble game seeded successfully with ' . count($words) . ' words!');
    }
}
