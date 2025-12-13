<?php

namespace Tests\Feature;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create();
    }

    public function test_announcement_can_be_created(): void
    {
        $announcement = Announcement::create([
            'title' => 'Test Announcement',
            'message' => 'This is a test announcement',
            'source' => 'website',
            'user_id' => $this->admin->id,
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('announcements', [
            'title' => 'Test Announcement',
            'message' => 'This is a test announcement',
            'source' => 'website',
        ]);

        $this->assertEquals($this->admin->id, $announcement->user_id);
        $this->assertTrue($announcement->isFromWebsite());
        $this->assertFalse($announcement->isFromDiscord());
    }

    public function test_announcement_created_event_is_dispatched(): void
    {
        Event::fake();

        $announcement = Announcement::create([
            'title' => 'Test Announcement',
            'message' => 'This is a test announcement',
            'source' => 'website',
            'user_id' => $this->admin->id,
            'published_at' => now(),
        ]);

        event(new AnnouncementCreated($announcement));

        Event::assertDispatched(AnnouncementCreated::class, function ($event) use ($announcement) {
            return $event->announcement->id === $announcement->id;
        });
    }

    public function test_announcement_scopes_work(): void
    {
        // Create published announcement
        Announcement::create([
            'title' => 'Published Announcement',
            'message' => 'This is published',
            'source' => 'website',
            'published_at' => now(),
        ]);

        // Create unpublished announcement
        Announcement::create([
            'title' => 'Draft Announcement',
            'message' => 'This is a draft',
            'source' => 'website',
            'published_at' => null,
        ]);

        $this->assertEquals(1, Announcement::published()->count());
        $this->assertEquals(2, Announcement::recent()->count());
    }

    public function test_announcement_belongs_to_user(): void
    {
        $announcement = Announcement::create([
            'title' => 'Test Announcement',
            'message' => 'This is a test',
            'source' => 'website',
            'user_id' => $this->admin->id,
        ]);

        $this->assertInstanceOf(User::class, $announcement->user);
        $this->assertEquals($this->admin->id, $announcement->user->id);
    }

    public function test_announcement_can_be_from_discord(): void
    {
        $announcement = Announcement::create([
            'title' => 'Discord Announcement',
            'message' => 'From Discord',
            'source' => 'discord',
            'discord_message_id' => '123456789',
            'discord_channel_id' => '987654321',
            'metadata' => [
                'author_id' => '111111111',
                'author_username' => 'DiscordUser',
            ],
        ]);

        $this->assertTrue($announcement->isFromDiscord());
        $this->assertFalse($announcement->isFromWebsite());
        $this->assertEquals('123456789', $announcement->discord_message_id);
        $this->assertArrayHasKey('author_username', $announcement->metadata);
    }
}
