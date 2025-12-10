<?php

namespace App\Http\Controllers;

use App\Services\AzuracastService;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function home(AzuracastService $azuracast): View
    {
        $payload = $azuracast->nowPlaying();

        return view('portal.home', [
            'nowPlaying' => $payload['now_playing'] ?? null,
            'upNext' => $payload['playing_next'] ?? null,
            'recentSongs' => array_slice($payload['song_history'] ?? [], 0, 3),
            'stationOnline' => $payload['is_online'] ?? false,
        ]);
    }
}
