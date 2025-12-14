<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GeoguessrGame;
use App\Models\GeoguessrLocation;

class GeoguessrGameSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default GeoGuessr game
        $game = GeoguessrGame::create([
            'title' => 'World Famous Gaming Landmarks',
            'description' => 'Guess the locations of famous landmarks and places from the gaming world! The closer you are, the more points you earn.',
            'num_rounds' => 5,
            'time_per_round' => 60, // 1 minute per round
            'max_points_per_round' => 1000,
            'difficulty_rating' => 3,
            'is_active' => true,
        ]);

        // Add iconic gaming locations
        $locations = [
            [
                'name' => 'Tokyo Tower (Shibuya District)',
                'image_url' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800',
                'latitude' => 35.6586,
                'longitude' => 139.7454,
                'hint' => 'Famous landmark in Japan\'s capital, often featured in RPGs and anime-style games',
                'description' => 'The iconic Tokyo Tower in Shibuya, featured in countless Japanese games',
                'difficulty' => 2,
            ],
            [
                'name' => 'Golden Gate Bridge',
                'image_url' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=800',
                'latitude' => 37.8199,
                'longitude' => -122.4783,
                'hint' => 'Red suspension bridge in California, featured in Watch Dogs 2 and GTA San Andreas',
                'description' => 'San Francisco\'s famous bridge, setting for many open-world games',
                'difficulty' => 1,
            ],
            [
                'name' => 'Eiffel Tower',
                'image_url' => 'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f?w=800',
                'latitude' => 48.8584,
                'longitude' => 2.2945,
                'hint' => 'Iconic iron tower in France, featured in many European-set games',
                'description' => 'Paris landmark frequently appearing in FPS and adventure games',
                'difficulty' => 1,
            ],
            [
                'name' => 'Big Ben & Westminster',
                'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=800',
                'latitude' => 51.5007,
                'longitude' => -0.1246,
                'hint' => 'Famous clock tower in London, featured in Assassin\'s Creed Syndicate',
                'description' => 'London\'s iconic clock tower, a staple in British-themed games',
                'difficulty' => 2,
            ],
            [
                'name' => 'Times Square',
                'image_url' => 'https://images.unsplash.com/photo-1560707303-4e980ce876ad?w=800',
                'latitude' => 40.7580,
                'longitude' => -73.9855,
                'hint' => 'Famous intersection in Manhattan, featured in Spider-Man games',
                'description' => 'NYC\'s bright lights district, setting for superhero and crime games',
                'difficulty' => 2,
            ],
            [
                'name' => 'Colosseum',
                'image_url' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800',
                'latitude' => 41.8902,
                'longitude' => 12.4922,
                'hint' => 'Ancient Roman amphitheater, featured in Assassin\'s Creed Brotherhood',
                'description' => 'Rome\'s ancient arena, backdrop for historical action games',
                'difficulty' => 2,
            ],
            [
                'name' => 'Statue of Liberty',
                'image_url' => 'https://images.unsplash.com/photo-1543716627-839b54c40519?w=800',
                'latitude' => 40.6892,
                'longitude' => -74.0445,
                'hint' => 'Famous green statue in New York Harbor, featured in GTA IV',
                'description' => 'Liberty Island monument, iconic in American-themed games',
                'difficulty' => 1,
            ],
            [
                'name' => 'Sydney Opera House',
                'image_url' => 'https://images.unsplash.com/photo-1523059623039-a9ed027e7fad?w=800',
                'latitude' => -33.8568,
                'longitude' => 151.2153,
                'hint' => 'Distinctive shell-shaped building in Australia',
                'description' => 'Sydney\'s architectural masterpiece, featured in racing and flight games',
                'difficulty' => 2,
            ],
            [
                'name' => 'Mount Fuji',
                'image_url' => 'https://images.unsplash.com/photo-1578271887552-94387ce4ca10?w=800',
                'latitude' => 35.3606,
                'longitude' => 138.7274,
                'hint' => 'Japan\'s highest mountain, frequently seen in racing games',
                'description' => 'Sacred mountain in Japan, backdrop for many JRPGs',
                'difficulty' => 3,
            ],
            [
                'name' => 'Great Wall of China',
                'image_url' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?w=800',
                'latitude' => 40.4319,
                'longitude' => 116.5704,
                'hint' => 'Ancient fortification visible from space',
                'description' => 'Historic Chinese wall, featured in strategy and historical games',
                'difficulty' => 2,
            ],
        ];

        foreach ($locations as $index => $locationData) {
            GeoguessrLocation::create([
                'geoguessr_game_id' => $game->id,
                'name' => $locationData['name'],
                'image_url' => $locationData['image_url'],
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'hint' => $locationData['hint'],
                'description' => $locationData['description'],
                'difficulty' => $locationData['difficulty'],
                'order' => $index + 1,
            ]);
        }

        $this->command->info('GeoGuessr game seeded successfully with 10 locations!');
    }
}
