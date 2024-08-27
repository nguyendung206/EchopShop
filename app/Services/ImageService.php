<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function upload(UploadedFile $file)
    {
        $filename = time() . '-' . 'user.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/users'), $filename);
        return $filename;
    }
}
