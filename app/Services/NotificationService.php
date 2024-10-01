<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function createNotification(array $data)
    {
        return Notification::create($data);
    }

    public function isreaded($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return $notification;
    }
}
