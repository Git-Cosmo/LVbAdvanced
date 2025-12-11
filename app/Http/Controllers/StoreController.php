<?php

namespace App\Http\Controllers;

use App\Helpers\CheapSharkHelper;
use App\Models\CheapSharkStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $sortBy = $request->string('sort', 'name')->toString();
        $filterActive = $request->boolean('active', false);

        $storesQuery = CheapSharkStore::withCount('deals');

        // Apply search filter
        if ($search) {
            $storesQuery->where('name', 'like', '%' . $search . '%');
        }

        // Apply active filter
        if ($filterActive) {
            $storesQuery->where('is_active', true);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'deals':
                $storesQuery->orderByDesc('deals_count');
                break;
            case 'name':
            default:
                $storesQuery->orderBy('name');
                break;
        }

        $stores = $storesQuery->paginate(24)->withQueryString();

        // Transform stores to include logo URLs using helper
        $stores->getCollection()->transform(function ($store) {
            $store->logo_url = CheapSharkHelper::logoUrl($store->logo);
            return $store;
        });

        // Calculate stats from the full dataset using a single optimized query with conditional aggregation
        $statsQuery = CheapSharkStore::query()
            ->selectRaw('COUNT(*) as total_stores')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_stores')
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->when($filterActive, fn($q) => $q->where('is_active', true));

        $stats = $statsQuery->first();
        $totalStores = $stats->total_stores ?? 0;
        $activeStores = $stats->active_stores ?? 0;

        // Calculate total deals with a separate query (join needed)
        $totalDeals = CheapSharkStore::query()
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->when($filterActive, fn($q) => $q->where('is_active', true))
            ->leftJoin('cheap_shark_deals', 'cheap_shark_stores.id', '=', 'cheap_shark_deals.store_id')
            ->count('cheap_shark_deals.id');

        return view('stores.index', [
            'stores' => $stores,
            'search' => $search,
            'sortBy' => $sortBy,
            'filterActive' => $filterActive,
            'totalStores' => $totalStores,
            'activeStores' => $activeStores,
            'totalDeals' => $totalDeals,
        ]);
    }
}
