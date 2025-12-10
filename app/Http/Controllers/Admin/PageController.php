<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::orderBy('order')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:pages,slug',
            'description' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'layout' => 'required|in:default,full-width',
            'is_active' => 'boolean',
            'is_homepage' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_homepage'] = $request->has('is_homepage');
        
        if ($validated['is_homepage']) {
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
            'description' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'layout' => 'required|in:default,full-width',
            'is_active' => 'boolean',
            'is_homepage' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_homepage'] = $request->has('is_homepage');
        
        if ($validated['is_homepage'] && !$page->is_homepage) {
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
