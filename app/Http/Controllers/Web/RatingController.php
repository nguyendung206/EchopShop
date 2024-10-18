<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected $productService;

    public function __construct(RatingService $productService)
    {
        $this->productService = $productService;
    }

    public function store(RatingRequest $request)
    {
        try {
            $rating = $this->productService->storeRating($request);
            if ($rating) {
                return response()->json(['success' => true, 'message' => 'Cảm ơn bạn đã Đánh giá sản phẩm!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Đánh giá sản phẩm thất bại.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi: '.$e->getMessage()]);
        }
    }
}
