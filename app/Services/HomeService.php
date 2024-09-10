<?php

namespace App\Services;

use App\Models\Product;

class HomeService
{
    public function getProduct($type, $perPage, $pageName)
    {
        $query = Product::query();
        $products = $query->where('status', 1)->where('type', $type)->paginate($perPage, ['*'], $pageName);

        return $products;
    }
}

