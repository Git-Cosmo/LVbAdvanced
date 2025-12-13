<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddTriviaQuestionRequest;
use App\Http\Requests\Admin\StoreTriviaGameRequest;
use App\Http\Requests\Admin\UpdateTriviaGameRequest;
use App\Models\TriviaGame;
use App\Models\TriviaQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TriviaManagementController extends Controller
{
    public function index(): View
    {
        $games = TriviaGame::withCount('questions', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.trivia.index', [
            'games' => $games,
            'page' => (object) ['title' => 'Trivia Games'],
        ]);
    }

    public function create(): View
    {
        return view('admin.casual-games.trivia.create', [
            'page' => (object) ['title' => 'Create Trivia Game'],
        ]);
    }

    public function store(StoreTriviaGameRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        TriviaGame::create($validated);

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game created successfully!');
    }

    public function edit(TriviaGame $triviaGame): View
    {
        $triviaGame->load('questions');

        return view('admin.casual-games.trivia.edit', [
            'game' => $triviaGame,
            'page' => (object) ['title' => 'Edit Trivia Game'],
        ]);
    }

    public function update(UpdateTriviaGameRequest $request, TriviaGame $triviaGame): RedirectResponse
    {
        $validated = $request->validated();

        $triviaGame->update($validated);

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game updated successfully!');
    }

    public function destroy(TriviaGame $triviaGame): RedirectResponse
    {
        $triviaGame->delete();

        return redirect()->route('admin.casual-games.trivia.index')
            ->with('success', 'Trivia game deleted successfully!');
    }

    public function addQuestion(AddTriviaQuestionRequest $request, TriviaGame $triviaGame): RedirectResponse
    {
        $validated = $request->validated();

        $triviaGame->questions()->create($validated);

        return back()->with('success', 'Question added successfully!');
    }

    public function deleteQuestion(TriviaQuestion $question): RedirectResponse
    {
        $question->delete();

        return back()->with('success', 'Question deleted successfully!');
    }
}
