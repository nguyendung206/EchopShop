<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadImageService
{
    public function uploadImage($file, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(storage_path($path), $fileName);
            return $fileName;
        }

        return $defaultImage;
    }

    public function deleteImage($fileName, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        $filePath = storage_path($path . '/' . $fileName);

    if (file_exists($filePath) && $fileName !== $defaultImage) {
        unlink($filePath);
    }
    }
}
