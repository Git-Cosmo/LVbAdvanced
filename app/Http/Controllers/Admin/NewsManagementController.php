<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsManagementController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index(): View
    {
        $news = News::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = $validated['published_at'] ?? now();

        $news = News::create($validated);

        // Add tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $news->syncTags($tags);
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($news)
            ->withProperties(['title' => $validated['title'], 'is_published' => $validated['is_published']])
            ->log('news_created');

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing the news article.
     */
    public function edit(News $news): View
    {
        $news->load('tags');

        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = $path;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        $news->update($validated);

        // Update tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $news->syncTags($tags);
        } else {
            $news->syncTags([]);
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($news)
            ->withProperties(['title' => $validated['title'], 'is_published' => $validated['is_published']])
            ->log('news_updated');

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(News $news): RedirectResponse
    {
        // Delete image if exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($news)
            ->withProperties(['title' => $news->title])
            ->log('news_deleted');

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }
}
