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

        return view('stores.index', [
            'stores' => $stores,
            'search' => $search,
            'sortBy' => $sortBy,
            'filterActive' => $filterActive,
        ]);
    }
}
