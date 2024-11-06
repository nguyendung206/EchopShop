<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\StatusOrder;
use App\Enums\TypeDiscountScope;
use App\Enums\TypePayment;
use App\Jobs\SendChangeStatusOrderMail;
use App\Jobs\SendOrderSuccessMail;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\ShippingAddress;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getCartsAndVouchersAndShippingAddresses($request)
    {
        try {
            $userProvinceId = Auth::user()->defaultAddress?->province_id ?? null;
            $userDistrictId = Auth::user()->defaultAddress?->district_id ?? null;
            $userWardId = Auth::user()->defaultAddress?->ward_id ?? null;
            $carts = collect();
            $vouchers = collect();
            $shippindAddresses = collect();
            $datas = [];
            $vouchers = Discount::query()
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))
                ->where(function ($query) use ($userProvinceId, $userDistrictId, $userWardId) {
                    $query->where('scope_type', '<>', TypeDiscountScope::REGIONAL->value)
                        ->orWhere(function ($subQuery) use ($userProvinceId, $userDistrictId, $userWardId) { // regional type
                            $subQuery->where('scope_type', TypeDiscountScope::REGIONAL->value)
                                ->where('province_id', $userProvinceId) //province
                                ->where(function ($innerSubQuery) use ($userDistrictId, $userWardId) {
                                    $innerSubQuery->where(function ($districtQuery) use ($userDistrictId) { // district
                                        $districtQuery->where('district_id', $userDistrictId)
                                            ->orWhereNull('district_id');
                                    })
                                        ->where(function ($wardQuery) use ($userWardId) {   // ward
                                            $wardQuery->where('ward_id', $userWardId)
                                                ->orWhereNull('ward_id');
                                        });
                                });
                        });
                })
                ->get()
                ->filter(function ($voucher) {  // lấy hết danh sách rồi lọc
                    $userUsed = explode(',', $voucher->user_used);
                    $countUser = array_count_values($userUsed);   // đưa phần tử thành key và số lần xuất hiện thành value
                    $userId = Auth::id();

                    return ! isset($countUser[$userId]) || $countUser[$userId] < $voucher->limit_uses;
                })
                ->values();    // đánh lại index của collect
            if (! empty($request['cart_ids'])) {
                $cartIds = $request['cart_ids'];
                $carts = Cart::whereIn('id', $cartIds)->get();
            }
            $shippindAddresses = ShippingAddress::where('user_id', Auth::id())->get();
            $feeship = Feeship::where('province_id', $userProvinceId)->where('district_id', $userDistrictId)->where('ward_id', $userWardId)->first();
            $datas = [
                'carts' => $carts,
                'vouchers' => $vouchers,
                'shippingAddresses' => $shippindAddresses,
                'feeship' => $feeship,
            ];

            return $datas;
        } catch (\Exception $e) {

            return $e;
        }
    }

    public function getVouchersJson($request)
    {
        try {
            $userProvinceId = $request['province_id'];
            $userDistrictId = $request['district_id'];
            $userWardId = $request['ward_id'];
            $vouchers = Discount::query()
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))
                ->where(function ($query) use ($userProvinceId, $userDistrictId, $userWardId) {
                    $query->where('scope_type', '<>', TypeDiscountScope::REGIONAL->value)
                        ->orWhere(function ($subQuery) use ($userProvinceId, $userDistrictId, $userWardId) { // regional type
                            $subQuery->where('scope_type', TypeDiscountScope::REGIONAL->value)
                                ->where('province_id', $userProvinceId) //province
                                ->where(function ($innerSubQuery) use ($userDistrictId, $userWardId) {
                                    $innerSubQuery->where(function ($districtQuery) use ($userDistrictId) { // district
                                        $districtQuery->where('district_id', $userDistrictId)
                                            ->orWhereNull('district_id');
                                    })
                                        ->where(function ($wardQuery) use ($userWardId) {   // ward
                                            $wardQuery->where('ward_id', $userWardId)
                                                ->orWhereNull('ward_id');
                                        });
                                });
                        });
                })
                ->with(['ward', 'district', 'province'])
                ->get()
                ->filter(function ($voucher) {  // lấy hết danh sách rồi lọc
                    $userUsed = explode(',', $voucher->user_used);
                    $countUser = array_count_values($userUsed);   // đưa phần tử thành key và số lần xuất hiện thành value
                    $userId = Auth::id();

                    return ! isset($countUser[$userId]) || $countUser[$userId] < $voucher->limit_uses;
                })
                ->values();

            return $vouchers;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function store($request)
    {
        try {
            $user = Auth::user();
            $orderData = [
                'total_amount' => $request['total_amount'],
                'type_payment' => TypePayment::CARD,
                'user_id' => $user->id,
                'status' => StatusOrder::PENDING,
                'shipping_address' => $request['shipping_address'],
                'province_id' => $request['province_id_order'],
                'district_id' => $request['district_id_order'],
                'ward_id' => $request['ward_id_order'],
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
            })->where('user_id', Auth::id())->with(['discount', 'orderDetails.product', 'orderDetails.productUnit'])
                ->orderBy('created_at', 'DESC')
                ->get();

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

        return $query->with(['discount', 'customer', 'province', 'district', 'ward'])->paginate(15);
    }

    public function getOrderById($id)
    {
        $order = Order::query()->with(['customer', 'orderDetails.product', 'discount'])->findOrFail($id);

        return $order;
    }

    public function updateStatus($request, $id)
    {
        try {
            $order = Order::with(['customer', 'orderDetails.productUnit','ward','district','province'])->findOrFail($id);
            $statusInit = $order->status->value;
            $order->status = $request['status'];
            if (! empty($request['cancel_reason'])) {
                $order->cancel_reason = $request['cancel_reason'];
            }
            $order->save();
            $orderDetails = $order->orderDetails;
            if ($request['status'] == StatusOrder::CANCELLED->value || $request['status'] == StatusOrder::RETURN->value) {
                foreach ($orderDetails as $orderDetail) {
                    $productUnit = $orderDetail->productUnit;
                    $productUnit->quantity = $productUnit->quantity + $orderDetail->quantity;
                    $productUnit->save();
                }
            }
            if ($statusInit != $request['status']) {
                $emailJob = new SendChangeStatusOrderMail($order, $order->customer->email);
                dispatch($emailJob);
            }

            return $order;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function create()
    {
        try {
            $products = Product::with('productUnits')->where('status', 1)->get();
            $customers = User::where('status', 1)->with(['addresses.province', 'addresses.district', 'addresses.ward'])->get();

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
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
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

    public function getOrders($perPage)
    {
        try {
            if (! Auth::check()) {
                return [];
            }

            return Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate($perPage);

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
