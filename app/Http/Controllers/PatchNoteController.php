<?php

namespace App\Http\Controllers;

use App\Models\PatchNote;
use App\Services\SeoService;
use Illuminate\Http\Request;

class PatchNoteController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of patch notes.
     */
    public function index(Request $request)
    {
        $query = PatchNote::published()->orderBy('released_at', 'desc');

        // Filter by game if provided
        if ($request->filled('game')) {
            $query->forGame($request->game);
        }

        $patchNotes = $query->paginate(15);

        $featuredPatchNotes = PatchNote::published()
            ->featured()
            ->orderBy('released_at', 'desc')
            ->take(3)
            ->get();

        // Get list of games for filter dropdown
        $games = PatchNote::published()
            ->distinct('game_name')
            ->pluck('game_name')
            ->sort();

        return view('patch-notes.index', [
            'patchNotes' => $patchNotes,
            'featuredPatchNotes' => $featuredPatchNotes,
            'games' => $games,
            'selectedGame' => $request->game,
            'page' => (object) [
                'title' => 'Game Patch Notes - FPSociety',
                'meta_title' => 'Latest Game Patch Notes | FPSociety',
                'meta_description' => 'Browse the latest patch notes and updates for popular games including Counter Strike 2, GTA V, Fortnite, Call of Duty, and more.',
            ],
        ]);
    }

    /**
     * Display the specified patch note.
     */
    public function show(PatchNote $patchNote)
    {
        if (! $patchNote->is_published) {
            abort(404);
        }

        $patchNote->increment('views_count');

        // Get related patch notes for the same game
        $relatedPatchNotes = PatchNote::published()
            ->forGame($patchNote->game_name)
            ->where('id', '!=', $patchNote->id)
            ->orderBy('released_at', 'desc')
            ->take(5)
            ->get();

        $seoData = $this->seoService->generateMetaTags([
            'title' => $patchNote->title.' - '.$patchNote->game_name.' Patch Notes',
            'description' => $patchNote->description ?? substr(strip_tags($patchNote->content), 0, 160),
            'keywords' => implode(', ', [$patchNote->game_name, 'patch notes', 'update', $patchNote->version]),
        ]);

        return view('patch-notes.show', compact('patchNote', 'relatedPatchNotes', 'seoData'));
    }
}
