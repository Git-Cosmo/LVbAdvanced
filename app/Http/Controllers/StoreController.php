<?php

namespace App\Http\Controllers;

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

        // Calculate stats from the full dataset (not just current page)
        $baseStatsQuery = CheapSharkStore::query();
        if ($search) {
            $baseStatsQuery->where('name', 'like', '%' . $search . '%');
        }

        // Calculate total stores and active stores in one query
        $totalStores = (clone $baseStatsQuery)->count();
        $activeStores = (clone $baseStatsQuery)->where('is_active', true)->count();

        // Calculate total deals using a join and sum aggregate
        $totalDeals = (clone $baseStatsQuery)
            ->leftJoin('cheap_shark_deals', 'cheap_shark_stores.id', '=', 'cheap_shark_deals.store_id')
            ->count('cheap_shark_deals.id');

        // Apply the active filter after stats calculation if needed
        if ($filterActive) {
            $totalStores = $activeStores;
            $totalDeals = CheapSharkStore::query()
                ->where('is_active', true)
                ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
                ->leftJoin('cheap_shark_deals', 'cheap_shark_stores.id', '=', 'cheap_shark_deals.store_id')
                ->count('cheap_shark_deals.id');
        }

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
