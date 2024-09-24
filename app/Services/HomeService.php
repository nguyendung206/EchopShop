<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Brand;
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
        $rangeInputMin = isset($request['rangeInputMin']) ? (float) $request['rangeInputMin'] : 0;
        $rangeInputMax = isset($request['rangeInputMax']) ? (float) $request['rangeInputMax'] : PHP_INT_MAX;
        $query = Product::query();
        if (! empty($request['search'])) {
            $query = $query->where('name', 'like', '%'.$request['search'].'%');
        }
        if (! empty($request['province'])) {  // province ở thanh search
            $provinceId = $request['province'];
            $query = $query->whereHas('shop.user.province', function ($query) use ($provinceId) {
                $query->where('id', $provinceId);
            });
        }
        if (! empty($request['brandIds'])) {
            $brandIds = $request['brandIds'];
            $query = $query->whereIn('brand_id', $brandIds);
        }
        if (! empty($request['provinceIds'])) {  // province ở thanh lọc product
            $provinceIds = $request['provinceIds'];
            $query = $query->whereHas('shop.user.province', function ($query) use ($provinceIds) {
                $query->whereIn('id', $provinceIds);
            });
        }
        $products = $query->where('status', 1)
            ->where('price', '>=', $rangeInputMin)
            ->where('price', '<=', $rangeInputMax)
            ->where('type', $type->value)
            ->with(['shop', 'shop.user', 'shop.user.province'])
            ->paginate(9);

        return $products;
    }

    public function search($request)
    {
        $datas = ['products' => [], 'brands' => []];
        if (! empty($request['search'])) {
            $datas['products'] = Product::query()->where('name', 'like', '%'.$request['search'].'%')->where('status', Status::ACTIVE)->take(10)->get();
            $datas['brands'] = Brand::query()->where('name', 'like', '%'.$request['search'].'%')->where('status', Status::ACTIVE)->take(10)->get();
        }

        return $datas;
    }
}
