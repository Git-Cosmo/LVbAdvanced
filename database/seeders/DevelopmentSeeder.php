<?php

namespace Database\Seeders;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\News;
use App\Models\User;
use App\Models\User\Gallery;
use App\Models\Event;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding development data...');

        // Create 50 users
        $this->command->info('Creating 50 users...');
        $users = User::factory(50)->create();

        // Get existing categories or create new ones
        $categories = ForumCategory::all();
        if ($categories->count() === 0) {
            $this->command->info('Creating forum categories...');
            $categories = ForumCategory::factory(5)->create();
        }

        // Create 10 forums
        $this->command->info('Creating 10 forums...');
        $forums = [];
        foreach ($categories as $category) {
            $forums = array_merge($forums, Forum::factory(2)->create([
                'category_id' => $category->id,
            ])->all());
        }

        // Create 100 threads with posts
        $this->command->info('Creating 100 threads with posts...');
        $threadsData = [];
        foreach (range(1, 100) as $i) {
            $thread = ForumThread::factory()->create([
                'forum_id' => $forums[array_rand($forums)]->id,
                'user_id' => $users->random()->id,
            ]);

            // Create 3-10 posts per thread
            $postCount = rand(3, 10);
            ForumPost::factory($postCount)->create([
                'thread_id' => $thread->id,
                'user_id' => $users->random()->id,
            ]);

            // Store for bulk update later
            $threadsData[] = ['id' => $thread->id, 'posts_count' => $postCount + 1];
        }

        // Bulk update thread post counts
        foreach ($threadsData as $data) {
            ForumThread::where('id', $data['id'])->update(['posts_count' => $data['posts_count']]);
        }

        // Create 20 news articles
        $this->command->info('Creating 20 news articles...');
        $randomUserIds = $users->random(20)->pluck('id')->toArray();
        foreach (range(0, 19) as $i) {
            News::factory()->create([
                'user_id' => $randomUserIds[$i],
                'is_published' => true,
            ]);
        }

        // Create 15 gallery items
        $this->command->info('Creating 15 gallery items...');
        $randomGalleryUserIds = $users->random(15)->pluck('id')->toArray();
        foreach (range(0, 14) as $i) {
            Gallery::factory()->create([
                'user_id' => $randomGalleryUserIds[$i],
                'is_published' => true,
            ]);
        }

        $this->command->info('✓ Development seeding completed!');
        $this->command->info('  - 50 users created');
        $this->command->info('  - 10 forums created');
        $this->command->info('  - 100 threads with posts created');
        $this->command->info('  - 20 news articles created');
        $this->command->info('  - 15 gallery items created');
    }
}
