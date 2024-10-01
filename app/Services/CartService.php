<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function store(Request $request)
    {
        try {
            $userId = Auth::id();

            // Ensure 'type' exists in the request and is an integer
            if ($request->has('type') && is_numeric($request->type)) {
                if ($request->type == 1) {
                    $existingCartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $request->productId)
                        ->first();

                    if ($existingCartItem) {
                        $existingCartItem->increment('quantity');
                    } else {
                        Cart::create([
                            'user_id' => $userId,
                            'product_id' => $request->productId,
                            'quantity' => 1,
                        ]);
                    }

                    return ['status' => 'success'];
                } elseif ($request->type == 2) {
                    if ($request->has('units') && is_array($request->units)) {
                        foreach ($request->units as $unit) {
                            Cart::create([
                                'user_id' => $userId,
                                'product_id' => $request->productId,
                                'color' => $unit['color'],
                                'size' => $unit['size'],
                                'quantity' => $unit['quantity'],
                            ]);
                        }

                        return ['status' => 'success'];
                    }
                }
            }

            return ['status' => 'fail'];
        } catch (\Exception $e) {
            Log::error('Error adding to cart: '.$e->getMessage());

            return ['status' => 'fail', 'message' => 'Đã có lỗi xảy ra'];
        }
    }

    public function check($request)
    {
        $productUnit = ProductUnit::where('product_id', $request->productId)->first();

        if (! $productUnit || $productUnit->type == 1) {
            return [
                'status' => 'direct_add',
                'message' => 'Sản phẩm này có thể thêm trực tiếp vào giỏ hàng.',
            ];
        } elseif ($productUnit->type == 2) {
            $units = ProductUnit::where('product_id', $request->productId)->get();

            return [
                'status' => 'modal',
                'message' => 'Sản phẩm này yêu cầu xác nhận trước khi thêm vào giỏ.',
                'units' => $units,
            ];
        } else {
            return [
                'status' => 'fail',
                'message' => 'Đã có lỗi xảy ra',
            ];
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

    public function updateQuantity($id, $quantity)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->quantity = $quantity;
            $cart->save();

            return $cart;
        }

        return null;
    }
}
