<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function store($request)
    {
        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->productId)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->increment('quantity');

            return $existingCartItem;
        } else {
            $newCartItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->productId,
                'quantity' => 1,
            ]);

            return $newCartItem;
        }
    }
}
