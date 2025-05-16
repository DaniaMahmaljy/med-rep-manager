<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexNotificationRequest;
use App\Http\Resources\NotificationResource;
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
        $result = $this->notificationService->index($data);

       $responseData = [
        'data' => NotificationResource::collection($result['notifications']),
        'meta' => [
            'unread_count' => $result['unread_count'] ?? 0,
            'total_count' => $result['total_count'] ?? 0
        ]
    ];

         return $this->answer(data: $responseData);
    }
}
