<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;

class RadioController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display the radio player page.
     */
    public function index()
    {
        $streamUrl = config('services.icecast.stream_url');
        
        return view('radio.index', [
            'streamUrl' => $streamUrl,
            'page' => (object) [
                'title' => 'Live Radio - FPSociety',
                'meta_title' => 'Live Gaming Radio | FPSociety',
                'meta_description' => 'Listen to FPSociety live radio stream featuring gaming music, community shows, and more.',
            ],
        ]);
    }

    /**
     * Open the radio player in a popup window.
     */
    public function popout()
    {
        $streamUrl = config('services.icecast.stream_url');
        
        return view('radio.popout', [
            'streamUrl' => $streamUrl,
        ]);
    }
}
