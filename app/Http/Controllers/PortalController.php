<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortalController extends Controller
{
    public function home(): View
    {
        return view('portal.home');
    }
}
