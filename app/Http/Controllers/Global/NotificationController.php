<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Http\Servicses\Admin\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $service)
    {
        $this->notificationService = $service;

    }
    public function index(Request $request){
       $notifications=$this->notificationService->listNotifications($request->user());
        return view("admin.notifications.index", compact("notifications"));
    }
    public function unreadCount(Request $request){
       $count= $this->notificationService->getUnreadCount($request->user());
     
           return response()->json(['count' => $count]);

    }
    public function readCount(Request $request){
        $this->notificationService->markAllAsRead($request->user());
        
       return response()->json(['success' => true]);;
    }
    public function markAsRead(Request $request, $id)
{
    $notification = $request->user()->notifications()->where('id', $id)->first();
    
    if ($notification) {
        $notification->markAsRead();
    }
    
    return redirect()->back()->with('success', 'Notification markedasread.');
}

}
