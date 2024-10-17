<?php

namespace App\Http\Controllers\web;

use App\Enums\TypeNotification;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    protected $orderService;

    public function __construct(NotificationService $notificationService, OrderService $orderService)
    {
        $this->notificationService = $notificationService;
        $this->orderService = $orderService;
    }

    public function isreaded($id)
    {
        $notification = $this->notificationService->isreaded($id);
        // dd($notification);
        if ($notification->type->value == TypeNotification::CHANGESTATUSORDER->value) {
            $orders = $this->orderService->purchase(['type' => null]);

            return view('web.order.purchase', compact('orders'));
        }

        return redirect()->route('web.productdetail.index', ['slug' => $notification->product->slug]);
    }

    public function index(Request $request)
    {
        try {
            $datas = $this->notificationService->getNotifications(10);
            if ($request->ajax()) {
                $productHtml = view('web.profile.moreNotification', compact('datas'))->render();
                $hasMorePage = $datas->hasMorePages();

                return response()->json([
                    'posts' => $productHtml,
                    'hasMorePage' => $hasMorePage,
                ]);
            }

            return view('web.profile.notification', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách thông báo!')->error();

            return redirect()->back();
        }
    }
}
