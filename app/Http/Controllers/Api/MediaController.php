<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User\Gallery;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Get user's media
     */
    public function index(Request $request)
    {
        $media = Gallery::where('user_id', $request->user()->id)
            ->with(['media'])
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($media);
    }

    /**
     * Upload media
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,mov,avi,mp3,wav,ogg|max:51200',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $gallery = Gallery::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->file->getMimeType(),
        ]);

        $gallery->addMedia($request->file('file'))
            ->toMediaCollection('gallery-images');

        return response()->json($gallery->load('media'), 201);
    }

    /**
     * Delete media
     */
    public function destroy(Gallery $media)
    {
        $this->authorize('delete', $media);

        $media->delete();

        return response()->json(['message' => 'Media deleted successfully']);
    }
}
