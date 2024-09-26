<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function createNotification($userId, $type, $title, $body, $productId)
    {
        $notification = new Notification;
        $notification->user_id = $userId;
        $notification->type = $type;
        $notification->title = $title;
        $notification->body = $body;
        $notification->product_id = $productId;
        $notification->is_read = false;
        $notification->save();

        return $notification;
    }

    public function isreaded($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return $notification;
    }
}
