<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatchNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatchNoteController extends Controller
{
    /**
     * Display a listing of patch notes.
     */
    public function index(): View
    {
        $patchNotes = PatchNote::orderBy('released_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => PatchNote::count(),
            'published' => PatchNote::where('is_published', true)->count(),
            'featured' => PatchNote::where('is_featured', true)->count(),
            'games' => PatchNote::distinct('game_name')->count('game_name'),
        ];

        return view('admin.patch-notes.index', compact('patchNotes', 'stats'));
    }

    /**
     * Show the form for creating a new patch note.
     */
    public function create(): View
    {
        return view('admin.patch-notes.create');
    }

    /**
     * Store a newly created patch note.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'game_name' => 'required|string|max:255',
            'version' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'source_url' => 'nullable|url|max:500',
            'released_at' => 'nullable|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['released_at'] = $validated['released_at'] ?? now();

        $patchNote = PatchNote::create($validated);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($patchNote)
            ->withProperties(['title' => $validated['title'], 'game_name' => $validated['game_name']])
            ->log('patch_note_created');

        return redirect()->route('admin.patch-notes.index')
            ->with('success', 'Patch note created successfully.');
    }

    /**
     * Show the form for editing the patch note.
     */
    public function edit(PatchNote $patchNote): View
    {
        return view('admin.patch-notes.edit', compact('patchNote'));
    }

    /**
     * Update the specified patch note.
     */
    public function update(Request $request, PatchNote $patchNote): RedirectResponse
    {
        $validated = $request->validate([
            'game_name' => 'required|string|max:255',
            'version' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'source_url' => 'nullable|url|max:500',
            'released_at' => 'nullable|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        $patchNote->update($validated);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($patchNote)
            ->withProperties(['title' => $validated['title'], 'game_name' => $validated['game_name']])
            ->log('patch_note_updated');

        return redirect()->route('admin.patch-notes.index')
            ->with('success', 'Patch note updated successfully.');
    }

    /**
     * Remove the specified patch note.
     */
    public function destroy(PatchNote $patchNote): RedirectResponse
    {
        // Log activity before deletion
        activity()
            ->causedBy(auth()->user())
            ->performedOn($patchNote)
            ->withProperties(['title' => $patchNote->title, 'game_name' => $patchNote->game_name])
            ->log('patch_note_deleted');

        $patchNote->delete();

        return redirect()->route('admin.patch-notes.index')
            ->with('success', 'Patch note deleted successfully.');
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(PatchNote $patchNote): RedirectResponse
    {
        $patchNote->update(['is_published' => ! $patchNote->is_published]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($patchNote)
            ->withProperties(['is_published' => $patchNote->is_published])
            ->log('patch_note_publish_toggled');

        $message = $patchNote->is_published ? 'Patch note published.' : 'Patch note unpublished.';

        return back()->with('success', $message);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(PatchNote $patchNote): RedirectResponse
    {
        $patchNote->update(['is_featured' => ! $patchNote->is_featured]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($patchNote)
            ->withProperties(['is_featured' => $patchNote->is_featured])
            ->log('patch_note_featured_toggled');

        $message = $patchNote->is_featured ? 'Patch note featured.' : 'Patch note unfeatured.';

        return back()->with('success', $message);
    }
}
