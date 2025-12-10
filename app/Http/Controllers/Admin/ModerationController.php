<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function resolve(Request $request, ForumReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:dismiss,delete_content,warn_user,ban_user',
            'notes' => 'nullable|string|max:1000',
        ]);
        
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
}
