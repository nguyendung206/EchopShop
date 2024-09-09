<?php

namespace App\Services;

use App\Enums\TypeProduct;
use App\Models\Product;

class HomeService
{
    public function moreSecondhand($request)
    {
        try {
            $moreSecondhand = $request->query('moreSecondhand', 1);
            $secondhandProducts = Product::query()->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->limit(8)
                ->skip(($moreSecondhand - 1) * 8)
                ->take(8)
                ->get();

            $totalProductsCount = Product::query()->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->count();

            $endPoint = false;
            if ($totalProductsCount <= ($moreSecondhand) * 8) {
                $endPoint = true;
            }

            return response()->json([
                'products' => $secondhandProducts,
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
