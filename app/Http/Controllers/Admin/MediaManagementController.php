<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\Gallery;

class MediaManagementController extends Controller
{
    /**
     * Show media management dashboard
     */
    public function index()
    {
        $galleries = Gallery::with(['user', 'galleryMedia'])
            ->latest()
            ->paginate(20);

        return view('admin.media.index', [
            'galleries' => $galleries,
            'page' => (object) ['title' => 'Media Management'],
        ]);
    }

    /**
     * Approve a gallery
     */
    public function approve(Gallery $gallery)
    {
        $gallery->update(['is_approved' => true]);

        return back()->with('success', 'Gallery approved');
    }

    /**
     * Delete a gallery
     */
    public function destroy(Gallery $gallery)
    {
        // Delete associated media files
        foreach ($gallery->galleryMedia as $media) {
            \Storage::disk('public')->delete($media->path);
            if ($media->thumbnail) {
                \Storage::disk('public')->delete($media->thumbnail);
            }
            $media->delete();
        }

        $gallery->delete();

        return back()->with('success', 'Gallery deleted');
    }

    /**
     * Feature a gallery (pin to top)
     */
    public function feature(Gallery $gallery)
    {
        $gallery->update(['is_featured' => ! $gallery->is_featured]);

        $message = $gallery->is_featured ? 'Gallery featured' : 'Gallery unfeatured';

        return back()->with('success', $message);
    }
}
