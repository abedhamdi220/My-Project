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
    public function getNotifications(Request $request)
    {
        $client = Auth::user();
        $perPage=$request->get("per_page",10);
        $notifications = $this->notificationService->getNotificationClient($client,$perPage);
        return response()->json(["message" => 'your Notifications', 'Notifications' => $notifications], 200);
    }
    public function markAsRead($notificationId)
    {
        $client = Auth::user();
        $notification  = $this->notificationService->markNotificationAsRead($client, $notificationId);
        return response()->json(["message" => 'notification marked as read', 'Notification' => $notification], 200);
    }
    public function getUnreadCount(){
        $client = Auth::user();
        $count= $this->notificationService->getUnreadCount($client);
        return response()->json([
            'message'=> 'Unread notifications count',
            'count'=> $count],
            200);

    }
}
