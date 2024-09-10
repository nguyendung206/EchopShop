<?php

namespace App\Services;

use App\Enums\TypeProduct;
use App\Models\Product;

class HomeService
{
    public function moreSecondhand($request)
    {
        try {
            $currentPage = $request->query('page', 1);
            $query = Product::query();
            $secondhandProducts = $query->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->paginate(8, ['*'], 'page', $currentPage);
            $total = $secondhandProducts->total();
            $endPoint = false;
            $endPoint = $total <= $currentPage * 8;

            $productHtml = '';
            foreach($secondhandProducts as $product) {
                $productHtml .= view('web.home.moreSecondhand', compact('product'))->render();
            }
            return response()->json([
                'products' => $productHtml,
                'endPoint' => $endPoint,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra.',
            ], 500);
        }
    }
}
