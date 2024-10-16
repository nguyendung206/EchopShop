<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use App\Jobs\SendChangeStatusOrderMail;
use App\Jobs\SendOrderSuccessMail;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\User;
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
                $cart = Cart::with(['products', 'productUnit'])->find($cartId);
                $messageKey = 'message-'.$cartId; // message của từng cart
                $message = array_key_exists($messageKey, $request) ? $request[$messageKey] : null;

                // tạo chi tiết
                OrderDetail::create([
                    'product_id' => $cart->products->id,
                    'order_id' => $order->id,
                    'quantity' => $cart->quantity,
                    'message' => $message,
                    'product_unit_id' => $cart->productUnit->id,
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
            })->where('user_id', Auth::id())->with(['discount', 'orderDetails.product', 'orderDetails.productUnit'])->get();

            return $orders;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function index($request)
    {

        $query = Order::query();
        if (! empty($request['search'])) {
            $query->where('shipping_address', 'like', '%'.$request['search'].'%');
        }
        if (! empty($request['status'])) {
            $query->where('status', $request['status']);
        }
        if (! empty($request['daterange'])) {
            $dates = explode(' - ', $request['daterange']);
            $startDay = Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay();
            $endDay = Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay();
            $query->whereBetween('created_at', [$startDay, $endDay]);
        }
        if (! empty($request['min']) && ! empty($request['max'])) {
            $min = $request['min'];
            $max = $request['max'];
            $query->whereBetween('total_amount', [$min, $max]);
        }

        return $query->with(['discount', 'customer'])->paginate(15);
    }

    public function getOrderById($id)
    {
        $order = Order::query()->with(['customer', 'orderDetails.product', 'discount'])->findOrFail($id);

        return $order;
    }

    public function updateStatus($request, $id)
    {
        try {
            $order = Order::with('customer')->findOrFail($id);
            $statusInit = $order->status->value;

            $order->status = $request['status'];
            $order->save();

            if ($statusInit != $request['status']) {
                $emailJob = new SendChangeStatusOrderMail($order, $order->customer->email);
                dispatch($emailJob);
            }

            return $order;
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function create()
    {
        try {
            $products = Product::with('productUnits')->where('status', 1)->get();
            $customers = User::where('status', 1)->get();

            return ['products' => $products, 'customers' => $customers];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeCMS($request)
    {
        try {
            $orderData = [
                'total_amount' => $request['total_amount'],
                'type_payment' => TypePayment::CARD,
                'shipping_address' => $request['shipping_address'],
                'user_id' => $request['customerId'],
                'status' => StatusOrder::PENDING,
            ];
            if (! empty($request['discountId'])) {
                $orderData['discountId'] = $request['discountId'];
            }
            // tạo hoá đơn
            if (! empty($request['discountId'])) {
                $orderData['discount_id'] = $request['discountId'];
            }
            $order = Order::create($orderData);

            // Trừ số lượng mã giảm giá
            if (! empty($request['discountId'])) {
                $discount = Discount::findOrFail($request['discountId']);
                $discount->increment('quantity_used');
                $discount->user_used = $discount->user_used
                    ? $discount->user_used.','.$request['customerId']
                    : $request['customerId'];
                $discount->save();
            }
            // lấy ra các product-unit đã chọn
            $productUnits = [];
            foreach ($request as $key => $value) {
                if (strpos($key, 'quantity-') === 0) {
                    $productUnitId = str_replace('quantity-', '', $key);
                    $quantity = $value;
                    $productUnits[$productUnitId] = $quantity;
                }
            }
            foreach ($productUnits as $productUnitId => $quantity) {
                $productUnit = ProductUnit::with('product')->find($productUnitId);
                if ($productUnit) {
                    $currentQuantity = $productUnit->quantity;
                    $newQuantity = $currentQuantity - $quantity;
                    if ($newQuantity > 0) {
                        $productUnit->quantity = $newQuantity;
                        $productUnit->save();
                    } else {
                        $productUnit->quantity = 0;
                        $productUnit->save();
                    }
                }

                OrderDetail::create([
                    'product_id' => $productUnit->product->id,
                    'order_id' => $order->id,
                    'quantity' => $quantity,
                    'product_unit_id' => $productUnitId,
                ]);
            }

            // lấy thông tin đưa vào mail
            $orderCreated = Order::query()
                ->where('id', $order->id)
                ->with([
                    'discount',
                    'customer.province',
                    'customer.district',
                    'customer.ward',
                    'orderDetails.product',
                ])
                ->first();
            $emailUser = User::find($request['customerId'])->email;
            $emailJob = new SendOrderSuccessMail($emailUser, $orderCreated);
            dispatch($emailJob);

            return $order;
        } catch (Exception $e) {

            return $e;
        }
    }
}
