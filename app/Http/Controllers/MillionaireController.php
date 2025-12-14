<?php

namespace App\Http\Controllers;

use App\Models\MillionaireAttempt;
use App\Models\MillionaireGame;
use Illuminate\Http\Request;

class MillionaireController extends Controller
{
    public function index()
    {
        $games = MillionaireGame::active()
            ->withCount('questions')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('casual-games.millionaire.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Who Wants To Be A Millionaire'],
        ]);
    }

    public function show(MillionaireGame $millionaireGame)
    {
        $millionaireGame->load(['questions' => function ($query) {
            $query->orderBy('order');
        }]);

        $userAttempt = null;
        if (auth()->check()) {
            $userAttempt = MillionaireAttempt::where('user_id', auth()->id())
                ->where('millionaire_game_id', $millionaireGame->id)
                ->where('status', 'in_progress')
                ->first();
        }

        return view('casual-games.millionaire.show', [
            'game' => $millionaireGame,
            'userAttempt' => $userAttempt,
            'page' => (object) ['title' => $millionaireGame->title],
        ]);
    }

    public function start(MillionaireGame $millionaireGame)
    {
        // Check if user has an active attempt
        $existingAttempt = MillionaireAttempt::where('user_id', auth()->id())
            ->where('millionaire_game_id', $millionaireGame->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('casual-games.millionaire.play', [$millionaireGame, $existingAttempt]);
        }

        // Create new attempt
        $attempt = MillionaireAttempt::create([
            'user_id' => auth()->id(),
            'millionaire_game_id' => $millionaireGame->id,
            'current_question' => 1,
            'prize_won' => 0,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('casual-games.millionaire.play', [$millionaireGame, $attempt]);
    }

    public function play(MillionaireGame $millionaireGame, MillionaireAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('casual-games.millionaire.result', [$millionaireGame, $attempt]);
        }

        $millionaireGame->load('questions');
        $currentQuestion = $millionaireGame->questions->where('difficulty_level', $attempt->current_question)->first();

        if (!$currentQuestion) {
            // Game completed successfully
            $attempt->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Award points
            if (auth()->user()->profile) {
                auth()->user()->profile->increment('points', $attempt->prize_won);
            }

            return redirect()->route('casual-games.millionaire.result', [$millionaireGame, $attempt]);
        }

        return view('casual-games.millionaire.play', [
            'game' => $millionaireGame,
            'attempt' => $attempt,
            'question' => $currentQuestion,
            'page' => (object) ['title' => 'Playing: '.$millionaireGame->title],
        ]);
    }

    public function answer(Request $request, MillionaireGame $millionaireGame, MillionaireAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        if ($attempt->status !== 'in_progress') {
            return response()->json(['error' => 'Game is not in progress'], 400);
        }

        $validated = $request->validate([
            'answer' => 'required|integer|min:0|max:3',
        ]);

        $millionaireGame->load('questions');
        $currentQuestion = $millionaireGame->questions->where('difficulty_level', $attempt->current_question)->first();

        if (!$currentQuestion) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $isCorrect = $validated['answer'] == $currentQuestion->correct_answer_index;

        // Update answers history
        $answers = $attempt->answers ?? [];
        $answers[$attempt->current_question] = [
            'question_id' => $currentQuestion->id,
            'answer' => $validated['answer'],
            'correct' => $isCorrect,
        ];

        if ($isCorrect) {
            // Correct answer - move to next question
            $attempt->update([
                'current_question' => $attempt->current_question + 1,
                'prize_won' => $currentQuestion->prize_amount,
                'answers' => $answers,
            ]);

            return response()->json([
                'correct' => true,
                'prize_won' => $currentQuestion->prize_amount,
                'next_question' => $attempt->current_question,
            ]);
        } else {
            // Wrong answer - game over
            $finalPrize = $this->calculateSafePrize($attempt->current_question, $attempt->prize_won);
            $attempt->update([
                'status' => 'failed',
                'prize_won' => $finalPrize,
                'answers' => $answers,
                'completed_at' => now(),
            ]);

            // Award points (if any)
            if ($finalPrize > 0 && auth()->user()->profile) {
                auth()->user()->profile->increment('points', $finalPrize);
            }

            return response()->json([
                'correct' => false,
                'game_over' => true,
                'final_prize' => $finalPrize,
            ]);
        }
    }

    public function walkAway(MillionaireGame $millionaireGame, MillionaireAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('casual-games.millionaire.result', [$millionaireGame, $attempt]);
        }

        $attempt->update([
            'status' => 'walked_away',
            'completed_at' => now(),
        ]);

        // Award points
        if ($attempt->prize_won > 0 && auth()->user()->profile) {
            auth()->user()->profile->increment('points', $attempt->prize_won);
        }

        return redirect()->route('casual-games.millionaire.result', [$millionaireGame, $attempt])
            ->with('success', 'You walked away with $'.number_format($attempt->prize_won).'!');
    }

    public function useLifeline(Request $request, MillionaireGame $millionaireGame, MillionaireAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        $validated = $request->validate([
            'lifeline' => 'required|in:fifty_fifty,phone_friend,ask_audience',
        ]);

        if (!$attempt->hasLifeline($validated['lifeline'])) {
            return response()->json(['error' => 'Lifeline already used'], 400);
        }

        $millionaireGame->load('questions');
        $currentQuestion = $millionaireGame->questions->where('difficulty_level', $attempt->current_question)->first();

        $attempt->useLifeline($validated['lifeline']);

        $result = match ($validated['lifeline']) {
            'fifty_fifty' => $this->fiftyFifty($currentQuestion),
            'phone_friend' => $this->phoneFriend($currentQuestion),
            'ask_audience' => $this->askAudience($currentQuestion),
        };

        return response()->json($result);
    }

    public function result(MillionaireGame $millionaireGame, MillionaireAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        return view('casual-games.millionaire.result', [
            'game' => $millionaireGame,
            'attempt' => $attempt,
            'page' => (object) ['title' => 'Game Results'],
        ]);
    }

    private function calculateSafePrize($currentLevel, $currentPrize)
    {
        // Safe havens at questions 5 and 10
        if ($currentLevel <= 5) {
            return 0;
        } elseif ($currentLevel <= 10) {
            return 1000; // Prize for question 5
        } else {
            return 32000; // Prize for question 10
        }
    }

    private function fiftyFifty($question)
    {
        $correctIndex = $question->correct_answer_index;
        $indices = [0, 1, 2, 3];
        $remove = array_diff($indices, [$correctIndex]);
        $remove = array_values($remove);
        shuffle($remove);
        $toRemove = array_slice($remove, 0, 2);

        return [
            'type' => 'fifty_fifty',
            'remove_indices' => $toRemove,
        ];
    }

    private const PHONE_FRIEND_WRONG_CHANCE = 20;
    private const PHONE_FRIEND_MIN_CONFIDENCE = 40;
    private const PHONE_FRIEND_MAX_CONFIDENCE = 60;
    private const PHONE_FRIEND_CORRECT_MIN_CONFIDENCE = 70;
    private const PHONE_FRIEND_CORRECT_MAX_CONFIDENCE = 95;
    
    private const AUDIENCE_MIN_CORRECT_PERCENT = 45;
    private const AUDIENCE_MAX_CORRECT_PERCENT = 65;

    private function phoneFriend($question)
    {
        // Simulate friend's confidence (70-95% for correct answer)
        $correctIndex = $question->correct_answer_index;
        $confidence = rand(self::PHONE_FRIEND_CORRECT_MIN_CONFIDENCE, self::PHONE_FRIEND_CORRECT_MAX_CONFIDENCE);

        // 20% chance friend is unsure/wrong
        if (rand(1, 100) <= self::PHONE_FRIEND_WRONG_CHANCE) {
            $wrongIndices = array_diff([0, 1, 2, 3], [$correctIndex]);
            $suggestedIndex = array_values($wrongIndices)[rand(0, 2)];
            $confidence = rand(self::PHONE_FRIEND_MIN_CONFIDENCE, self::PHONE_FRIEND_MAX_CONFIDENCE);
        } else {
            $suggestedIndex = $correctIndex;
        }

        return [
            'type' => 'phone_friend',
            'suggested_index' => $suggestedIndex,
            'confidence' => $confidence,
        ];
    }

    private function askAudience($question)
    {
        $correctIndex = $question->correct_answer_index;
        $distribution = [0 => 0, 1 => 0, 2 => 0, 3 => 0];

        // Correct answer gets 45-65% of votes
        $distribution[$correctIndex] = rand(self::AUDIENCE_MIN_CORRECT_PERCENT, self::AUDIENCE_MAX_CORRECT_PERCENT);

        // Distribute remaining percentage among other options
        $remaining = 100 - $distribution[$correctIndex];
        $otherIndices = array_diff([0, 1, 2, 3], [$correctIndex]);
        $otherIndices = array_values($otherIndices);

        foreach ($otherIndices as $i => $index) {
            if ($i === count($otherIndices) - 1) {
                $distribution[$index] = $remaining;
            } else {
                $amount = rand(0, $remaining);
                $distribution[$index] = $amount;
                $remaining -= $amount;
            }
        }

        return [
            'type' => 'ask_audience',
            'distribution' => $distribution,
        ];
    }
}
