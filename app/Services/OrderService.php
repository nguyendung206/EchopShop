<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use App\Jobs\SendOrderSuccessMail;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductUnit;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getCartsAndVouchers($request)
    {
        try {
            $carts = collect();
            $vouchers = collect();
            $datas = [];
            $vouchers = Discount::query()
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))->get();
            if (! empty($request['cart_ids'])) {
                $cartIds = $request['cart_ids'];
                $carts = Cart::whereIn('id', $cartIds)->with('products')->get();
            }
            $datas = [
                'carts' => $carts,
                'vouchers' => $vouchers,
            ];

            return $datas;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store($request)
    {
        try {
            $orderData = [
                'total_amount' => $request['total_amount'],
                'type_payment' => TypePayment::CARD,
                'shipping_address' => $request['shipping_address'],
                'user_id' => Auth::id(),
                'status' => StatusOrder::PENDING,
            ];
            if (! empty($request['discount_id'])) {
                $orderData['discount_id'] = $request['discount_id'];
            }
            // tạo hoá đơn
            $order = Order::create($orderData);
            // Trừ số lượng mã giảm giá
            if (! empty($request['discount_id'])) {
                $discount = Discount::findOrFail($request['discount_id']);
                $discount->increment('quantity_used');
                $discount->user_used = $discount->user_used
                    ? $discount->user_used.','.Auth::id()
                    : Auth::id();
                $discount->save();
            }

            foreach ($request['cartIds'] as $cartId) {
                $cart = Cart::with('products')->find($cartId);
                $messageKey = 'message-'.$cartId; // message của từng cart
                $message = array_key_exists($messageKey, $request) ? $request[$messageKey] : null;

                // tạo chi tiết
                OrderDetail::create([
                    'product_id' => $cart->products->id,
                    'order_id' => $order->id,
                    'quantity' => $cart->quantity,
                    'message' => $message,
                ]);

                // cập nhật lại số lượng của hàng
                $productUnit = ProductUnit::find($cart->product_unit_id);
                $newQuantity = $productUnit->quantity - $cart->quantity;
                $productUnit->update([
                    'quantity' => $newQuantity,
                ]);

                // xoá khỏi giỏ
                Cart::where('id', $cartId)->delete();
            }

            // lấy thông tin đưa vào mail
            $orderCreated = Order::query()
                ->where('id', $order->id)
                ->where('user_id', Auth::id())
                ->with([
                    'discount',
                    'customer.province',
                    'customer.district',
                    'customer.ward',
                    'orderDetails.product',
                ])
                ->first();
            $emailUser = Auth::user()->email;
            $emailJob = new SendOrderSuccessMail($emailUser, $orderCreated);
            dispatch($emailJob);

            return $order;
        } catch (Exception $e) {

            return $e;
        }

    }

    public function purchase($request)
    {
        try {
            $orders = Order::query()->when(isset($request['type']) && ! empty($request['type']), function ($query) use ($request) {
                return $query->where('status', $request['type']);
            })->where('user_id', Auth::id())->with('discount')->with('orderDetails.product')->get();

            return $orders;
        } catch (Exception $e) {
            return $e;
        }
    }
}
