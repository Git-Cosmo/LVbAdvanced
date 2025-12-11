<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTask;

class ScheduleMonitorController extends Controller
{
    public function index()
    {
        $tasks = MonitoredScheduledTask::orderBy('name')->get();

        return view('admin.schedule-monitor', [
            'tasks' => $tasks,
        ]);
    }
}
