<?php

namespace App\Services;

use App\Enums\TypeProduct;
use App\Models\Product;

class HomeService
{
    public function moreSecondhand($request)
    {
        $query = Product::query();
        $secondhandProducts = $query->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->paginate(8, ['*'], 'secondhandPage');

        return $secondhandProducts;
    }

    public function moreExchange($request)
    {
        $query = Product::query();
        $exchangeProducts = $query->where('status', 1)->where('type', TypeProduct::EXCHANGE->value)->paginate(8, ['*'], 'exchangePage');

        return $exchangeProducts;
    }
}

