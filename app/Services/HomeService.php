<?php

namespace App\Services;

use App\Models\Product;
use App\Enums\TypeProduct;


class HomeService
{
    public function getProduct($type, $perPage, $pageName)
    {
        $query = Product::query();
        $products = $query->where('status', 1)->where('type', $type)->paginate($perPage, ['*'], $pageName);

        return $products;
    }

    public function filterProducts($request) {
        $type = TypeProduct::EXCHANGE;; // Giá trị mặc định
        $currentUrl = $request->url();

        switch (true) {
            case strpos($currentUrl, 'exchange') !== false:
                $type = TypeProduct::EXCHANGE;
                break;
            case strpos($currentUrl, 'secondhand') !== false:
                $type = TypeProduct::SECONDHAND;
                break;
            case strpos($currentUrl, 'GIVEAWAY') !== false:
                $type = TypeProduct::GIVEAWAY;
                break;
            default:
                break;
        }

        $rangeInputMin = $request->query('rangeInputMin') !== null ? (float) $request->query('rangeInputMin') : 0;
        $rangeInputMax = $request->query('rangeInputMax') !== null ? (float) $request->query('rangeInputMax') : PHP_INT_MAX;
        $brandId = $request->query('brandId');
        $products = Product::query()->where('status', 1)
                                    ->where('price', '>=',$rangeInputMin)
                                    ->where('price', '<=',$rangeInputMax)
                                    ->when($brandId, function($query, $brandId) {
                                        return $query->where('brand_id', $brandId);
                                    })
                                    ->where('type', $type)->get();
        $data = ['products' => $products,
                'productHtml' => view('web.product.listProduct', compact('products'))->render(),
                'provinceIds' => $request->query('provinceIds'),
                'rangeInputMin' => $request->query('rangeInputMin'),
                'rangeInputMax' => $request->query('rangeInputMax'),
                'option' => $request->query('option'),];
        return $data;
    }
}
