<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImage($file, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');
            return $fileName;
        }

        return $defaultImage;
    }

    public function deleteImage($fileName, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        $filePath = storage_path('app/' . $path . '/' . $fileName);
        if (file_exists($filePath) && $fileName !== $defaultImage) {
            unlink($filePath);
        }

    }
}
