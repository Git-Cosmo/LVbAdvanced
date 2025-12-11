<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RedditPost;
use App\Models\RedditSubreddit;
use App\Services\RedditScraperService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RedditManagementController extends Controller
{
    /**
     * Display Reddit management dashboard.
     */
    public function index(): View
    {
        $subreddits = RedditSubreddit::withCount('posts')->get();
        
        $stats = [
            'total_posts' => RedditPost::count(),
            'published_posts' => RedditPost::where('is_published', true)->count(),
            'lsf_posts' => RedditPost::where('subreddit', 'LivestreamFail')->count(),
            'aitah_posts' => RedditPost::where('subreddit', 'AITAH')->count(),
        ];

        $recentPosts = RedditPost::orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.reddit.index', compact('subreddits', 'stats', 'recentPosts'));
    }

    /**
     * Trigger manual Reddit scrape.
     */
    public function scrape(Request $request, RedditScraperService $scraper)
    {
        try {
            // Run the scraper directly instead of via Artisan
            $results = $scraper->scrapeAll();
            
            $total = array_sum($results);
            $details = [];
            foreach ($results as $sub => $count) {
                $details[] = "r/{$sub}: {$count} posts";
            }
            
            $message = "Successfully scraped {$total} total posts. " . implode(', ', $details);
            
            return back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Reddit scrape failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to scrape Reddit: ' . $e->getMessage());
        }
    }

    /**
     * Toggle subreddit enabled status.
     */
    public function toggleSubreddit(RedditSubreddit $subreddit)
    {
        $subreddit->update([
            'is_enabled' => !$subreddit->is_enabled,
        ]);

        $status = $subreddit->is_enabled ? 'enabled' : 'disabled';
        return back()->with('success', "Subreddit {$subreddit->display_name} has been {$status}.");
    }

    /**
     * Update subreddit settings.
     */
    public function updateSubreddit(Request $request, RedditSubreddit $subreddit)
    {
        $validated = $request->validate([
            'scrape_limit' => 'required|integer|min:1|max:100',
            'content_type' => 'required|in:video,text,mixed',
        ]);

        $subreddit->update($validated);

        return back()->with('success', 'Subreddit settings updated successfully!');
    }

    /**
     * Toggle post published status.
     */
    public function togglePublish(RedditPost $post)
    {
        $post->update([
            'is_published' => !$post->is_published,
        ]);

        $status = $post->is_published ? 'published' : 'unpublished';
        return back()->with('success', "Post has been {$status}.");
    }

    /**
     * Toggle post featured status.
     */
    public function toggleFeature(RedditPost $post)
    {
        $post->update([
            'is_featured' => !$post->is_featured,
        ]);

        $status = $post->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Post has been {$status}.");
    }

    /**
     * Delete a Reddit post.
     */
    public function deletePost(RedditPost $post)
    {
        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }
}
