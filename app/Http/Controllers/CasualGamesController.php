<?php

namespace App\Http\Controllers;

use App\Models\TriviaGame;
use App\Models\TriviaAttempt;
use App\Models\Prediction;
use App\Models\PredictionEntry;
use App\Models\DailyChallenge;
use App\Models\TournamentBet;
use Illuminate\Http\Request;

class CasualGamesController extends Controller
{
    public function index()
    {
        $triviaGames = TriviaGame::active()->latest()->take(6)->get();
        $predictions = Prediction::open()->latest()->take(6)->get();
        $dailyChallenges = DailyChallenge::today()->get();
        $activeBets = null;

        if (auth()->check()) {
            $activeBets = TournamentBet::where('user_id', auth()->id())
                ->pending()
                ->with('tournament', 'participant')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('casual-games.index', [
            'triviaGames' => $triviaGames,
            'predictions' => $predictions,
            'dailyChallenges' => $dailyChallenges,
            'activeBets' => $activeBets,
            'page' => (object) [
                'title' => 'Casual Games - FPSociety',
                'meta_title' => 'Casual Games | FPSociety',
                'meta_description' => 'Play trivia, make predictions, complete daily challenges, and bet on tournaments.',
            ],
        ]);
    }

    // Trivia
    public function triviaIndex()
    {
        $games = TriviaGame::active()
            ->withCount('questions')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('casual-games.trivia.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Trivia Games'],
        ]);
    }

    public function triviaShow(TriviaGame $triviaGame)
    {
        $triviaGame->load('questions');
        
        $userAttempt = null;
        if (auth()->check()) {
            $userAttempt = TriviaAttempt::where('user_id', auth()->id())
                ->where('trivia_game_id', $triviaGame->id)
                ->first();
        }

        return view('casual-games.trivia.show', [
            'game' => $triviaGame,
            'userAttempt' => $userAttempt,
            'page' => (object) ['title' => $triviaGame->title],
        ]);
    }

    public function triviaSubmit(Request $request, TriviaGame $triviaGame)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'time_taken' => 'nullable|integer',
        ]);

        $questions = $triviaGame->questions;
        $correctCount = 0;
        $score = 0;

        foreach ($questions as $index => $question) {
            $userAnswer = $validated['answers'][$question->id] ?? null;
            if ($userAnswer == $question->correct_answer_index) {
                $correctCount++;
                $score += $question->points;
            }
        }

        $attempt = TriviaAttempt::create([
            'user_id' => auth()->id(),
            'trivia_game_id' => $triviaGame->id,
            'score' => $score,
            'correct_answers' => $correctCount,
            'total_questions' => $questions->count(),
            'time_taken' => $validated['time_taken'] ?? null,
            'answers' => $validated['answers'],
            'completed_at' => now(),
        ]);

        // Award points to user profile
        if (auth()->user()->profile) {
            auth()->user()->profile->increment('points', $score);
        }

        return redirect()->route('casual-games.trivia.result', $attempt)
            ->with('success', 'Quiz submitted! You scored ' . $score . ' points!');
    }

    public function triviaResult(TriviaAttempt $attempt)
    {
        $this->authorize('view', $attempt);
        
        $attempt->load('triviaGame.questions');

        return view('casual-games.trivia.result', [
            'attempt' => $attempt,
            'page' => (object) ['title' => 'Quiz Results'],
        ]);
    }

    // Predictions
    public function predictionsIndex()
    {
        $openPredictions = Prediction::open()->latest()->paginate(12);
        $resolvedPredictions = Prediction::resolved()->latest()->paginate(12);

        return view('casual-games.predictions.index', [
            'openPredictions' => $openPredictions,
            'resolvedPredictions' => $resolvedPredictions,
            'page' => (object) ['title' => 'Predictions'],
        ]);
    }

    public function predictionShow(Prediction $prediction)
    {
        $prediction->loadCount('entries');
        
        $userEntry = null;
        if (auth()->check()) {
            $userEntry = PredictionEntry::where('user_id', auth()->id())
                ->where('prediction_id', $prediction->id)
                ->first();
        }

        // Calculate vote distribution
        $distribution = [];
        if ($prediction->entries_count > 0) {
            $entries = $prediction->entries()
                ->selectRaw('selected_option_index, count(*) as count')
                ->groupBy('selected_option_index')
                ->get();
            
            foreach ($entries as $entry) {
                $distribution[$entry->selected_option_index] = $entry->count;
            }
        }

        return view('casual-games.predictions.show', [
            'prediction' => $prediction,
            'userEntry' => $userEntry,
            'distribution' => $distribution,
            'page' => (object) ['title' => $prediction->title],
        ]);
    }

    public function predictionSubmit(Request $request, Prediction $prediction)
    {
        if ($prediction->status !== 'open' || $prediction->closes_at < now()) {
            return back()->with('error', 'This prediction is no longer accepting entries.');
        }

        $validated = $request->validate([
            'selected_option_index' => 'required|integer|min:0',
        ]);

        PredictionEntry::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'prediction_id' => $prediction->id,
            ],
            [
                'selected_option_index' => $validated['selected_option_index'],
            ]
        );

        return back()->with('success', 'Your prediction has been recorded!');
    }

    // Daily Challenges
    public function challengesIndex()
    {
        $todayChallenges = DailyChallenge::today()->get();
        
        $completedIds = [];
        if (auth()->check()) {
            $completedIds = auth()->user()->profile->custom_fields['completed_challenges'] ?? [];
        }

        return view('casual-games.challenges.index', [
            'challenges' => $todayChallenges,
            'completedIds' => $completedIds,
            'page' => (object) ['title' => 'Daily Challenges'],
        ]);
    }
}
