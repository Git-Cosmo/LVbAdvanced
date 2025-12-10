<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumReaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    protected \App\Services\GamificationService $gamificationService;

    public function __construct(\App\Services\GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Add or remove a reaction to a post.
     */
    public function toggle(Request $request, ForumPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:like,love,laugh,angry,sad,wow',
        ]);
        
        $existing = ForumReaction::where('user_id', auth()->id())
            ->where('reactable_type', ForumPost::class)
            ->where('reactable_id', $post->id)
            ->first();
        
        if ($existing) {
            if ($existing->type === $validated['type']) {
                // Remove reaction if clicking same type
                $existing->delete();
                $post->decrement('reactions_count');
            } else {
                // Change reaction type
                $existing->update(['type' => $validated['type']]);
            }
        } else {
            // Add new reaction
            ForumReaction::create([
                'user_id' => auth()->id(),
                'reactable_type' => ForumPost::class,
                'reactable_id' => $post->id,
                'type' => $validated['type'],
            ]);
            $post->increment('reactions_count');
            
            // Award XP to post author for receiving a like
            if ($validated['type'] === 'like' && $post->user_id !== auth()->id()) {
                $this->gamificationService->awardActionXP($post->user, 'receive_like');
            }
        }
        
        return back()->with('success', 'Reaction updated!');
    }

    /**
     * Get reactions for a post.
     */
    public function show(ForumPost $post)
    {
        $reactions = $post->reactions()
            ->with('user')
            ->get()
            ->groupBy('type');
        
        return response()->json($reactions);
    }
}
