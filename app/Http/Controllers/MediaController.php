<?php

namespace App\Http\Controllers;

use App\Services\MediaService;
use App\Models\User\Gallery;
use App\Models\User\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->middleware('auth')->except(['index', 'show', 'download']);
        $this->mediaService = $mediaService;
    }

    /**
     * Show gallery index
     */
    public function index()
    {
        $galleries = Gallery::with(['user', 'media'])
            ->latest()
            ->paginate(20);
        
        return view('media.gallery.index', [
            'galleries' => $galleries,
            'page' => (object) [
                'title' => 'Gaming Gallery - FPSociety',
                'meta_title' => 'Game Mods, Maps, Skins Gallery | FPSociety',
                'meta_description' => 'Browse and download custom game content: Counter Strike 2 maps, GTA V mods, Fortnite skins, and more gaming resources.',
            ],
        ]);
    }

    /**
     * Show single gallery
     */
    public function show($id)
    {
        $gallery = Gallery::with(['user', 'media', 'comments'])->findOrFail($id);
        $gallery->increment('views');
        
        return view('media.gallery.show', [
            'gallery' => $gallery,
            'page' => (object) [
                'title' => $gallery->title . ' - FPSociety Gallery',
                'meta_title' => $gallery->title . ' | FPSociety Gaming Resources',
                'meta_description' => $gallery->description ?? 'Download ' . $gallery->title . ' for ' . $gallery->game,
            ],
        ]);
    }

    /**
     * Show create gallery form
     */
    public function create()
    {
        $games = ['Counter Strike 2', 'GTA V', 'Fortnite', 'Call of Duty', 'Minecraft', 'Other'];
        
        return view('media.gallery.create', [
            'games' => $games,
            'page' => (object) [
                'title' => 'Upload Content - FPSociety',
            ],
        ]);
    }

    /**
     * Store new gallery
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'game' => 'required|max:100',
            'category' => 'required|in:map,skin,mod,texture,sound,other',
            'files.*' => 'required|file|max:102400', // 100MB max
        ]);

        $gallery = Gallery::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'game' => $validated['game'],
            'category' => $validated['category'],
            'views' => 0,
            'downloads' => 0,
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $mediaData = $this->mediaService->uploadGameResource($file, $validated['game'], $validated['category']);
                $gallery->media()->create($mediaData);
            }
        }

        return redirect()->route('media.show', $gallery)->with('success', 'Content uploaded successfully!');
    }

    /**
     * Download file
     */
    public function download($mediaId)
    {
        $media = \App\Models\User\Media::findOrFail($mediaId);
        $media->increment('downloads');
        
        if ($media->gallery) {
            $media->gallery->increment('downloads');
        }
        
        return Storage::disk('public')->download($media->path, $media->name);
    }
}
