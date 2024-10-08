<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

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

    public function getNotifications($perPage)
    {
        try {
            if (! Auth::check()) {
                return [];
            }

            return Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate($perPage);

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
