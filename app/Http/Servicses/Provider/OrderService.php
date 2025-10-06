<?php
namespace App\Http\Servicses\Provider;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService{
    public function getOrdersProvider()
    {
           return Order::where("provider_id",Auth::user()->id)->get();  
    }


     public function getForProvider(array $params = [])
    {
       $providerId=Auth::user()->id;
        $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
        $query = Order::with(['service',"client:id,name,email"])
        ->whereHas("service",function($q) use ($providerId)
        {$q->where("provider_id",$providerId);});
        if(!empty ($params["status"])){
       $query->where("status", $params["status"]);
}
        if (!empty($params['search'])) {
         $serach=$params['search'];
        $query->whereHas("client",function($q) use ($serach)
        {
         $q->where("name","like","%".$serach."%")
         ->orWhere("email","like","%".$serach."%");
 });
       $orderBy=$params["order_by"]??"created_at";
       $direction=$params["order_direction"]??"desc";
       $query->orderBy($orderBy, $direction);
        return $query->paginate($perPage);
    }

    }
    public function changeStatusProvider(Order $order,$status){
$providerId=Auth::user()->id;
if($order->provider_id !== $providerId){
    throw new \Exception("Unauthorized you dont own this order");
}
$order->update(["status"=> $status,"updated_at"=>now()]);


    }

}