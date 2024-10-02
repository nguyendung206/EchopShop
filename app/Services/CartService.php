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
        try {
            $existingCartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->productId)
                ->when($request->productUnitId, function ($query) use ($request) {
                    return $query->where('product_unit_id', $request->productUnitId);
                })
                ->first();
            if ($existingCartItem) {
                $countProductUnit = $existingCartItem->products->getProductUnitById($request->productUnitId)->quantity;
                if (! empty($request->quantity) && $request->quantity + $existingCartItem->quantity > $countProductUnit) {
                    $request->quantity = $countProductUnit;
                    $existingCartItem->update(['quantity' => $request->quantity]);
                } else {
                    $existingCartItem->increment('quantity', $request->quantity ?? 1);
                }

                return $existingCartItem;
            } else {
                $newCartItem = Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->productId,
                    'quantity' => $request->quantity ?? 1,
                    'product_unit_id' => $request->productUnitId,
                ]);

                return $newCartItem;
            }
        } catch (\Exception $e) {
            dd($e);
            return $e;
        }
    }

    public function updateProductUnit($request, $id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->update([
                'product_unit_id' => $request['productUnitId'],
            ]);

            return $cart;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function updateQuantity($request, $id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->update([
                'quantity' => $request['quantity'],
            ]);

            return $cart;
        } catch (\Throwable $th) {
            return false;
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
