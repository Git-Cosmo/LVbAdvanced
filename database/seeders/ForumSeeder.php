<?php

namespace Database\Seeders;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumCategory;
use App\Models\User\UserProfile;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user profiles for existing users
        \App\Models\User::all()->each(function ($user) {
            if (! $user->profile) {
                UserProfile::create([
                    'user_id' => $user->id,
                    'xp' => 0,
                    'level' => 1,
                    'karma' => 0,
                ]);
            }
        });

        // Create General Category
        $general = ForumCategory::create([
            'name' => 'General Discussion',
            'slug' => 'general-discussion',
            'description' => 'General topics and community discussions',
            'order' => 1,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $general->id,
            'name' => 'Announcements',
            'slug' => 'announcements',
            'description' => 'Important announcements and news',
            'order' => 1,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $general->id,
            'name' => 'General Chat',
            'slug' => 'general-chat',
            'description' => 'General discussion about anything and everything',
            'order' => 2,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $general->id,
            'name' => 'Introductions',
            'slug' => 'introductions',
            'description' => 'Introduce yourself to the community',
            'order' => 3,
            'is_active' => true,
        ]);

        // Create Gaming Category
        $gaming = ForumCategory::create([
            'name' => 'Gaming',
            'slug' => 'gaming',
            'description' => 'All things gaming related',
            'order' => 2,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $gaming->id,
            'name' => 'PC Gaming',
            'slug' => 'pc-gaming',
            'description' => 'Discuss PC games, hardware, and builds',
            'order' => 1,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $gaming->id,
            'name' => 'Console Gaming',
            'slug' => 'console-gaming',
            'description' => 'Xbox, PlayStation, Nintendo, and more',
            'order' => 2,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $gaming->id,
            'name' => 'Mobile Gaming',
            'slug' => 'mobile-gaming',
            'description' => 'iOS and Android games',
            'order' => 3,
            'is_active' => true,
        ]);

        // Create Community Category
        $community = ForumCategory::create([
            'name' => 'Community',
            'slug' => 'community',
            'description' => 'Community events and activities',
            'order' => 3,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $community->id,
            'name' => 'Events & Tournaments',
            'slug' => 'events-tournaments',
            'description' => 'Community events and gaming tournaments',
            'order' => 1,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $community->id,
            'name' => 'Clans & Guilds',
            'slug' => 'clans-guilds',
            'description' => 'Find or recruit for gaming clans and guilds',
            'order' => 2,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $community->id,
            'name' => 'Off-Topic',
            'slug' => 'off-topic',
            'description' => 'Anything goes! (within reason)',
            'order' => 3,
            'is_active' => true,
        ]);

        // Create Support Category
        $support = ForumCategory::create([
            'name' => 'Support',
            'slug' => 'support',
            'description' => 'Get help and support',
            'order' => 4,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $support->id,
            'name' => 'Help & Support',
            'slug' => 'help-support',
            'description' => 'Need help? Ask here!',
            'order' => 1,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $support->id,
            'name' => 'Bug Reports',
            'slug' => 'bug-reports',
            'description' => 'Report bugs and issues',
            'order' => 2,
            'is_active' => true,
        ]);

        Forum::create([
            'category_id' => $support->id,
            'name' => 'Suggestions',
            'slug' => 'suggestions',
            'description' => 'Share your ideas and suggestions',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
