<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum\Forum;
use App\Models\Forum\ForumCategory;
use App\Services\Forum\ForumService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForumManagementController extends Controller
{
    public function __construct(
        protected ForumService $forumService
    ) {}

    /**
     * Display forum management dashboard.
     */
    public function index(): View
    {
        $categories = ForumCategory::withCount(['forums'])->orderBy('order')->get();
        $forums = Forum::with('category')->withCount(['threads', 'children'])->orderBy('order')->get();
        
        return view('admin.forum.index', compact('categories', 'forums'));
    }

    /**
     * Show form to create a new category.
     */
    public function createCategory(): View
    {
        return view('admin.forum.create-category');
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:forum_categories',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;
        
        $this->forumService->createCategory($validated);
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show form to create a new forum.
     */
    public function createForum(): View
    {
        $categories = ForumCategory::active()->orderBy('order')->get();
        $forums = Forum::active()->whereNull('parent_id')->orderBy('order')->get();
        
        return view('admin.forum.create-forum', compact('categories', 'forums'));
    }

    /**
     * Store a new forum.
     */
    public function storeForum(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'parent_id' => 'nullable|exists:forums,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:forums',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
        ]);
        
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['is_locked'] = $validated['is_locked'] ?? false;
        
        $this->forumService->createForum($validated);
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Forum created successfully!');
    }

    /**
     * Show form to edit a category.
     */
    public function editCategory(ForumCategory $category): View
    {
        return view('admin.forum.edit-category', compact('category'));
    }

    /**
     * Update a category.
     */
    public function updateCategory(Request $request, ForumCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:forum_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        
        $category->update($validated);
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Show form to edit a forum.
     */
    public function editForum(Forum $forum): View
    {
        $categories = ForumCategory::active()->orderBy('order')->get();
        $forums = Forum::active()->where('id', '!=', $forum->id)->whereNull('parent_id')->orderBy('order')->get();
        
        return view('admin.forum.edit-forum', compact('forum', 'categories', 'forums'));
    }

    /**
     * Update a forum.
     */
    public function updateForum(Request $request, Forum $forum): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'parent_id' => 'nullable|exists:forums,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:forums,slug,' . $forum->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
        ]);
        
        $forum->update($validated);
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Forum updated successfully!');
    }

    /**
     * Delete a category.
     */
    public function deleteCategory(ForumCategory $category): RedirectResponse
    {
        $category->delete();
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Delete a forum.
     */
    public function deleteForum(Forum $forum): RedirectResponse
    {
        $forum->delete();
        
        return redirect()->route('admin.forum.index')
            ->with('success', 'Forum deleted successfully!');
    }
}
