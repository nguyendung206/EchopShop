<?php

namespace App\Services;

use App\Models\Product;

class HomeService
{
    public function getProduct($type, $perPage, $pageName)
    {
        $query = Product::query();
        $products = $query->where('status', 1)->where('type', $type)->with('shop')->paginate($perPage, ['*'], $pageName);

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
            ->where('type', $type)
            ->with(['shop', 'shop.user', 'shop.user.province'])
            ->paginate(9);

        return $products;
    }
}
