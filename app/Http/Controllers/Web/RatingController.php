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
                return redirect()->back()->with('success', 'Đánh giá của bạn đã được ghi nhận.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['modal_error' => 'Có lỗi xảy ra! Vui lòng thử lại.']);
        }
    }
}
