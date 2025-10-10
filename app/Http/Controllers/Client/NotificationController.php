<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Servicses\Client\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function getNotifications()
    {
        $client = Auth::user();
        $notifications = $this->notificationService->getNotificationClient($client);
        return response()->json(["message" => 'your Notifications', 'Notifications' => $notifications], 200);
    }
    public function markAsRead($notificationId)
    {
        $client = Auth::user();
        $notification  = $this->notificationService->markNotificationAsRead($client, $notificationId);
        return response()->json(["message" => 'notification marked as read', 'Notification' => $notification], 200);
    }
}
