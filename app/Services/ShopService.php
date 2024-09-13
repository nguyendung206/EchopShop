<?php

namespace App\Services;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;

class ShopService
{
    public function createShop(ShopRequest $request)
    {
        $shop = new Shop;
        $shop->name = $request->name;
        $shop->hotline = $request->hotline;
        $shop->email = $request->email;
        $shop->open = $request->open;
        $shop->close = $request->close;
        $shop->address = $request->address;
        $shop->user_id = $request->user_id;
        if ($request->hasFile('logo')) {
            $shop->logo = uploadImage($request->file('logo'), 'upload/shop/');
        } else {
            $shop->logo = 'logoshop.png';
        }

        $shop->save();

        return $shop;
    }
}
