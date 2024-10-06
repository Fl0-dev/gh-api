<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageDownloader
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function downloadImage(string $logoPath): ?string
    {
        $imageContents = file_get_contents($logoPath);
        if ($imageContents === false) {
            return null;
        }

        $filename = uniqid() . '.' . pathinfo($logoPath, PATHINFO_EXTENSION);
        $filePath = $this->targetDirectory . '/' . $filename;

        try {
            file_put_contents($filePath, $imageContents);
            return $filename;
        } catch (FileException $e) {
            return null;
        }
    }
}
