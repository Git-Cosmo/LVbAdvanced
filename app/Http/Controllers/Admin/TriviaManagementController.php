<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TriviaGame;
use App\Models\TriviaQuestion;
use Illuminate\Http\Request;

class TriviaManagementController extends Controller
{
    public function index()
    {
        $games = TriviaGame::withCount('questions', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.trivia.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Trivia Games'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.trivia.create', [
            'page' => (object) ['title' => 'Create Trivia Game'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:10|max:300',
            'points_per_correct' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        TriviaGame::create($validated);

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game created successfully!');
    }

    public function edit(TriviaGame $triviaGame)
    {
        $triviaGame->load('questions');

        return view('admin.casual-games.trivia.edit', [
            'game' => $triviaGame,
            'page' => (object) ['title' => 'Edit Trivia Game'],
        ]);
    }

    public function update(Request $request, TriviaGame $triviaGame)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:10|max:300',
            'points_per_correct' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $triviaGame->update($validated);

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game updated successfully!');
    }

    public function destroy(TriviaGame $triviaGame)
    {
        $triviaGame->delete();

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game deleted successfully!');
    }

    public function addQuestion(Request $request, TriviaGame $triviaGame)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer_index' => 'required|integer|min:0',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
        ]);

        $triviaGame->questions()->create($validated);

        return back()->with('success', 'Question added successfully!');
    }

    public function deleteQuestion(TriviaQuestion $question)
    {
        $question->delete();

        return back()->with('success', 'Question deleted successfully!');
    }
}
