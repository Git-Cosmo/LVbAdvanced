<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['causer', 'subject'])
            ->latest();

        // Filter by log name
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by causer (user)
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // Filter by description/event
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%'.$request->search.'%')
                    ->orWhere('event', 'like', '%'.$request->search.'%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(50);

        // Get unique log names for filter
        $logNames = Activity::select('log_name')
            ->distinct()
            ->pluck('log_name');

        return view('admin.activity-log.index', compact('activities', 'logNames'));
    }

    public function show(Activity $activity)
    {
        $activity->load(['causer', 'subject']);

        return view('admin.activity-log.show', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('admin.activity-log.index')
            ->with('success', 'Activity log deleted successfully');
    }

    public function clean(Request $request)
    {
        $days = $request->input('days', 30);

        $deleted = Activity::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->route('admin.activity-log.index')
            ->with('success', "Deleted {$deleted} activity log entries older than {$days} days");
    }
}
