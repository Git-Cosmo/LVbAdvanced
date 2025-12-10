<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AzuracastService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AzuracastServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.azuracast.base_url' => 'https://radio.test',
            'services.azuracast.api_key' => 'test-key',
            'services.azuracast.station_id' => 1,
        ]);
    }

    public function test_it_fetches_now_playing_payload(): void
    {
        Http::fake([
            'https://radio.test/api/nowplaying/1' => Http::response([
                'now_playing' => ['song' => ['title' => 'Current Song']],
                'playing_next' => ['song' => ['title' => 'Next Song']],
                'song_history' => [
                    ['song' => ['title' => 'Previous Song']],
                ],
                'is_online' => true,
            ], 200),
        ]);

        $payload = app(AzuracastService::class)->nowPlaying();

        $this->assertSame('Current Song', $payload['now_playing']['song']['title']);
        $this->assertSame('Next Song', $payload['playing_next']['song']['title']);
        $this->assertCount(1, $payload['song_history']);
        $this->assertTrue($payload['is_online']);
    }

    public function test_it_logs_song_request_attempts(): void
    {
        Http::fake([
            'https://radio.test/api/station/1/request/*' => Http::sequence()
                ->push(['message' => 'Request queued'], 200)
                ->push(['error' => 'Invalid request'], 422),
        ]);

        $user = User::factory()->create();

        $service = app(AzuracastService::class);

        $success = $service->requestSong('abc123', $user->id);
        $failed = $service->requestSong('bad123');

        $this->assertEquals('success', $success->status);
        $this->assertNotNull($success->created_at);
        $this->assertDatabaseHas('azuracast_requests', [
            'user_id' => $user->id,
            'request_id' => 'abc123',
            'status' => 'success',
            'api_response_message' => 'Request queued',
        ]);

        $this->assertEquals('failed', $failed->status);
        $this->assertDatabaseHas('azuracast_requests', [
            'user_id' => null,
            'request_id' => 'bad123',
            'status' => 'failed',
            'api_response_message' => 'Invalid request',
        ]);
    }
}
