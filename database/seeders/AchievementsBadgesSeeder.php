<?php

namespace Database\Seeders;

use App\Models\User\UserAchievement;
use App\Models\User\UserBadge;
use Illuminate\Database\Seeder;

class AchievementsBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Achievements
        $achievements = [
            [
                'name' => 'First Steps',
                'slug' => 'first-steps',
                'description' => 'Create your first post',
                'icon' => '👣',
                'points' => 10,
                'criteria' => ['type' => 'posts', 'count' => 1],
                'is_active' => true,
            ],
            [
                'name' => 'Getting Started',
                'slug' => 'getting-started',
                'description' => 'Reach level 5',
                'icon' => '🎯',
                'points' => 50,
                'criteria' => ['type' => 'level', 'count' => 5],
                'is_active' => true,
            ],
            [
                'name' => 'Conversation Starter',
                'slug' => 'conversation-starter',
                'description' => 'Create 10 threads',
                'icon' => '💬',
                'points' => 100,
                'criteria' => ['type' => 'threads', 'count' => 10],
                'is_active' => true,
            ],
            [
                'name' => 'Prolific Poster',
                'slug' => 'prolific-poster',
                'description' => 'Make 100 posts',
                'icon' => '📝',
                'points' => 200,
                'criteria' => ['type' => 'posts', 'count' => 100],
                'is_active' => true,
            ],
            [
                'name' => 'Forum Legend',
                'slug' => 'forum-legend',
                'description' => 'Make 1000 posts',
                'icon' => '👑',
                'points' => 1000,
                'criteria' => ['type' => 'posts', 'count' => 1000],
                'is_active' => true,
            ],
            [
                'name' => 'Well Liked',
                'slug' => 'well-liked',
                'description' => 'Receive 100 reactions',
                'icon' => '❤️',
                'points' => 150,
                'criteria' => ['type' => 'reactions', 'count' => 100],
                'is_active' => true,
            ],
            [
                'name' => 'Karma King',
                'slug' => 'karma-king',
                'description' => 'Reach 1000 karma',
                'icon' => '🌟',
                'points' => 500,
                'criteria' => ['type' => 'karma', 'count' => 1000],
                'is_active' => true,
            ],
            [
                'name' => 'Veteran',
                'slug' => 'veteran',
                'description' => 'Member for 1 year',
                'icon' => '🎖️',
                'points' => 300,
                'criteria' => ['type' => 'days', 'count' => 365],
                'is_active' => true,
            ],
            [
                'name' => 'Level 10',
                'slug' => 'level-10',
                'description' => 'Reach level 10',
                'icon' => '🔟',
                'points' => 100,
                'criteria' => ['type' => 'level', 'count' => 10],
                'is_active' => true,
            ],
            [
                'name' => 'Level 25',
                'slug' => 'level-25',
                'description' => 'Reach level 25',
                'icon' => '🚀',
                'points' => 250,
                'criteria' => ['type' => 'level', 'count' => 25],
                'is_active' => true,
            ],
            [
                'name' => 'Level 50',
                'slug' => 'level-50',
                'description' => 'Reach level 50',
                'icon' => '💎',
                'points' => 500,
                'criteria' => ['type' => 'level', 'count' => 50],
                'is_active' => true,
            ],
            [
                'name' => 'Level 100',
                'slug' => 'level-100',
                'description' => 'Reach level 100',
                'icon' => '💯',
                'points' => 1000,
                'criteria' => ['type' => 'level', 'count' => 100],
                'is_active' => true,
            ],
            [
                'name' => 'Helpful Member',
                'slug' => 'helpful-member',
                'description' => 'Have 50 posts marked as helpful',
                'icon' => '🤝',
                'points' => 200,
                'criteria' => ['type' => 'helpful', 'count' => 50],
                'is_active' => true,
            ],
            [
                'name' => 'Tournament Winner',
                'slug' => 'tournament-winner',
                'description' => 'Win a gaming tournament',
                'icon' => '🏆',
                'points' => 500,
                'criteria' => ['type' => 'tournament_wins', 'count' => 1],
                'is_active' => true,
            ],
            [
                'name' => 'Clan Leader',
                'slug' => 'clan-leader',
                'description' => 'Create and lead a gaming clan',
                'icon' => '⚔️',
                'points' => 300,
                'criteria' => ['type' => 'clan_leader', 'count' => 1],
                'is_active' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            UserAchievement::create($achievement);
        }

        // Create Badges
        $badges = [
            [
                'name' => 'Founder',
                'slug' => 'founder',
                'description' => 'One of the original members',
                'icon' => '🌟',
                'is_active' => true,
            ],
            [
                'name' => 'Staff Member',
                'slug' => 'staff-member',
                'description' => 'Community staff member',
                'icon' => '👮',
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'description' => 'Community moderator',
                'icon' => '🛡️',
                'is_active' => true,
            ],
            [
                'name' => 'VIP',
                'slug' => 'vip',
                'description' => 'VIP member',
                'icon' => '💎',
                'is_active' => true,
            ],
            [
                'name' => 'Developer',
                'slug' => 'developer',
                'description' => 'Platform developer',
                'icon' => '💻',
                'is_active' => true,
            ],
            [
                'name' => 'Bug Hunter',
                'slug' => 'bug-hunter',
                'description' => 'Reported critical bugs',
                'icon' => '🐛',
                'is_active' => true,
            ],
            [
                'name' => 'Content Creator',
                'slug' => 'content-creator',
                'description' => 'Creates quality content',
                'icon' => '🎨',
                'is_active' => true,
            ],
            [
                'name' => 'Tournament Organizer',
                'slug' => 'tournament-organizer',
                'description' => 'Organizes community tournaments',
                'icon' => '🎮',
                'is_active' => true,
            ],
            [
                'name' => 'Clan Champion',
                'slug' => 'clan-champion',
                'description' => 'Champion of their clan',
                'icon' => '⚔️',
                'is_active' => true,
            ],
            [
                'name' => 'Supporter',
                'slug' => 'supporter',
                'description' => 'Supports the community',
                'icon' => '💖',
                'is_active' => true,
            ],
            [
                'name' => 'Beta Tester',
                'slug' => 'beta-tester',
                'description' => 'Participated in beta testing',
                'icon' => '🧪',
                'is_active' => true,
            ],
            [
                'name' => 'Event Winner',
                'slug' => 'event-winner',
                'description' => 'Won a community event',
                'icon' => '🏅',
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badge) {
            UserBadge::create($badge);
        }

        $this->command->info('Achievements and badges seeded successfully!');
    }
}
