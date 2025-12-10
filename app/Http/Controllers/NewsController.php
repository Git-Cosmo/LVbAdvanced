<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index()
    {
        $news = News::published()
            ->with('user')
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        $featuredNews = News::published()
            ->featured()
            ->with('user')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('news.index', [
            'news' => $news,
            'featuredNews' => $featuredNews,
            'page' => (object) [
                'title' => 'Gaming News - FPSociety',
                'meta_title' => 'Latest Gaming News | FPSociety',
                'meta_description' => 'Stay updated with the latest gaming news, updates, and announcements for Counter Strike 2, GTA V, Fortnite, and more.',
            ],
        ]);
    }

    /**
     * Display the specified news article.
     */
    public function show(News $news)
    {
        if (!$news->is_published || $news->published_at > now()) {
            abort(404);
        }

        $news->increment('views_count');
        $news->load('user');

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('news.show', [
            'news' => $news,
            'relatedNews' => $relatedNews,
            'page' => (object) [
                'title' => $news->title . ' - FPSociety',
                'meta_title' => $news->title . ' | Gaming News',
                'meta_description' => $news->excerpt ?? substr(strip_tags($news->content), 0, 160),
            ],
        ]);
    }
}
