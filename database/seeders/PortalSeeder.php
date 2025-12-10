<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create homepage
        $homepage = \App\Models\Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'description' => 'Welcome to the vBadvanced Portal',
            'meta_title' => 'Home - vBadvanced Portal',
            'meta_description' => 'Modern Laravel-based portal system inspired by vBadvanced CMPS',
            'layout' => 'default',
            'is_active' => true,
            'is_homepage' => true,
            'order' => 0,
        ]);

        // Create sample blocks
        
        // Welcome Block (Custom HTML)
        $welcomeBlock = \App\Models\Block::create([
            'name' => 'Welcome Message',
            'type' => 'custom_html',
            'title' => 'Welcome to vBadvanced Portal',
            'show_title' => true,
            'content' => '<div class="prose max-w-none">
                <p class="text-lg">Welcome to our modern Laravel-based portal system, inspired by the classic vBadvanced CMPS.</p>
                <p>This system features a modular, block-based architecture that allows you to easily customize your homepage and pages.</p>
                <ul class="mt-4">
                    <li>Drag-and-drop block positioning</li>
                    <li>Multiple layout options</li>
                    <li>Powerful caching system</li>
                    <li>Role-based visibility</li>
                    <li>Extensible block types</li>
                </ul>
            </div>',
            'cache_lifetime' => 60,
            'is_active' => true,
        ]);

        \App\Models\BlockPosition::create([
            'block_id' => $welcomeBlock->id,
            'page_id' => null, // All pages
            'position' => 'center',
            'order' => 1,
            'is_active' => true,
        ]);

        // Latest News Block
        $newsBlock = \App\Models\Block::create([
            'name' => 'Latest News',
            'type' => 'latest_news',
            'title' => 'Latest News',
            'show_title' => true,
            'config' => [
                'limit' => 5,
                'show_date' => true,
                'show_author' => true,
            ],
            'cache_lifetime' => 30,
            'is_active' => true,
        ]);

        \App\Models\BlockPosition::create([
            'block_id' => $newsBlock->id,
            'page_id' => null,
            'position' => 'left',
            'order' => 1,
            'is_active' => true,
        ]);

        // Stats Block
        $statsBlock = \App\Models\Block::create([
            'name' => 'Site Statistics',
            'type' => 'stats',
            'title' => 'Site Stats',
            'show_title' => true,
            'cache_lifetime' => 15,
            'is_active' => true,
        ]);

        \App\Models\BlockPosition::create([
            'block_id' => $statsBlock->id,
            'page_id' => null,
            'position' => 'right',
            'order' => 1,
            'is_active' => true,
        ]);

        // Quick Links Block
        $linksBlock = \App\Models\Block::create([
            'name' => 'Quick Links',
            'type' => 'link_list',
            'title' => 'Quick Links',
            'show_title' => true,
            'config' => [
                'links' => [
                    [
                        'title' => 'Laravel Documentation',
                        'url' => 'https://laravel.com/docs',
                        'target' => '_blank',
                    ],
                    [
                        'title' => 'Tailwind CSS',
                        'url' => 'https://tailwindcss.com',
                        'target' => '_blank',
                    ],
                    [
                        'title' => 'Spatie Packages',
                        'url' => 'https://spatie.be/open-source',
                        'target' => '_blank',
                    ],
                ],
            ],
            'is_active' => true,
        ]);

        \App\Models\BlockPosition::create([
            'block_id' => $linksBlock->id,
            'page_id' => null,
            'position' => 'right',
            'order' => 2,
            'is_active' => true,
        ]);

        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create admin role
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $admin->assignRole($adminRole);

        $this->command->info('Portal seeded successfully!');
        $this->command->info('Admin credentials: admin@example.com / password');
    }
}
