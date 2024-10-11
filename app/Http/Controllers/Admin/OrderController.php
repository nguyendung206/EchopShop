<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->index($request->all());

        return view('admin.order.index', compact('orders'));
    }

    public function create(Request $request)
    {
        try {
            $orders = $this->orderService->index($request->all());

            return view('admin.order.index', compact('orders'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function show($id)
    {
        try {
            $order = $this->orderService->getOrderById($id);

            return view('admin.order.show', compact('order'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = $this->orderService->updateStatus($request->all(), $id);
            flash('Thay đổi trạng thái thành công!')->success();

            return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
