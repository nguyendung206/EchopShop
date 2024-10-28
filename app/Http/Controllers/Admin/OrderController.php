<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TypeNotification;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    protected $notificationService;

    public function __construct(OrderService $orderService, NotificationService $notificationService)
    {
        $this->orderService = $orderService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->index($request->all());

        return view('admin.order.index', compact('orders'));
    }

    public function create(Request $request)
    {
        try {

            $datas = $this->orderService->create();

            return view('admin.order.create', ['products' => $datas['products'], 'customers' => $datas['customers']]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $order = $this->orderService->storeCMS($request->all());
            flash('Thêm đơn hàng thành công')->success();

            return redirect()->route('admin.order.index');
        } catch (\Throwable $th) {
            throw $th;
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
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at, 'UTC')->setTimezone('Asia/Bangkok')->format('d-m-Y H:i:s');
            $title = 'Đơn hàng đã được cập nhật';
            $body = 'Đơn hàng của quý khách '.$order->customer->name.' đặt lúc '.$date.' đã chuyển thành "'.$order->status->label().'".Vui lòng kiểm tra email của bạn để biết thêm chi tiết.';
            $this->notificationService->createNotification([
                'user_id' => $order->user_id,
                'type' => TypeNotification::CHANGESTATUSORDER,
                'title' => $title,
                'body' => $body,
            ]);
            flash('Thay đổi trạng thái thành công!')->success();

            return redirect()->back();
        } catch (\Exception $e) {
            return $e;
        }
    }
}
