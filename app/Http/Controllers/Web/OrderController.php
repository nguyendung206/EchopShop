<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ShippingAddressService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $shippingAddressService;

    protected $cartService;

    protected $orderService;

    public function __construct(ShippingAddressService $shippingAddressService, OrderService $orderService, CartService $cartService)
    {
        $this->shippingAddressService = $shippingAddressService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function getCartsAndVouchersAndShippingAddresses(Request $request)
    {

        $datas = $this->orderService->getCartsAndVouchersAndShippingAddresses($request->all());

        return view('web.order.order', ['orderCarts' => $datas['carts'], 'vouchers' => $datas['vouchers'], 'shippingAddresses' => $datas['shippingAddresses'], 'feeship' => $datas['feeship']]);
    }

    public function getVouchersJson(Request $request)
    {
        $vouchers = $this->orderService->getVouchersJson($request->all());
        if ($vouchers) {

            return response()->json([
                'status' => 200,
                'vouchers' => $vouchers,
                'message' => 'Danh sách mã giảm giá theo địa chỉ.',
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi xảy ra.',
            ]);
        }
    }

    public function addAddress(Request $request)
    {
        try {
            $result = $this->shippingAddressService->addAddress($request->all());
            if ($request->ajax() || $request->wantsJson()) {
                if ($result) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Thêm địa chỉ thành công.',
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Thêm địa chỉ thất bại.',
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Thêm địa chỉ thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Thêm địa chỉ thất bại');
        }
    }

    public function changeAddress(Request $request)
    {
        try {
            $result = $this->shippingAddressService->changeAddress($request->all());
            if ($request->ajax() || $request->wantsJson()) {
                if ($result) {

                    return response()->json([
                        'status' => 200,
                        'message' => 'Thay đổi địa chỉ thành công.',
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Thay đổi địa chỉ thất bại.',
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Thay đổi địa chỉ thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Thay đổi địa chỉ thất bại');
        }
    }

    public function store(Request $request)
    {
        try {
            $order = $this->orderService->store($request->all());

            return view('web.order.orderSuccess');
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function purchase(Request $request)
    {
        try {
            $orders = $this->orderService->purchase($request->all());

            return view('web.order.purchase', compact('orders'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateStatusOrder(Request $request)
    {
        try {
            $id = $request->orderId;
            $updated = $this->orderService->updateStatus($request->all(), $id);
            if ($updated) {
                return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
            } else {
                return redirect()->back()->with('error', 'Cập nhật trạng thái đơn hàng không thành công!');
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function restoreCart(Request $request, $idOrder)
    {
        try {
            $result = $this->cartService->restoreCart($request, $idOrder);
            if ($result) {
                return redirect()->route('cart.index')->with('success', 'Đơn hàng đã được khôi phục thành công!');
            } else {
                return redirect()->back()->with('error', 'Mua lại đơn hàng không thành công!');
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function show(Request $request)
    {
        try {
            $datas = $this->orderService->getOrders(10);

            if ($request->ajax()) {
                $orderHtml = view('web.order.moreOrders', compact('datas'))->render();
                $hasMorePage = $datas->hasMorePages();

                return response()->json([
                    'orders' => $orderHtml,
                    'hasMorePage' => $hasMorePage,
                ]);
            }

            return view('web.order.orderlist', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách đơn hàng!')->error();

            return redirect()->back();
        }
    }
}
