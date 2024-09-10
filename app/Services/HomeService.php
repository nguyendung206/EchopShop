<?php

namespace App\Services;

use App\Models\Product;

class HomeService
{
    public function moreSecondhand($request)
    {
        $query = Product::query();
        $secondhandProducts = $query->where('status', 1)->paginate(4);

        return $secondhandProducts;
    }
}
