<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumAttachment;
use App\Models\Forum\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Upload attachment.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'attachable_type' => 'required|string',
            'attachable_id' => 'required|integer',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('attachments', $filename, 'public');

        $attachment = ForumAttachment::create([
            'attachable_type' => $request->attachable_type,
            'attachable_id' => $request->attachable_id,
            'user_id' => auth()->id(),
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
            'attachment' => [
                'id' => $attachment->id,
                'filename' => $attachment->original_filename,
                'size' => $attachment->human_size,
                'url' => Storage::url('attachments/' . $attachment->filename),
            ],
        ]);
    }

    /**
     * Download attachment.
     */
    public function download(ForumAttachment $attachment)
    {
        $attachment->increment('downloads_count');
        
        return Storage::download(
            'attachments/' . $attachment->filename,
            $attachment->original_filename
        );
    }

    /**
     * Delete attachment.
     */
    public function destroy(ForumAttachment $attachment)
    {
        $this->authorize('delete', $attachment);

        Storage::delete('attachments/' . $attachment->filename);
        $attachment->delete();

        return response()->json(['success' => true]);
    }
}
