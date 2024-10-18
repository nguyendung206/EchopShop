<?php

namespace App\Services;

use App\Http\Requests\RatingRequest;
use App\Models\Rating;

class RatingService
{
    public function storeRating(RatingRequest $request)
    {
        $rating = new Rating;
        $rating->star = $request->star;
        $rating->content = $request->content;
        $rating->user_id = $request->user_id;
        $rating->product_id = $request->product_id;
        $media = []; // Khởi tạo mảng media

        if ($request->hasFile('photos')) {
            $listPhotos = uploadMultipleImages($request->file('photos'));
            $media = array_merge($media, $listPhotos); // Gộp ảnh vào mảng media
        }

        if ($request->hasFile('videos')) {
            $listVideos = uploadMultipleVideos($request->file('videos'));
            $media = array_merge($media, $listVideos); // Gộp video vào mảng media
        }

        $rating->media = json_encode($media); // Chuyển mảng media thành JSON

        $rating->save();

        return response()->json($rating, 201);
    }
}
