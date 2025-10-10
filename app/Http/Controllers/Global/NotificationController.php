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
       $this->notificationService->listNotifications($request->user());
        return view("", compact("notifications"));
    }
    public function unreadCount(Request $request){
        $this->notificationService->getUnreadCount($request->user());
     
        return view("", compact("count"));

    }
    public function readCount(Request $request){
        $this->notificationService->markAllAsread($request->user());
        
        return view("", compact("marker"));
    }

}
