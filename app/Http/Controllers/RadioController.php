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

    /**
     * Display the radio home page with now playing and history.
     */
    public function home()
    {
        $nowPlaying = null;
        
        try {
            if (config('services.azuracast.base_url')) {
                $nowPlaying = $this->azuracast->nowPlaying();
            }
        } catch (\Exception $e) {
            // Silently fail if AzuraCast is not configured
        }
        
        return view('radio.home', [
            'nowPlaying' => $nowPlaying,
            'page' => (object) [
                'title' => 'Radio Home - FPSociety',
                'meta_title' => 'Radio Home | FPSociety',
                'meta_description' => 'Your central hub for FPSociety live radio featuring gaming music, community shows, and more.',
            ],
        ]);
    }

    /**
     * Display the song requests page.
     */
    public function requests()
    {
        $requestableSongs = [];
        
        try {
            if (config('services.azuracast.base_url')) {
                $requestableSongs = $this->azuracast->requestableSongs();
            }
        } catch (\Exception $e) {
            // Silently fail if AzuraCast is not configured
        }
        
        return view('radio.requests', [
            'requestableSongs' => $requestableSongs,
            'page' => (object) [
                'title' => 'Song Requests - FPSociety',
                'meta_title' => 'Request Songs | FPSociety Radio',
                'meta_description' => 'Browse and request songs from our music library on FPSociety Radio.',
            ],
        ]);
    }

    /**
     * Submit a song request.
     */
    public function submitRequest(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'You must be logged in to request songs.');
        }

        $request->validate([
            'request_id' => 'required|string',
        ]);

        try {
            $log = $this->azuracast->requestSong($request->request_id, auth()->id());
            
            if ($log->status === 'success') {
                return redirect()->back()->with('success', 'Song requested successfully! ' . ($log->api_response_message ?? ''));
            } else {
                return redirect()->back()->with('error', 'Failed to request song. ' . ($log->api_response_message ?? 'Please try again later.'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while requesting the song. Please try again later.');
        }
    }
}
