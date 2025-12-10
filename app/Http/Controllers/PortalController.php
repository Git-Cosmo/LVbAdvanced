<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'totalMembers' => User::count(),
        ]);
    }
}
