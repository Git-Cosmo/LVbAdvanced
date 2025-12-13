<?php

namespace App\Http\Controllers\Admin;

use App\Events\AnnouncementCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Http\Requests\Admin\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index(): View
    {
        $announcements = Announcement::with('user')
            ->recent()
            ->paginate(20);

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create(): View
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['source'] = 'website';
        $validated['published_at'] = $request->boolean('publish_now') ? now() : null;

        $announcement = Announcement::create($validated);

        // Broadcast event (will trigger Discord sync and Reverb broadcast)
        event(new AnnouncementCreated($announcement));

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties(['title' => $validated['title']])
            ->log('announcement_created');

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created and broadcasted successfully.');
    }

    /**
     * Show the form for editing an announcement.
     */
    public function edit(Announcement $announcement): View
    {
        // Prevent editing Discord-sourced announcements
        if ($announcement->isFromDiscord()) {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'Discord-sourced announcements cannot be edited from the admin panel.');
        }

        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        // Prevent updating Discord-sourced announcements
        if ($announcement->isFromDiscord()) {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'Discord-sourced announcements cannot be updated from the admin panel.');
        }
        $validated = $request->validated();
        $validated['published_at'] = $request->boolean('publish_now') ? now() : $announcement->published_at;

        $announcement->update($validated);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties(['title' => $validated['title']])
            ->log('announcement_updated');

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($announcement)
            ->withProperties(['title' => $announcement->title])
            ->log('announcement_deleted');

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
