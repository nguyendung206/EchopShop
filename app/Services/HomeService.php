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

    public function filterProducts($request)
    {
        $type = $request['type'] ?? null;
        $categorySlug = $request['categorySlug'] ?? null;
        $brandSlug = $request['brandSlug'] ?? null;
        $rangeInputMin = isset($request['rangeInputMin']) ? (float) $request['rangeInputMin'] : 0;
        $rangeInputMax = isset($request['rangeInputMax']) ? (float) $request['rangeInputMax'] : config('setting.max_price_filter');
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

        if (! empty($request['brandIds']) && ! empty($request['categoryIds'])) {  // nếu có cả 2
            $brandIds = $request['brandIds'];
            $categoryIds = $request['categoryIds'];

            $query = $query->where(function ($query) use ($brandIds, $categoryIds) {
                $query->whereIn('brand_id', $brandIds)
                    ->orWhereIn('category_id', $categoryIds);
            });
        } else {                                                                // Nếu có 1 trong 2
            if (! empty($request['brandIds'])) {
                $brandIds = $request['brandIds'];
                $query = $query->whereIn('brand_id', $brandIds);
            }

            if (! empty($request['categoryIds'])) {
                $categoryIds = $request['categoryIds'];
                $query = $query->whereIn('category_id', $categoryIds);
            }
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
            ->when($type, function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                return $query->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                });
            })
            ->when($brandSlug, function ($query) use ($brandSlug) {
                return $query->whereHas('brand', function ($query) use ($brandSlug) {
                    $query->where('slug', $brandSlug);
                });
            })
            ->with('category')
            ->with('brand')
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
