<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\AzuracastService;

class RadioController extends Controller
{
    protected SeoService $seoService;
    protected AzuracastService $azuracast;

    public function __construct(SeoService $seoService, AzuracastService $azuracast)
    {
        $this->seoService = $seoService;
        $this->azuracast = $azuracast;
    }

    /**
     * Display the radio player page.
     */
    public function index()
    {
        $streamUrl = config('services.icecast.stream_url');
        $nowPlaying = null;
        
        try {
            if (config('services.azuracast.base_url')) {
                $nowPlaying = $this->azuracast->nowPlaying();
            }
        } catch (\Exception $e) {
            // Silently fail if AzuraCast is not configured
        }
        
        return view('radio.index', [
            'streamUrl' => $streamUrl,
            'nowPlaying' => $nowPlaying,
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
        $nowPlaying = null;
        
        try {
            if (config('services.azuracast.base_url')) {
                $nowPlaying = $this->azuracast->nowPlaying();
            }
        } catch (\Exception $e) {
            // Silently fail if AzuraCast is not configured
        }
        
        return view('radio.popout', [
            'streamUrl' => $streamUrl,
            'nowPlaying' => $nowPlaying,
        ]);
    }
}
