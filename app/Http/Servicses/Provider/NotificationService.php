<?php
namespace App\Http\Servicses\Provider;
class NotificationService{
public function getNotificationProvider($provider){
    if (!$provider) {
    throw new \Exception("Unauthorized: please log in as provider");
}

 return $provider->notifications()->orderBy('created_at', 'desc')->get();

}
public function markNotificationAsRead($provider,$notificationId){
    if (!$provider) {
    throw new \Exception("Unauthorized: please log in as provider");
}

$Notification=$provider->Notifications()->findOrFail($notificationId);
$Notification->markAsRead();
 return $Notification;

}
}