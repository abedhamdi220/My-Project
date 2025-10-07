<?php

namespace App\Http\Servicses\Client;

use App\Enums\StatusOrderEnum;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($data, $client_id)
    {
        DB::beginTransaction();
        try {
            $service = Service::where("id", $data['service_id'])->where("status", 'active')->first();
            if (!$service) {
                throw new \Exception('service not found or not acyive');
            }

            $order = Order::create([
                'client_id'    => $client_id,
                'provider_id'  => $service->provider_id,
                'service_id'   => $data['service_id'],
                'status'       => 'pending',
                'client_notes' => $data->note ?? null,

            ]);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("failed to create order:" . $e->getMessage());
        }
    }

    public function  getOrders()
    {
        return Order::whith(['review', 'client', 'provider', 'service'])->where("client_id", Auth::user()->id)->latest()->get();
    }
    public function deleteOrder(order $order)
    {
        if ($order->client_id !== Auth::user()->id) {
            throw new \Exception("error you cab only delete your order");
        }
        return $order->delete();
    }
    public function rateOrder(Order $order, array $data)
    {
       $order_id=$data['order_id'] ?? null;
       $rating=$data['rating'] ?? null;
       $comment=$data['comment'] ?? null;
      $order= $order->with("review")->find($order_id);
       if(!$order)
       {
        throw new \Exception("order not found");
       }
       if($order->client_id !== Auth::user()->id)
       {
        throw new \Exception("error you can only rate your order");
           
       }
       if($order->status !== StatusOrderEnum::COMPLETED)
       {
        throw new \Exception("you can only rate completed order");
       }
       if($order->review)
       {
           throw new \Exception("you already rated this order");
       }
      $review= $order->review()->create([
        'client_id' =>Auth::user()->id,
        'order_id'=>$order_id,
        'rating'=>$rating,
        'comment'=>$comment
        ]);
        return $review;

    }
}
