<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'forums' => Forum::count(),
            'threads' => ForumThread::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
