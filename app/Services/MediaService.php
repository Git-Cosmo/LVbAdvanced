<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaService
{
    /**
     * Upload and optimize image
     */
    public function uploadImage(UploadedFile $file, string $collection = 'images', $model = null): array
    {
        $path = $file->store('images', 'public');
        
        // Optimize image
        $fullPath = Storage::disk('public')->path($path);
        $this->optimizeImage($fullPath);
        
        // Create thumbnail
        $thumbnailPath = $this->createThumbnail($fullPath);
        
        return [
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'thumbnail' => $thumbnailPath,
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
        ];
    }

    /**
     * Optimize image file
     */
    protected function optimizeImage(string $path): void
    {
        // Basic optimization - reduce quality for web
        try {
            $img = imagecreatefromstring(file_get_contents($path));
            if ($img !== false) {
                imagejpeg($img, $path, 85);
                imagedestroy($img);
            }
        } catch (\Exception $e) {
            // If optimization fails, keep original
        }
    }

    /**
     * Create thumbnail
     */
    protected function createThumbnail(string $originalPath): string
    {
        $info = pathinfo($originalPath);
        $thumbnailPath = $info['dirname'] . '/' . $info['filename'] . '_thumb.' . $info['extension'];
        
        try {
            $img = imagecreatefromstring(file_get_contents($originalPath));
            if ($img !== false) {
                $width = imagesx($img);
                $height = imagesy($img);
                
                $newWidth = 300;
                $newHeight = ($height / $width) * $newWidth;
                
                $thumb = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagejpeg($thumb, $thumbnailPath, 85);
                
                imagedestroy($img);
                imagedestroy($thumb);
            }
        } catch (\Exception $e) {
            return $originalPath;
        }
        
        return str_replace(Storage::disk('public')->path(''), '', $thumbnailPath);
    }

    /**
     * Upload video
     */
    public function uploadVideo(UploadedFile $file): array
    {
        $path = $file->store('videos', 'public');
        
        return [
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'type' => 'video',
        ];
    }

    /**
     * Upload audio
     */
    public function uploadAudio(UploadedFile $file): array
    {
        $path = $file->store('audio', 'public');
        
        return [
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'type' => 'audio',
        ];
    }

    /**
     * Upload game resource (map, skin, mod)
     */
    public function uploadGameResource(UploadedFile $file, string $game, string $type): array
    {
        $path = $file->store("resources/{$game}/{$type}", 'public');
        
        return [
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'type' => $type,
            'game' => $game,
            'downloads' => 0,
        ];
    }

    /**
     * Get supported file types
     */
    public function getSupportedTypes(): array
    {
        return [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'videos' => ['mp4', 'webm', 'mov', 'avi'],
            'audio' => ['mp3', 'wav', 'ogg', 'aac'],
            'game_resources' => [
                'cs2' => ['bsp', 'vpk', 'vtf', 'vmt'],
                'gta5' => ['asi', 'dll', 'rpf', 'yft', 'ytd'],
                'generic' => ['zip', 'rar', '7z', 'pak'],
            ],
        ];
    }
}
