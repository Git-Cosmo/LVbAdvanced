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
        // Preserve original format during optimization
        try {
            $imageInfo = getimagesize($path);
            if ($imageInfo === false) {
                return;
            }

            $mimeType = $imageInfo['mime'];
            $img = imagecreatefromstring(file_get_contents($path));

            if ($img !== false) {
                // Preserve transparency for PNG/GIF
                if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
                    imagealphablending($img, false);
                    imagesavealpha($img, true);
                }

                // Save in original format
                switch ($mimeType) {
                    case 'image/png':
                        imagepng($img, $path, 8); // Compression level 8 (0-9)
                        break;
                    case 'image/gif':
                        imagegif($img, $path);
                        break;
                    case 'image/webp':
                        imagewebp($img, $path, 85);
                        break;
                    case 'image/jpeg':
                    case 'image/jpg':
                    default:
                        imagejpeg($img, $path, 85);
                        break;
                }

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
        $imageInfo = getimagesize($originalPath);

        if ($imageInfo === false) {
            return $originalPath;
        }

        $mimeType = $imageInfo['mime'];

        // Determine extension based on mime type
        $extension = match ($mimeType) {
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg',
        };

        $thumbnailPath = $info['dirname'].'/'.$info['filename'].'_thumb.'.$extension;

        try {
            $img = imagecreatefromstring(file_get_contents($originalPath));
            if ($img !== false) {
                $width = imagesx($img);
                $height = imagesy($img);

                $newWidth = 300;
                $newHeight = ($height / $width) * $newWidth;

                $thumb = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve transparency for PNG/GIF
                if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);
                    $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
                    imagefill($thumb, 0, 0, $transparent);
                }

                imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Save in appropriate format
                switch ($mimeType) {
                    case 'image/png':
                        imagepng($thumb, $thumbnailPath, 8);
                        break;
                    case 'image/gif':
                        imagegif($thumb, $thumbnailPath);
                        break;
                    case 'image/webp':
                        imagewebp($thumb, $thumbnailPath, 85);
                        break;
                    default:
                        imagejpeg($thumb, $thumbnailPath, 85);
                        break;
                }

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
