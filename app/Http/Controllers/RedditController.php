<?php

namespace App\Http\Controllers;

use App\Models\RedditPost;
use App\Services\SeoService;
use Illuminate\View\View;

class RedditController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display clips from r/LivestreamFail.
     */
    public function clips(): View
    {
        $this->seoService->generateMetaTags([
            'title' => 'Gaming Clips - LivestreamFail - FPSociety',
            'description' => 'Watch the latest gaming clips and highlights from Twitch, YouTube, and Kick streamers.',
        ]);

        $posts = RedditPost::published()
            ->subreddit('LivestreamFail')
            ->videos()
            ->orderBy('posted_at', 'desc')
            ->paginate(24);

        return view('reddit.clips', compact('posts'));
    }

    /**
     * Display AITAH stories.
     */
    public function aitah(): View
    {
        $this->seoService->generateMetaTags([
            'title' => 'AITAH Stories - Am I The A**hole - FPSociety',
            'description' => 'Read the latest AITAH (Am I The A**hole) stories and community discussions.',
        ]);

        $posts = RedditPost::published()
            ->subreddit('AITAH')
            ->textPosts()
            ->orderBy('posted_at', 'desc')
            ->paginate(20);

        return view('reddit.aitah', compact('posts'));
    }

    /**
     * Display a single Reddit post.
     */
    public function show(RedditPost $post): View
    {
        // Increment view count
        $post->increment('views_count');

        $this->seoService->generateMetaTags([
            'title' => $post->title.' - FPSociety',
            'description' => $post->body ? substr($post->body, 0, 160) : $post->title,
        ]);

        return view('reddit.show', compact('post'));
    }
}
