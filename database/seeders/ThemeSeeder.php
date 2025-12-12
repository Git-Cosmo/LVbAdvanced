<?php

namespace Database\Seeders;

use App\Models\SiteTheme;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = Carbon::now()->year;

        $themes = [
            [
                'name' => 'Christmas '.$currentYear,
                'slug' => 'christmas-'.$currentYear,
                'description' => 'Festive Christmas theme with falling snow and twinkling lights',
                'start_date' => Carbon::create($currentYear, 12, 20),
                'end_date' => Carbon::create($currentYear, 12, 26),
                'effects' => [
                    'snow' => [
                        'enabled' => true,
                        'intensity' => 'medium',
                    ],
                    'lights' => [
                        'enabled' => true,
                        'color' => 'multicolor',
                        'style' => 'twinkling',
                    ],
                    'confetti' => [
                        'enabled' => false,
                    ],
                    'fireworks' => [
                        'enabled' => false,
                    ],
                ],
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'New Year '.($currentYear + 1),
                'slug' => 'new-year-'.($currentYear + 1),
                'description' => 'Ring in the new year with fireworks and celebration',
                'start_date' => Carbon::create($currentYear, 12, 31),
                'end_date' => Carbon::create($currentYear + 1, 1, 2),
                'effects' => [
                    'snow' => [
                        'enabled' => false,
                    ],
                    'lights' => [
                        'enabled' => false,
                    ],
                    'confetti' => [
                        'enabled' => true,
                        'color' => 'multicolor',
                        'intensity' => 'high',
                    ],
                    'fireworks' => [
                        'enabled' => true,
                        'frequency' => 'high',
                        'colors' => ['gold', 'silver', 'red', 'blue'],
                    ],
                ],
                'priority' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Valentine\'s Day '.($currentYear + 1),
                'slug' => 'valentines-day-'.($currentYear + 1),
                'description' => 'Celebrate love with hearts and pink confetti',
                'start_date' => Carbon::create($currentYear + 1, 2, 13),
                'end_date' => Carbon::create($currentYear + 1, 2, 15),
                'effects' => [
                    'snow' => [
                        'enabled' => false,
                    ],
                    'lights' => [
                        'enabled' => false,
                    ],
                    'confetti' => [
                        'enabled' => true,
                        'color' => 'pink',
                        'shape' => 'hearts',
                        'intensity' => 'medium',
                    ],
                    'fireworks' => [
                        'enabled' => false,
                    ],
                ],
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Easter '.($currentYear + 1),
                'slug' => 'easter-'.($currentYear + 1),
                'description' => 'Spring celebration with pastel confetti',
                'start_date' => Carbon::create($currentYear + 1, 4, 18), // Approximate, adjust as needed
                'end_date' => Carbon::create($currentYear + 1, 4, 21),
                'effects' => [
                    'snow' => [
                        'enabled' => false,
                    ],
                    'lights' => [
                        'enabled' => false,
                    ],
                    'confetti' => [
                        'enabled' => true,
                        'color' => 'pastel',
                        'intensity' => 'light',
                    ],
                    'fireworks' => [
                        'enabled' => false,
                    ],
                ],
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Halloween '.($currentYear + 1),
                'slug' => 'halloween-'.($currentYear + 1),
                'description' => 'Spooky Halloween theme',
                'start_date' => Carbon::create($currentYear + 1, 10, 28),
                'end_date' => Carbon::create($currentYear + 1, 11, 1),
                'effects' => [
                    'snow' => [
                        'enabled' => false,
                    ],
                    'lights' => [
                        'enabled' => true,
                        'color' => 'orange',
                        'style' => 'flickering',
                    ],
                    'confetti' => [
                        'enabled' => false,
                    ],
                    'fireworks' => [
                        'enabled' => false,
                    ],
                ],
                'priority' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($themes as $theme) {
            SiteTheme::updateOrCreate(
                ['slug' => $theme['slug']],
                $theme
            );
        }

        $this->command->info('Seasonal themes seeded successfully!');
    }
}
