<?php
namespace App\Http\Controllers\Provider;
use App\Http\Controllers\Controller;
use App\Http\Servicses\Provider\NotificationService as ProviderNotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
      protected $notificationService;
    public function __construct(ProviderNotificationService $notificationService )
    {
        $this->notificationService = $notificationService;
    }
       public function getNotifications(){
       $provider= Auth::user();
        $order = $this->notificationService->getNotificationProvider($provider);
        return response()->json($order,200);

    }
    public function markAsRead($notificationId){
       $provider= Auth::user();
        $notification  = $this->notificationService->markNotificationAsRead($provider, $notificationId);
        return response()->json(["message"=>'notification marked as read','Notification'=>$notification],200);
    }
}
