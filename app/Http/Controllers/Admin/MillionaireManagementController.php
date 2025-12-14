<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MillionaireGame;
use App\Models\MillionaireQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MillionaireManagementController extends Controller
{
    public function index()
    {
        $games = MillionaireGame::withCount('questions', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.millionaire.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Millionaire Games'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.millionaire.create', [
            'page' => (object) ['title' => 'Create Millionaire Game'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:10|max:300',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        MillionaireGame::create($validated);

        return redirect()->route('admin.casual-games.millionaire.index')
            ->with('success', 'Millionaire game created successfully!');
    }

    public function edit(MillionaireGame $millionaireGame)
    {
        $millionaireGame->load('questions');

        return view('admin.casual-games.millionaire.edit', [
            'game' => $millionaireGame,
            'page' => (object) ['title' => 'Edit: ' . $millionaireGame->title],
        ]);
    }

    public function update(Request $request, MillionaireGame $millionaireGame)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:10|max:300',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        $millionaireGame->update($validated);

        return redirect()->route('admin.casual-games.millionaire.index')
            ->with('success', 'Millionaire game updated successfully!');
    }

    public function destroy(MillionaireGame $millionaireGame)
    {
        $millionaireGame->delete();

        return redirect()->route('admin.casual-games.millionaire.index')
            ->with('success', 'Millionaire game deleted successfully!');
    }

    public function addQuestion(Request $request, MillionaireGame $millionaireGame)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string',
            'correct_answer_index' => 'required|integer|min:0|max:3',
            'difficulty_level' => 'required|integer|min:1|max:15',
            'prize_amount' => 'required|integer|min:0',
        ]);

        $validated['millionaire_game_id'] = $millionaireGame->id;
        $validated['order'] = $validated['difficulty_level'];

        MillionaireQuestion::create($validated);

        return redirect()->route('admin.casual-games.millionaire.edit', $millionaireGame)
            ->with('success', 'Question added successfully!');
    }

    public function deleteQuestion(MillionaireGame $millionaireGame, MillionaireQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.casual-games.millionaire.edit', $millionaireGame)
            ->with('success', 'Question deleted successfully!');
    }
}
