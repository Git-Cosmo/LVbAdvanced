<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Forum\ForumAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Show user's gallery.
     */
    public function index(User $user)
    {
        $images = ForumAttachment::where('user_id', $user->id)
            ->whereIn('mime_type', ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->latest()
            ->paginate(24);

        return view('forum.gallery.index', compact('user', 'images'));
    }

    /**
     * Upload image to gallery.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store original
        $file->storeAs('gallery', $filename, 'public');
        
        // Create thumbnail
        $thumbnailName = 'thumb_' . $filename;
        $this->createThumbnail($file, $thumbnailName);

        $attachment = ForumAttachment::create([
            'attachable_type' => 'App\\Models\\User\\UserProfile',
            'attachable_id' => auth()->user()->profile->id,
            'user_id' => auth()->id(),
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    /**
     * Show single image.
     */
    public function show(ForumAttachment $image)
    {
        if (!in_array($image->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            abort(404);
        }

        return view('forum.gallery.show', compact('image'));
    }

    /**
     * Delete image from gallery.
     */
    public function destroy(ForumAttachment $image)
    {
        $this->authorize('delete', $image);

        Storage::delete('gallery/' . $image->filename);
        Storage::delete('gallery/thumb_' . $image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Create thumbnail for image.
     */
    protected function createThumbnail($file, $thumbnailName)
    {
        // Simple thumbnail creation - in production, use Intervention Image or similar
        $file->storeAs('gallery', $thumbnailName, 'public');
    }
}
