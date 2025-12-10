<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumSubscription;
use App\Models\Forum\ForumThread;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    /**
     * Subscribe to a thread.
     */
    public function subscribe(ForumThread $thread): RedirectResponse
    {
        ForumSubscription::firstOrCreate([
            'user_id' => auth()->id(),
            'subscribable_type' => ForumThread::class,
            'subscribable_id' => $thread->id,
        ], [
            'notify_email' => true,
            'notify_push' => true,
        ]);
        
        return back()->with('success', 'Subscribed to thread!');
    }

    /**
     * Unsubscribe from a thread.
     */
    public function unsubscribe(ForumThread $thread): RedirectResponse
    {
        ForumSubscription::where('user_id', auth()->id())
            ->where('subscribable_type', ForumThread::class)
            ->where('subscribable_id', $thread->id)
            ->delete();
        
        return back()->with('success', 'Unsubscribed from thread!');
    }
}
