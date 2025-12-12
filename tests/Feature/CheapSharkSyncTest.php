<?php

namespace Tests\Feature;

use App\Models\CheapSharkDeal;
use App\Models\CheapSharkGame;
use App\Models\CheapSharkSyncLog;
use App\Services\CheapSharkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheapSharkSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_syncs_stores_games_and_deals(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/stores' => Http::response([
                [
                    'storeID' => '1',
                    'storeName' => 'Steam',
                    'isActive' => 1,
                    'images' => ['logo' => '/img/stores/icons/0.png'],
                ],
            ], 200),
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([
                [
                    'dealID' => 'deal-123',
                    'storeID' => '1',
                    'gameID' => '100',
                    'salePrice' => '9.99',
                    'normalPrice' => '19.99',
                    'savings' => '50',
                    'dealRating' => '8.0',
                    'isOnSale' => '1',
                    'steamAppID' => 'abc123',
                ],
            ], 200),
            'https://www.cheapshark.com/api/1.0/games*' => Http::response([
                '100' => [
                    'info' => [
                        'title' => 'Test Game',
                        'thumb' => 'https://cdn.test/game.jpg',
                    ],
                    'cheapestPriceEver' => [
                        'price' => '9.99',
                    ],
                ],
            ], 200),
        ]);

        $service = app(CheapSharkService::class);
        $log = $service->runSync('manual');

        $this->assertEquals('completed', $log->status);
        $this->assertDatabaseCount('cheap_shark_stores', 1);
        $this->assertDatabaseCount('cheap_shark_games', 1);
        $this->assertDatabaseCount('cheap_shark_deals', 1);
        $this->assertDatabaseHas('cheap_shark_deals', [
            'deal_id' => 'deal-123',
            'steam_app_id' => 'abc123',
        ]);

        $game = CheapSharkGame::first();
        $deal = CheapSharkDeal::first();

        $this->assertEquals('Test Game', $game->title);
        $this->assertEquals($game->id, $deal->game_id);
        $this->assertEquals('https://www.cheapshark.com/redirect?dealID=deal-123', $deal->deal_link);
        $this->assertTrue($deal->on_sale);

        $this->assertDatabaseCount('cheap_shark_sync_logs', 1);
        $this->assertEquals('manual', CheapSharkSyncLog::first()->run_type);
    }
}
