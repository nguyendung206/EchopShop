<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeService
{
    public function getProduct($type, $perPage, $pageName)
    {
        $query = Product::query();
        $products = $query->where('status', 1)->where('type', $type)->paginate($perPage, ['*'], $pageName);

        return $products;
    }

    public function filterProducts($request, $type)
    {

        $rangeInputMin = $request->query('rangeInputMin') !== null ? (float) $request->query('rangeInputMin') : 0;
        $rangeInputMax = $request->query('rangeInputMax') !== null ? (float) $request->query('rangeInputMax') : PHP_INT_MAX;
        $brandId = $request->query('brandId');
        $products = Product::query()->where('status', 1)
            ->where('price', '>=', $rangeInputMin)
            ->where('price', '<=', $rangeInputMax)
            ->when($brandId, function ($query, $brandId) {
                return $query->where('brand_id', $brandId);
            })
            ->where('type', $type)->get();

        if (stripos($request->url(), 'favorite')) {
            if (! Auth::check()) {
                return redirect()->route('web.login');
            }
            $products = Favorite::where('user_id', Auth::id())
                ->whereHas('product', function ($query) use ($rangeInputMin, $rangeInputMax, $brandId) {
                    $query->where('status', 1)
                        ->where('price', '>=', $rangeInputMin)
                        ->where('price', '<=', $rangeInputMax)
                        ->when($brandId, function ($query, $brandId) {
                            return $query->where('brand_id', $brandId);
                        });
                })
                ->with('product')
                ->get();
        }

        return $products;
    }
}
