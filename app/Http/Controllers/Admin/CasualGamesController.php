<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TriviaGame;
use App\Models\Prediction;
use App\Models\DailyChallenge;
use App\Models\TournamentBet;
use Illuminate\Http\Request;

class CasualGamesController extends Controller
{
    public function index()
    {
        $triviaCount = TriviaGame::count();
        $predictionsCount = Prediction::count();
        $challengesCount = DailyChallenge::count();
        $betsCount = TournamentBet::count();

        return view('admin.casual-games.index', [
            'triviaCount' => $triviaCount,
            'predictionsCount' => $predictionsCount,
            'challengesCount' => $challengesCount,
            'betsCount' => $betsCount,
            'page' => (object) ['title' => 'Casual Games Management'],
        ]);
    }
}
