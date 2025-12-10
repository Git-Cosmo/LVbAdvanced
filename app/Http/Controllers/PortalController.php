<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function home(): View
    {
        return view('portal.home');
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('portal.home', [
            'page' => $page,
        ]);
    }
}
