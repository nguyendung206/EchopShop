<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use App\Jobs\SendOrderSuccessMail;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\DiscountUser;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductUnit;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function index($request)
    {
        try {
            $carts = collect();
            $vouchers = collect();
            $datas = [];
            $vouchers = Discount::query()
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))->with('discountUsers')->get();
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

                $discountUser = DiscountUser::where('user_id', Auth::id())
                    ->where('discount_id', $discount->id)
                    ->first();
                if ($discountUser) {
                    // Nếu đã có bản ghi, tăng number_used lên 1
                    $discountUser->increment('number_used');
                } else {
                    // Nếu chưa có, tạo mới bản ghi
                    DiscountUser::create([
                        'user_id' => Auth::id(),
                        'discount_id' => $discount->id,
                        'number_used' => 1,
                    ]);
                }

            }

            foreach ($request['carts'] as $cart) {
                $decoded = json_decode($cart, true);
                $cartId = $decoded['id'];
                $messageKey = 'message-'.$cartId; // message của từng cart
                $message = array_key_exists($messageKey, $request) ? $request[$messageKey] : null;

                // tạo chi tiết
                OrderDetail::create([
                    'product_id' => $decoded['products']['id'],
                    'order_id' => $order->id,
                    'quantity' => $decoded['quantity'],
                    'message' => $message,
                ]);

                // cập nhật lại số lượng của hàng
                $productUnit = ProductUnit::find($decoded['product_unit_id']);
                $newQuantity = $productUnit->quantity - $decoded['quantity'];
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
            dd($e);

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
