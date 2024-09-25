<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function createNotification($userId, $type, $title, $body)
    {
        $notification = new Notification;
        $notification->user_id = $userId;
        $notification->type = $type;
        $notification->title = $title;
        $notification->body = $body;
        $notification->is_read = false;
        $notification->save();

        return $notification;
    }
}
