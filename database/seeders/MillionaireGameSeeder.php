<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MillionaireGame;
use App\Models\MillionaireQuestion;

class MillionaireGameSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default Millionaire game
        $game = MillionaireGame::create([
            'title' => 'Classic Millionaire Challenge',
            'description' => 'Answer 15 questions correctly to win the million! Use your lifelines wisely: 50:50, Phone a Friend, and Ask the Audience.',
            'time_limit' => 600, // 10 minutes
            'is_active' => true,
        ]);

        // Add 15 questions with increasing difficulty and prize amounts
        $questions = [
            // Level 1 - $100
            [
                'difficulty_level' => 1,
                'question' => 'What is the best-selling video game of all time?',
                'option_a' => 'Minecraft',
                'option_b' => 'Grand Theft Auto V',
                'option_c' => 'Tetris',
                'option_d' => 'Fortnite',
                'correct_answer' => 'a',
                'prize_amount' => 100,
            ],
            // Level 2 - $200
            [
                'difficulty_level' => 2,
                'question' => 'Which company developed the game "The Legend of Zelda"?',
                'option_a' => 'Sony',
                'option_b' => 'Nintendo',
                'option_c' => 'Microsoft',
                'option_d' => 'Sega',
                'correct_answer' => 'b',
                'prize_amount' => 200,
            ],
            // Level 3 - $500
            [
                'difficulty_level' => 3,
                'question' => 'What year was the original PlayStation released?',
                'option_a' => '1992',
                'option_b' => '1994',
                'option_c' => '1996',
                'option_d' => '1998',
                'correct_answer' => 'b',
                'prize_amount' => 500,
            ],
            // Level 4 - $1,000
            [
                'difficulty_level' => 4,
                'question' => 'In which game would you find the character "Master Chief"?',
                'option_a' => 'Call of Duty',
                'option_b' => 'Battlefield',
                'option_c' => 'Halo',
                'option_d' => 'Destiny',
                'correct_answer' => 'c',
                'prize_amount' => 1000,
            ],
            // Level 5 - $5,000 (Safe Haven)
            [
                'difficulty_level' => 5,
                'question' => 'What is the name of the main protagonist in "The Witcher 3"?',
                'option_a' => 'Geralt',
                'option_b' => 'Vesemir',
                'option_c' => 'Lambert',
                'option_d' => 'Eskel',
                'correct_answer' => 'a',
                'prize_amount' => 5000,
            ],
            // Level 6 - $10,000
            [
                'difficulty_level' => 6,
                'question' => 'Which game introduced the "Battle Royale" genre to mainstream gaming?',
                'option_a' => 'Fortnite',
                'option_b' => 'PUBG',
                'option_c' => 'Apex Legends',
                'option_d' => 'H1Z1',
                'correct_answer' => 'b',
                'prize_amount' => 10000,
            ],
            // Level 7 - $20,000
            [
                'difficulty_level' => 7,
                'question' => 'What was the first commercially successful video game?',
                'option_a' => 'Space Invaders',
                'option_b' => 'Pong',
                'option_c' => 'Pac-Man',
                'option_d' => 'Asteroids',
                'correct_answer' => 'b',
                'prize_amount' => 20000,
            ],
            // Level 8 - $40,000
            [
                'difficulty_level' => 8,
                'question' => 'Which game won "Game of the Year" at The Game Awards 2018?',
                'option_a' => 'Red Dead Redemption 2',
                'option_b' => 'God of War',
                'option_c' => 'Spider-Man',
                'option_d' => 'Assassin\'s Creed Odyssey',
                'correct_answer' => 'b',
                'prize_amount' => 40000,
            ],
            // Level 9 - $80,000
            [
                'difficulty_level' => 9,
                'question' => 'What programming language was Minecraft originally written in?',
                'option_a' => 'C++',
                'option_b' => 'Python',
                'option_c' => 'Java',
                'option_d' => 'JavaScript',
                'correct_answer' => 'c',
                'prize_amount' => 80000,
            ],
            // Level 10 - $150,000 (Safe Haven)
            [
                'difficulty_level' => 10,
                'question' => 'In League of Legends, what is the maximum level a champion can reach?',
                'option_a' => '18',
                'option_b' => '20',
                'option_c' => '25',
                'option_d' => '30',
                'correct_answer' => 'a',
                'prize_amount' => 150000,
            ],
            // Level 11 - $250,000
            [
                'difficulty_level' => 11,
                'question' => 'Which game engine is used to develop Fortnite?',
                'option_a' => 'Unity',
                'option_b' => 'CryEngine',
                'option_c' => 'Unreal Engine',
                'option_d' => 'Frostbite',
                'correct_answer' => 'c',
                'prize_amount' => 250000,
            ],
            // Level 12 - $500,000
            [
                'difficulty_level' => 12,
                'question' => 'What was the first game to feature a "save game" function?',
                'option_a' => 'The Legend of Zelda',
                'option_b' => 'Super Mario Bros',
                'option_c' => 'Final Fantasy',
                'option_d' => 'Dragon Quest',
                'correct_answer' => 'a',
                'prize_amount' => 500000,
            ],
            // Level 13 - $750,000
            [
                'difficulty_level' => 13,
                'question' => 'Which esports organization has won the most League of Legends World Championships?',
                'option_a' => 'T1 (SKT)',
                'option_b' => 'Fnatic',
                'option_c' => 'G2 Esports',
                'option_d' => 'Edward Gaming',
                'correct_answer' => 'a',
                'prize_amount' => 750000,
            ],
            // Level 14 - $900,000
            [
                'difficulty_level' => 14,
                'question' => 'What is the highest-grossing arcade game of all time?',
                'option_a' => 'Pac-Man',
                'option_b' => 'Space Invaders',
                'option_c' => 'Street Fighter II',
                'option_d' => 'Donkey Kong',
                'correct_answer' => 'a',
                'prize_amount' => 900000,
            ],
            // Level 15 - $1,000,000
            [
                'difficulty_level' => 15,
                'question' => 'In what year was the first International Dota 2 tournament held?',
                'option_a' => '2010',
                'option_b' => '2011',
                'option_c' => '2012',
                'option_d' => '2013',
                'correct_answer' => 'b',
                'prize_amount' => 1000000,
            ],
        ];

        foreach ($questions as $index => $questionData) {
            MillionaireQuestion::create([
                'millionaire_game_id' => $game->id,
                'difficulty_level' => $questionData['difficulty_level'],
                'question' => $questionData['question'],
                'option_a' => $questionData['option_a'],
                'option_b' => $questionData['option_b'],
                'option_c' => $questionData['option_c'],
                'option_d' => $questionData['option_d'],
                'correct_answer' => $questionData['correct_answer'],
                'prize_amount' => $questionData['prize_amount'],
                'order' => $index + 1,
            ]);
        }

        $this->command->info('Millionaire game seeded successfully with 15 questions!');
    }
}
