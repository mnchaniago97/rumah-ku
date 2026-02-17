<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class WatermarkService
{
    protected ImageManager $manager;
    protected string $watermarkPath;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        $this->watermarkPath = public_path('assets/admin/images/logo/rumahio-dark.png');
    }

    /**
     * Add watermark to an image and save it to the specified path.
     *
     * @param UploadedFile $file The uploaded image file
     * @param string $path The storage path (e.g., 'properties')
     * @param string $disk The storage disk (e.g., 'uploads')
     * @return string The stored file path
     */
    public function processAndStore(UploadedFile $file, string $path, string $disk = 'uploads'): string
    {
        // Read the image
        $image = $this->manager->read($file->getRealPath());

        // Get image dimensions
        $width = $image->width();
        $height = $image->height();

        // Calculate watermark size (40% of image width to make it clearly visible)
        $watermarkWidth = (int) ($width * 0.4);

        // Add image watermark if the logo file exists
        if (file_exists($this->watermarkPath)) {
            // Read watermark image
            $watermark = $this->manager->read($this->watermarkPath);
            
            // Resize watermark while maintaining aspect ratio
            $watermark->scale(width: $watermarkWidth);
            
            // Place watermark at center
            $image->place(
                $watermark,
                'center',
                0,
                0,
                50 // opacity (0-100) - slightly reduced for better aesthetics at larger size
            );
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . '/' . $filename;

        // Get the real path for the storage disk
        $diskPath = Storage::disk($disk)->path('');
        $savePath = rtrim($diskPath, '/\\') . '/' . $fullPath;

        // Ensure directory exists
        $directory = dirname($savePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save the watermarked image
        $image->save($savePath, 85); // 85% quality

        return $fullPath;
    }

    /**
     * Process multiple images and return array of stored paths.
     *
     * @param array $files Array of UploadedFile instances
     * @param string $path The storage path
     * @param string $disk The storage disk
     * @return array Array of stored file paths
     */
    public function processMultiple(array $files, string $path, string $disk = 'uploads'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $paths[] = $this->processAndStore($file, $path, $disk);
            }
        }
        return $paths;
    }
}
