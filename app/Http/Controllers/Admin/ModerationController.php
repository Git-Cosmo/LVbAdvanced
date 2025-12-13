<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResolveModerationReportRequest;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumReport;
use App\Models\Forum\ForumThread;
use App\Models\User;
use App\Models\User\UserBan;
use App\Models\User\UserWarning;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerationController extends Controller
{
    /**
     * Display the moderation queue.
     */
    public function index(): View
    {
        $reports = ForumReport::with(['reporter', 'reportable', 'moderator'])
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->paginate(20);

        $pendingCount = ForumReport::where('status', 'pending')->count();

        return view('admin.moderation.index', compact('reports', 'pendingCount'));
    }

    /**
     * Show a specific report.
     */
    public function show(ForumReport $report): View
    {
        $report->load(['reporter', 'reportable', 'moderator']);

        return view('admin.moderation.show', compact('report'));
    }

    /**
     * Resolve a report.
     */
    public function resolve(ResolveModerationReportRequest $request, ForumReport $report): RedirectResponse
    {
        $validated = $request->validated();

        $report->resolve(auth()->user(), $validated['notes']);

        // Take action based on selection
        switch ($validated['action']) {
            case 'delete_content':
                if ($report->reportable_type === ForumPost::class) {
                    $report->reportable->delete();
                } elseif ($report->reportable_type === ForumThread::class) {
                    $report->reportable->delete();
                }
                break;

            case 'warn_user':
                $reportedUserId = $report->reportable->user_id ?? null;
                if ($reportedUserId) {
                    UserWarning::create([
                        'user_id' => $reportedUserId,
                        'moderator_id' => auth()->id(),
                        'reason' => $report->reason,
                        'points' => 1,
                    ]);
                }
                break;

            case 'ban_user':
                $reportedUserId = $report->reportable->user_id ?? null;
                if ($reportedUserId) {
                    UserBan::create([
                        'user_id' => $reportedUserId,
                        'banned_by' => auth()->id(),
                        'reason' => $report->reason,
                        'type' => 'temporary',
                        'expires_at' => now()->addDays(7),
                        'is_active' => true,
                    ]);
                }
                break;
        }

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Report resolved successfully.');
    }

    /**
     * Show user warnings.
     */
    public function warnings(): View
    {
        $warnings = UserWarning::with(['user', 'moderator'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.moderation.warnings', compact('warnings'));
    }

    /**
     * Show user bans.
     */
    public function bans(): View
    {
        $bans = UserBan::with(['user', 'moderator'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.moderation.bans', compact('bans'));
    }

    /**
     * Unban a user.
     */
    public function unban(UserBan $ban): RedirectResponse
    {
        $ban->update([
            'is_active' => false,
        ]);

        return back()->with('success', 'User unbanned successfully.');
    }

    /**
     * Show form to merge threads.
     */
    public function mergeThreadsForm(): View
    {
        return view('admin.moderation.merge-threads');
    }

    /**
     * Merge threads.
     */
    public function mergeThreads(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_thread_id' => 'required|exists:forum_threads,id',
            'target_thread_id' => 'required|exists:forum_threads,id|different:source_thread_id',
        ]);

        $sourceThread = ForumThread::findOrFail($validated['source_thread_id']);
        $targetThread = ForumThread::findOrFail($validated['target_thread_id']);

        // Wrap merge operation in transaction for data integrity
        \DB::transaction(function () use ($sourceThread, $targetThread) {
            // Move all posts from source to target
            ForumPost::where('thread_id', $sourceThread->id)
                ->update(['thread_id' => $targetThread->id]);

            // Update target thread stats
            $targetThread->increment('posts_count', $sourceThread->posts_count);
            $targetThread->increment('views_count', $sourceThread->views_count);

            // Delete source thread
            $sourceThread->delete();
        });

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Threads merged successfully.');
    }

    /**
     * Show form to move thread.
     */
    public function moveThreadForm(ForumThread $thread): View
    {
        $forums = \App\Models\Forum\Forum::with('category')->get()->groupBy('category_id');

        return view('admin.moderation.move-thread', compact('thread', 'forums'));
    }

    /**
     * Move thread to different forum.
     */
    public function moveThread(Request $request, ForumThread $thread): RedirectResponse
    {
        $validated = $request->validate([
            'forum_id' => 'required|exists:forums,id|different:'.$thread->forum_id,
        ]);

        $oldForum = $thread->forum;
        $newForum = \App\Models\Forum\Forum::findOrFail($validated['forum_id']);

        // Update thread
        $thread->update(['forum_id' => $newForum->id]);

        // Update forum stats
        $oldForum->decrement('threads_count');
        $oldForum->decrement('posts_count', $thread->posts_count);

        $newForum->increment('threads_count');
        $newForum->increment('posts_count', $thread->posts_count);

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Thread moved successfully.');
    }

    /**
     * Show pending content approval queue.
     */
    public function approvalQueue(): View
    {
        $pendingThreads = ForumThread::where('is_hidden', true)
            ->where('is_locked', false)
            ->with(['user', 'forum'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.moderation.approval-queue', compact('pendingThreads'));
    }

    /**
     * Approve content.
     */
    public function approveContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:thread,post',
            'id' => 'required|integer',
        ]);

        if ($validated['type'] === 'thread') {
            $thread = ForumThread::findOrFail($validated['id']);
            $thread->update(['is_hidden' => false]);
        } else {
            $post = ForumPost::findOrFail($validated['id']);
            $post->update(['is_hidden' => false]);
        }

        return back()->with('success', 'Content approved successfully.');
    }

    /**
     * Reject/deny content.
     */
    public function denyContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:thread,post',
            'id' => 'required|integer',
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validated['type'] === 'thread') {
            $thread = ForumThread::findOrFail($validated['id']);
            $thread->delete();
        } else {
            $post = ForumPost::findOrFail($validated['id']);
            $post->delete();
        }

        return back()->with('success', 'Content denied and deleted.');
    }
}
