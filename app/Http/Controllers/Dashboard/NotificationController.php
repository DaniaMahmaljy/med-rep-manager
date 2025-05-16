<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
     {

     }

    public function index(IndexNotificationRequest $request)
    {
        $data = $request->afterValidation();

        $result= $this->notificationService->index($data);

        return view('notifications.index', [
        'notifications' => $result['notifications'],
        'unreadCount' => $result['unread_count']
    ]);

    }

    public function markAsRead($id)
    {
        $url = $this->notificationService->markAsReadAndGetRedirectUrl($id);

        return $url ? redirect($url)  : redirect()->route('notifications.index');
    }
}
