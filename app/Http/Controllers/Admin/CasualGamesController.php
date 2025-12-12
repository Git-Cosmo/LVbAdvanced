<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyChallenge;
use App\Models\Prediction;
use App\Models\TournamentBet;
use App\Models\TriviaGame;

class CasualGamesController extends Controller
{
    public function index()
    {
        $stats = [
            'trivia_count' => TriviaGame::count(),
            'predictions_count' => Prediction::where('status', 'open')->count(),
            'challenges_count' => DailyChallenge::count(),
            'bets_count' => TournamentBet::count(),
            'total_points_awarded' => 0, // TODO: Calculate from ledger
            'total_points_spent' => 0, // TODO: Calculate from ledger
            'points_circulation' => 0, // TODO: Calculate from ledger
            'active_players' => 0, // TODO: Calculate unique users in last 7 days
            'total_plays' => 0, // TODO: Sum of all game plays
            'avg_engagement_time' => '0m', // TODO: Calculate average
        ];

        return view('admin.casual-games.index', [
            'stats' => $stats,
            'recentActivity' => [], // TODO: Get recent activity
        ]);
    }
}
