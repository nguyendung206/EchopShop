<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;

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
}
