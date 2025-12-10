<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Page;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pages' => Page::count(),
            'blocks' => Block::count(),
            'users' => User::count(),
            'activeBlocks' => Block::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
