<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\UserService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $userService;

    protected $orderService;

    public function __construct(UserService $userService, OrderService $orderService, CartService $cartService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function getCartsAndVouchers(Request $request)
    {

        $datas = $this->orderService->getCartsAndVouchers($request->all());
        return view('web.order.order', ['orderCarts' => $datas['carts'], 'vouchers' => $datas['vouchers']]);
    }

    public function changeAddress(Request $request)
    {
        $result = $this->userService->changeAddress($request->all());
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

    public function updateStatusOrder(Request $request) {
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

    public function restoreCart(Request $request, $idOrder) {
        try {
            $result = $this->cartService->restoreCart($request,$idOrder);
            if($result) {
                return redirect()->route('cart.index')->with('success', 'Đơn hàng đã được khôi phục thành công!');
            } else {
                return redirect()->back()->with('error', 'Mua lại đơn hàng không thành công!');
            }
        } catch (\Exception $e) {
            return $e;        
        }
    }
}
