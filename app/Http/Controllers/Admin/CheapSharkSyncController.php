<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheapSharkDeal;
use App\Models\CheapSharkGame;
use App\Models\CheapSharkStore;
use App\Models\CheapSharkSyncLog;
use App\Services\CheapSharkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheapSharkSyncController extends Controller
{
    public function index(): View
    {
        $logs = CheapSharkSyncLog::latest()->limit(15)->get();

        return view('admin.deals.index', [
            'storesCount' => CheapSharkStore::count(),
            'gamesCount' => CheapSharkGame::count(),
            'dealsCount' => CheapSharkDeal::count(),
            'lastLog' => $logs->first(),
            'logs' => $logs,
        ]);
    }

    public function sync(CheapSharkService $cheapSharkService): RedirectResponse
    {
        $log = $cheapSharkService->runSync('manual');

        $statusMessage = $log->status === 'completed'
            ? 'CheapShark sync completed successfully.'
            : 'CheapShark sync failed: ' . ($log->message ?? 'Unknown error');

        return redirect()
            ->route('admin.deals.index')
            ->with('status', $statusMessage);
    }
}
