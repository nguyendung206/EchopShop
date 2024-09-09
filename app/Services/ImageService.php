<?php

namespace App\Services;

class ImageService
{
    public function uploadImage($file, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($file) {
            $fileName = time().'-'.$file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');

            return $fileName;
        }

        return $defaultImage;
    }

    public function deleteImage($fileName, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        $filePath = storage_path('app/'.$path.'/'.$fileName);
        if (file_exists($filePath) && $fileName !== $defaultImage) {
            unlink($filePath);
        }
    }

    public function uploadMultipleImages($files, $path = 'upload/product')
    {
        $fileNames = [];
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $fileName = $this->uploadImage($file, $path);
                $fileNames[] = $fileName;
            }
        }

        return $fileNames;
    }

    public function deleteMultipleImages($fileNames, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($fileNames && is_array($fileNames)) {
            foreach ($fileNames as $fileName) {
                $this->deleteImage($fileName, $path, $defaultImage);
            }
        }
    }
}
