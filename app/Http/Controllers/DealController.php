<?php

namespace App\Http\Controllers;

use App\Models\CheapSharkDeal;
use App\Models\CheapSharkGame;
use App\Models\CheapSharkStore;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $storeFilter = $request->string('store')->toString();

        $dealsQuery = CheapSharkDeal::with(['game', 'store']);

        if ($search) {
            $dealsQuery->whereHas('game', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            });
        }

        if ($storeFilter) {
            $dealsQuery->whereHas('store', function ($query) use ($storeFilter) {
                $query->where('cheapshark_id', $storeFilter);
            });
        }

        $deals = $dealsQuery
            ->orderBy('sale_price')
            ->paginate(20)
            ->withQueryString();

        $stores = CheapSharkStore::orderBy('name')->get();

        return view('deals.index', [
            'deals' => $deals,
            'stores' => $stores,
            'search' => $search,
            'storeFilter' => $storeFilter,
        ]);
    }

    public function show(string $slug)
    {
        $game = CheapSharkGame::where('slug', $slug)
            ->with(['deals.store'])
            ->firstOrFail();

        $deals = $game->deals->sortBy('sale_price');
        $bestDeal = $deals->first();

        return view('deals.show', [
            'game' => $game,
            'deals' => $deals,
            'bestDeal' => $bestDeal,
        ]);
    }
}
