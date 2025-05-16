<?php

namespace App\Services;

use Auth;

class NotificationService extends Service
{
     public function index($data, $paginated = true)
    {
        $user = $data['user'];
        $query = $user->notifications();

        if (!empty($data['unread'])) {
            $query->whereNull('read_at');
        }
     $unreadCount = $user->unreadNotifications()->count();
     $totalCount = $user->notifications()->count();


        if ($paginated) {
            return [
                'notifications' => $query->paginate(),
                'unread_count' => $unreadCount,
                'total_count' => $totalCount
            ];
        }

        return [

            'notifications' => $query->get(),
            'unread_count' => $unreadCount,
             'total_count' => $totalCount()
        ];
    }


    public function markAsReadAndGetRedirectUrl($notificationId)
    {
        $user = Auth::user();

        $notification = $user->notifications()->findOrFail($notificationId);

        $notification->markAsRead();

        $data = $notification->data;

        return $data['url'] ?? null;
    }
}
