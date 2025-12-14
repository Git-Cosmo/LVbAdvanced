<?php

namespace App\Http\Controllers;

use App\Models\WordScrambleAttempt;
use App\Models\WordScrambleGame;
use Illuminate\Http\Request;

class WordScrambleController extends Controller
{
    public function index()
    {
        $games = WordScrambleGame::active()
            ->withCount('words', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('casual-games.word-scramble.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Word Scramble Games'],
        ]);
    }

    public function show(WordScrambleGame $wordScrambleGame)
    {
        $wordScrambleGame->loadCount('words');

        $userAttempt = null;
        if (auth()->check()) {
            $userAttempt = WordScrambleAttempt::where('user_id', auth()->id())
                ->where('word_scramble_game_id', $wordScrambleGame->id)
                ->where('status', 'in_progress')
                ->first();
        }

        return view('casual-games.word-scramble.show', [
            'game' => $wordScrambleGame,
            'userAttempt' => $userAttempt,
            'page' => (object) ['title' => $wordScrambleGame->title],
        ]);
    }

    public function start(WordScrambleGame $wordScrambleGame)
    {
        // Check if user has an active attempt
        $existingAttempt = WordScrambleAttempt::where('user_id', auth()->id())
            ->where('word_scramble_game_id', $wordScrambleGame->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('casual-games.word-scramble.play', [$wordScrambleGame, $existingAttempt]);
        }

        // Create new attempt
        $attempt = WordScrambleAttempt::create([
            'user_id' => auth()->id(),
            'word_scramble_game_id' => $wordScrambleGame->id,
            'started_at' => now(),
        ]);

        return redirect()->route('casual-games.word-scramble.play', [$wordScrambleGame, $attempt]);
    }

    public function play(WordScrambleGame $wordScrambleGame, WordScrambleAttempt $attempt)
    {
        // Authorization
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('casual-games.word-scramble.result', [$wordScrambleGame, $attempt]);
        }

        $wordScrambleGame->load('words');
        
        // Get current word
        $words = $wordScrambleGame->words;
        $totalWords = min($wordScrambleGame->words_per_game, $words->count());
        
        if ($attempt->current_word_index >= $totalWords) {
            // Game completed
            $attempt->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Award points
            if (auth()->user()->profile) {
                auth()->user()->profile->increment('points', $attempt->total_score);
            }

            return redirect()->route('casual-games.word-scramble.result', [$wordScrambleGame, $attempt]);
        }

        $currentWord = $words->skip($attempt->current_word_index)->first();

        return view('casual-games.word-scramble.play', [
            'game' => $wordScrambleGame,
            'attempt' => $attempt,
            'word' => $currentWord,
            'totalWords' => $totalWords,
            'page' => (object) ['title' => 'Playing: '.$wordScrambleGame->title],
        ]);
    }

    public function solve(Request $request, WordScrambleGame $wordScrambleGame, WordScrambleAttempt $attempt)
    {
        // Authorization
        if ($attempt->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'answer' => 'required|string',
            'time_taken' => 'required|integer|min:0',
            'hints_used' => 'required|integer|min:0',
        ]);

        $wordScrambleGame->load('words');
        $words = $wordScrambleGame->words;
        $currentWord = $words->skip($attempt->current_word_index)->first();

        if (!$currentWord) {
            return response()->json(['error' => 'Word not found'], 404);
        }

        $isCorrect = strtolower(trim($validated['answer'])) === strtolower($currentWord->word);

        if ($isCorrect) {
            // Calculate score
            $basePoints = $wordScrambleGame->points_per_word;
            $hintPenalty = $validated['hints_used'] * $wordScrambleGame->hint_penalty;
            $timeTaken = min($validated['time_taken'], $wordScrambleGame->time_per_word);
            
            // Time bonus: faster = more points (max 50% bonus)
            $timeBonus = 0;
            if ($timeTaken < $wordScrambleGame->time_per_word) {
                $timeRatio = 1 - ($timeTaken / $wordScrambleGame->time_per_word);
                $timeBonus = (int) ($basePoints * 0.5 * $timeRatio);
            }

            $score = max(0, $basePoints + $timeBonus - $hintPenalty);

            $attempt->addSolvedWord($currentWord->id, $timeTaken, $validated['hints_used']);
            $attempt->increment('total_score', $score);
            $attempt->increment('current_word_index');

            return response()->json([
                'correct' => true,
                'score' => $score,
                'total_score' => $attempt->fresh()->total_score,
                'next_word_index' => $attempt->current_word_index,
            ]);
        } else {
            return response()->json([
                'correct' => false,
                'correct_answer' => $currentWord->word,
            ]);
        }
    }

    public function skip(WordScrambleGame $wordScrambleGame, WordScrambleAttempt $attempt)
    {
        // Authorization
        if ($attempt->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $wordScrambleGame->load('words');
        $words = $wordScrambleGame->words;
        $currentWord = $words->skip($attempt->current_word_index)->first();

        if ($currentWord) {
            $attempt->skipWord($currentWord->id);
            $attempt->increment('current_word_index');
        }

        return response()->json([
            'skipped' => true,
            'next_word_index' => $attempt->current_word_index,
        ]);
    }

    public function hint(WordScrambleGame $wordScrambleGame, WordScrambleAttempt $attempt)
    {
        // Authorization
        if ($attempt->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $wordScrambleGame->load('words');
        $words = $wordScrambleGame->words;
        $currentWord = $words->skip($attempt->current_word_index)->first();

        if (!$currentWord) {
            return response()->json(['error' => 'Word not found'], 404);
        }

        // Reveal first and last letter
        $word = strtoupper($currentWord->word);
        $hint = $word[0] . str_repeat('_', strlen($word) - 2) . $word[strlen($word) - 1];

        return response()->json([
            'hint' => $hint,
            'custom_hint' => $currentWord->hint,
            'category' => $currentWord->category,
            'category_icon' => $currentWord->category_icon,
            'penalty' => $wordScrambleGame->hint_penalty,
        ]);
    }

    public function result(WordScrambleGame $wordScrambleGame, WordScrambleAttempt $attempt)
    {
        // Authorization
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        return view('casual-games.word-scramble.result', [
            'game' => $wordScrambleGame,
            'attempt' => $attempt,
            'page' => (object) ['title' => 'Game Results'],
        ]);
    }
}
