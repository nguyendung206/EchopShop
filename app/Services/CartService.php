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
                            'product_unit_id' => $request->product_unit_id,
                        ]);
                    }

                    return ['status' => 200, 'message' => 'Thêm vào giỏ hàng thành công!'];
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

                        return ['status' => 200, 'message' => 'Thêm vào giỏ hàng thành công!'];
                    }
                }
            }

            return ['status' => 500, 'message' => 'Đã có lỗi xảy ra'];
        } catch (\Exception $e) {
            Log::error('Error adding to cart: '.$e->getMessage());

            return ['status' => 500, 'message' => 'Đã có lỗi xảy ra'];
        }
    }

    public function check($request)
    {
        $productUnit = ProductUnit::where('product_id', $request->productId)->first();

        if (! $productUnit || $productUnit->type == 1) {
            return [
                'status' => 200,
                'type' => 'direct_add',
                'message' => 'Sản phẩm này có thể thêm trực tiếp vào giỏ hàng.',
            ];
        } elseif ($productUnit->type == 2) {
            $units = ProductUnit::where('product_id', $request->productId)->get();

            return [
                'status' => 200,
                'type' => 'modal',
                'message' => 'Sản phẩm này yêu cầu xác nhận trước khi thêm vào giỏ.',
                'units' => $units,
            ];
        } else {
            return [
                'status' => 500,
                'type' => 'fail',
                'message' => 'Đã có lỗi xảy ra',
            ];
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

    public function updateQuantityCart($request, $id)
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
