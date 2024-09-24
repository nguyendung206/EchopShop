<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart()
    {
        $userId = Auth::id();

        if ($userId) {
            return Cart::where('user_id', $userId)->get();
        }

        return collect();
    }

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

    public function destroy($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
