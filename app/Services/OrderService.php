<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use App\Enums\Status;
use Carbon\Carbon;
use App\Models\Cart;

use Exception;

class OrderService
{   
    public function index ($request) {
        try {
            $carts = collect(); 
            $vouchers = collect();
            $datas = [];
            $vouchers = Discount::query()->where('status', Status::ACTIVE)->where('end_time', '>=', Carbon::now('Asia/Bangkok'))->get();

            if (!empty($cartIds)) {
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
                'message' => $request['message'],
            ];
            if(!empty($request['discount_id'])){
                $orderData['discount_id'] = $request['discount_id'];
            }
            $order = Order::create($orderData);
            if(!empty($request['carts'])) {
                foreach($request['carts'] as $cart){
                    $decoded = json_decode($cart, true);
                    OrderDetail::create([
                        'product_id' => $decoded['products']['id'],
                        'order_id' => $order->id,
                        'quantity' => $decoded['quantity'],
                    ]);
                }
            }

            return $order;
        } catch (Exception $e) {
            return $e;
        }

    }

    
}
