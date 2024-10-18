<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\UserService;
use Exception;
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
