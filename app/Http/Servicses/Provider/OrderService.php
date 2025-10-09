<?php

namespace App\Http\Servicses\Provider;

use App\Models\Order;
use App\Notifications\StatusChangeNotifications;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getOrdersProvider()
    {
        return Order::where("provider_id", Auth::user()->id)->get();
    }


    public function getForProvider(array $params = [])
    {
        $providerId = Auth::user()->id;
        $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
        $query = Order::with(['service', "client:id,name,email"])
            ->whereHas("service", function ($q) use ($providerId) {
                $q->where("provider_id", $providerId);
            });
        if (!empty($params["status"])) {
            $query->where("status", $params["status"]);
        }
        if (!empty($params['search'])) {
            $serach = $params['search'];
            $query->whereHas("client", function ($q) use ($serach) {
                $q->where("name", "like", "%" . $serach . "%")
                    ->orWhere("email", "like", "%" . $serach . "%");
            });
            $orderBy = $params["order_by"] ?? "created_at";
            $direction = $params["order_direction"] ?? "desc";
            $query->orderBy($orderBy, $direction);
            return $query->paginate($perPage);
        }
    }
    public function changeStatusProvider(Order $order, $status,$provider)
    {
      
if (!$provider) {
    throw new \Exception("Unauthorized: please log in as provider");
}
     
        if ($order->provider_id !== $provider->id) {
            throw new \Exception("Unauthorized you dont own this order");
        }
        $oldStatus = $order->status;
        $newStatus = $order->update(['status' => $status]);
         if ($order->client) {
                $order->client->notify(new StatusChangeNotifications($order, $oldStatus, $newStatus));

       
    }
     return $order;
}
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
