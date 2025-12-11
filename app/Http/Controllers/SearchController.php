<?php

namespace App\Http\Controllers;

use App\Models\Forum\ForumThread;
use App\Models\Forum\ForumPost;
use App\Models\News;
use App\Models\User;
use App\Models\User\Gallery;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    /**
     * Perform universal search across all models
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return view('search.index', [
                'query' => '',
                'results' => collect(),
                'page' => (object) [
                    'title' => 'Search - FPSociety',
                    'meta_title' => 'Search | FPSociety',
                    'meta_description' => 'Search across forums, news, downloads, and members.',
                ],
            ]);
        }

        $searchResults = (new Search())
            ->registerModel(ForumThread::class, 'title')
            ->registerModel(ForumPost::class, 'content')
            ->registerModel(News::class, ['title', 'excerpt', 'content'])
            ->registerModel(Gallery::class, ['title', 'description'])
            ->registerModel(User::class, ['name', 'email'])
            ->search($query);

        return view('search.index', [
            'query' => $query,
            'results' => $searchResults,
            'page' => (object) [
                'title' => "Search: {$query} - FPSociety",
                'meta_title' => "Search Results for '{$query}' | FPSociety",
                'meta_description' => "Search results for '{$query}' across forums, news, downloads, and members.",
            ],
        ]);
    }
}
