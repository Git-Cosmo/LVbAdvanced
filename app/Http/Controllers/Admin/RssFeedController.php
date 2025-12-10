<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RssFeed;
use App\Services\RssFeedService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RssFeedController extends Controller
{
    protected RssFeedService $rssFeedService;

    public function __construct(RssFeedService $rssFeedService)
    {
        $this->rssFeedService = $rssFeedService;
    }

    /**
     * Display a listing of RSS feeds.
     */
    public function index(): View
    {
        $feeds = RssFeed::withCount('importedItems')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.rss.index', compact('feeds'));
    }

    /**
     * Show the form for creating a new RSS feed.
     */
    public function create(): View
    {
        return view('admin.rss.create');
    }

    /**
     * Store a newly created RSS feed.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'is_active' => 'boolean',
            'refresh_interval' => 'required|integer|min:15|max:1440',
            'tags' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Store tags in settings
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['settings'] = ['tags' => $tags];
        }

        RssFeed::create($validated);

        return redirect()->route('admin.rss.index')
            ->with('success', 'RSS feed created successfully.');
    }

    /**
     * Show the form for editing the RSS feed.
     */
    public function edit(RssFeed $rssFeed): View
    {
        return view('admin.rss.edit', compact('rssFeed'));
    }

    /**
     * Update the specified RSS feed.
     */
    public function update(Request $request, RssFeed $rssFeed): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'is_active' => 'boolean',
            'refresh_interval' => 'required|integer|min:15|max:1440',
            'tags' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        
        // Store tags in settings
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['settings'] = ['tags' => $tags];
        } else {
            $validated['settings'] = null;
        }

        $rssFeed->update($validated);

        return redirect()->route('admin.rss.index')
            ->with('success', 'RSS feed updated successfully.');
    }

    /**
     * Remove the specified RSS feed.
     */
    public function destroy(RssFeed $rssFeed): RedirectResponse
    {
        $rssFeed->delete();

        return redirect()->route('admin.rss.index')
            ->with('success', 'RSS feed deleted successfully.');
    }

    /**
     * Import items from a specific feed now.
     */
    public function import(RssFeed $rssFeed): RedirectResponse
    {
        $results = $this->rssFeedService->importFeed($rssFeed);

        $message = "Import completed: {$results['success']} new, {$results['skipped']} skipped, {$results['errors']} errors.";

        return redirect()->route('admin.rss.index')
            ->with('success', $message);
    }
}
