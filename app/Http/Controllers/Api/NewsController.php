<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get list of news articles
     */
    public function index(Request $request)
    {
        $news = News::with(['tags'])
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($request->tag, function ($query, $tag) {
                return $query->withAnyTags([$tag]);
            })
            ->latest('published_at')
            ->paginate($request->get('per_page', 20));

        return response()->json($news);
    }

    /**
     * Get a specific news article
     */
    public function show(News $news)
    {
        $news->load(['tags', 'author']);
        $news->increment('views_count');

        return response()->json($news);
    }
}
