<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumPoll;
use App\Models\Forum\ForumPollOption;
use App\Models\Forum\ForumPollVote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PollController extends Controller
{
    /**
     * Vote on a poll.
     */
    public function vote(Request $request, ForumPoll $poll): RedirectResponse
    {
        $this->authorize('vote', $poll);
        
        // Check if poll is still active
        if (!$poll->isActive()) {
            return back()->with('error', 'This poll has closed.');
        }
        
        // Check if user has already voted
        $existingVote = ForumPollVote::where('poll_id', $poll->id)
            ->where('user_id', auth()->id())
            ->exists();
            
        if ($existingVote) {
            return back()->with('error', 'You have already voted on this poll.');
        }
        
        $validated = $request->validate([
            'option_ids' => $poll->is_multiple_choice ? 'required|array' : 'required',
            'option_ids.*' => 'exists:forum_poll_options,id',
        ]);
        
        $optionIds = $poll->is_multiple_choice 
            ? $validated['option_ids'] 
            : [$validated['option_ids']];
        
        // Create votes
        foreach ($optionIds as $optionId) {
            ForumPollVote::create([
                'poll_id' => $poll->id,
                'option_id' => $optionId,
                'user_id' => auth()->id(),
            ]);
            
            // Increment option votes
            ForumPollOption::where('id', $optionId)->increment('votes');
        }
        
        // Increment total votes
        $poll->increment('total_votes');
        
        return back()->with('success', 'Your vote has been recorded!');
    }
    
    /**
     * Show poll results.
     */
    public function results(ForumPoll $poll): View
    {
        $poll->load(['options', 'thread']);
        
        $hasVoted = ForumPollVote::where('poll_id', $poll->id)
            ->where('user_id', auth()->id())
            ->exists();
        
        $userVotes = ForumPollVote::where('poll_id', $poll->id)
            ->where('user_id', auth()->id())
            ->pluck('option_id')
            ->toArray();
        
        return view('forum.poll.results', compact('poll', 'hasVoted', 'userVotes'));
    }
}
