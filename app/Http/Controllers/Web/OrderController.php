<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $userService;

    protected $orderService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    public function getCartsAndVouchers(Request $request)
    {

        $datas = $this->orderService->getCartsAndVouchers($request->all());

        return view('web.order.order', ['carts' => $datas['carts'], 'vouchers' => $datas['vouchers']]);
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
}
