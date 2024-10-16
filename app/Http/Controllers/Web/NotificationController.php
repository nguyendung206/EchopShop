<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function isreaded($id)
    {
        $notification = $this->notificationService->isreaded($id);

        return redirect()->route('web.productdetail.index', ['slug' => $notification->product->slug]);
    }

    public function readAll()
    {
        $user = Auth::user();

        // Đánh dấu tất cả thông báo là đã đọc
        Notification::where('user_id', $user->id)->update(['is_read' => true]);

        return response()->json([
            'status' => 200,
        ]);
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
