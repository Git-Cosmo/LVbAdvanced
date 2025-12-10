<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Forum\Forum;
use App\Models\Forum\Thread;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'forums' => Forum::count(),
            'threads' => Thread::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
