<?php

namespace App\Services;

use App\Models\CheapSharkDeal;
use App\Models\CheapSharkGame;
use App\Models\CheapSharkStore;
use App\Models\CheapSharkSyncLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheapSharkService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.cheapshark.base_url', 'https://www.cheapshark.com/api/1.0'), '/');
    }

    public function runSync(string $runType = 'manual'): CheapSharkSyncLog
    {
        $log = CheapSharkSyncLog::create([
            'status' => 'running',
            'run_type' => $runType,
            'started_at' => now(),
        ]);

        try {
            $result = $this->syncLatestDeals();

            $log->fill([
                'status' => 'completed',
                'stores_synced' => $result['stores'],
                'games_synced' => $result['games'],
                'deals_synced' => $result['deals'],
                'message' => $result['message'],
            ]);
        } catch (\Throwable $e) {
            Log::error('CheapShark sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $log->fill([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }

        $log->finished_at = now();
        $log->save();

        return $log;
    }

    public function syncLatestDeals(): array
    {
        $storesSynced = $this->syncStores();
        $storeMap = CheapSharkStore::where('is_active', true)->pluck('id', 'cheapshark_id');

        $dealsResponse = $this->collectDeals($storeMap->keys()->toArray());
        $gameMap = $this->syncGames($dealsResponse['game_ids']);

        $dealsSynced = $this->syncDeals($dealsResponse['deals'], $storeMap, $gameMap);

        return [
            'stores' => $storesSynced,
            'games' => count($gameMap),
            'deals' => $dealsSynced,
            'message' => sprintf(
                'Synced %s stores, %s games, %s deals',
                $storesSynced,
                count($gameMap),
                $dealsSynced
            ),
        ];
    }

    protected function syncStores(): int
    {
        $response = Http::timeout(15)->get($this->endpoint('/stores'));

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch CheapShark stores');
        }

        $stores = collect($response->json());

        $payload = $stores->map(function (array $store) {
            return [
                'cheapshark_id' => $store['storeID'],
                'name' => $store['storeName'] ?? $store['storeID'],
                'is_active' => (bool) ($store['isActive'] ?? true),
                'logo' => $store['images']['logo'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();

        if (!empty($payload)) {
            CheapSharkStore::upsert(
                $payload,
                ['cheapshark_id'],
                ['name', 'is_active', 'logo', 'updated_at']
            );
        }

        return $stores->count();
    }

    protected function collectDeals(array $storeExternalIds): array
    {
        $deals = [];
        $gameIds = [];

        foreach ($storeExternalIds as $externalId) {
            $response = Http::timeout(20)->get($this->endpoint('/deals'), [
                'storeID' => $externalId,
            ]);

            if ($response->failed()) {
                Log::warning('CheapShark deals fetch failed for store', ['store_id' => $externalId]);
                continue;
            }

            foreach (($response->json() ?? []) as $deal) {
                if (empty($deal['gameID'])) {
                    continue;
                }

                $deals[] = array_merge($deal, ['store_external_id' => $externalId]);
                $gameIds[] = $deal['gameID'];
            }
        }

        return [
            'deals' => $deals,
            'game_ids' => array_values(array_unique($gameIds)),
        ];
    }

    protected function syncGames(array $gameIds): array
    {
        if (empty($gameIds)) {
            return [];
        }

        $records = [];
        foreach (array_chunk($gameIds, 50) as $chunk) {
            $response = Http::timeout(20)->get($this->endpoint('/games'), [
                'ids' => implode(',', $chunk),
            ]);

            if ($response->failed()) {
                Log::warning('CheapShark games fetch failed for chunk', ['ids' => $chunk]);
                continue;
            }

            foreach (($response->json() ?? []) as $id => $game) {
                $info = $game['info'] ?? [];
                $title = $info['title'] ?? 'Unknown Game';
                $slug = Str::slug($title) . '-' . $id;

                $records[] = [
                    'cheapshark_id' => (string) $id,
                    'title' => $title,
                    'slug' => $slug,
                    'thumbnail' => $info['thumb'] ?? null,
                    'cheapest_price' => isset($game['cheapestPriceEver']['price'])
                        ? (float) $game['cheapestPriceEver']['price']
                        : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($records)) {
            CheapSharkGame::upsert(
                $records,
                ['cheapshark_id'],
                ['title', 'slug', 'thumbnail', 'cheapest_price', 'updated_at']
            );
        }

        return CheapSharkGame::whereIn('cheapshark_id', $gameIds)
            ->pluck('id', 'cheapshark_id')
            ->toArray();
    }

    protected function syncDeals(array $deals, Collection $storeMap, array $gameMap): int
    {
        if (empty($deals)) {
            return 0;
        }

        $records = [];
        foreach ($deals as $deal) {
            $gameKey = (string) ($deal['gameID'] ?? '');
            $storeKey = (string) ($deal['store_external_id'] ?? '');

            if (!isset($gameMap[$gameKey]) || !$storeMap->has($storeKey)) {
                continue;
            }

            $onSaleFlag = $deal['isOnSale'] ?? $deal['onSale'] ?? false;

            $records[] = [
                'deal_id' => $deal['dealID'],
                'store_id' => $storeMap[$storeKey],
                'game_id' => $gameMap[$gameKey],
                'sale_price' => (float) ($deal['salePrice'] ?? 0),
                'normal_price' => (float) ($deal['normalPrice'] ?? 0),
                'savings' => isset($deal['savings']) ? round((float) $deal['savings'], 2) : null,
                'deal_rating' => $deal['dealRating'] ?? null,
                'steam_app_id' => $deal['steamAppID'] ?? null,
                'on_sale' => filter_var($onSaleFlag, FILTER_VALIDATE_BOOLEAN),
                'deal_link' => isset($deal['dealID']) ? 'https://www.cheapshark.com/redirect?dealID=' . $deal['dealID'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($records)) {
            CheapSharkDeal::upsert(
                $records,
                ['deal_id'],
                [
                    'store_id',
                    'game_id',
                    'sale_price',
                    'normal_price',
                    'savings',
                    'deal_rating',
                    'steam_app_id',
                    'on_sale',
                    'deal_link',
                    'updated_at',
                ]
            );
        }

        return count($records);
    }

    protected function endpoint(string $path): string
    {
        return rtrim($this->baseUrl, '/') . $path;
    }
}
