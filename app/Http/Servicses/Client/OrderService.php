<?php

namespace App\Http\Servicses\Client;

use App\Enums\StatusOrderEnum;
use App\Mail\OrderRatingNotifcations;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewOrderNotifications;
use App\Notifications\OrderRatedNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function createOrder( array $data, $client_id)
    {
        DB::beginTransaction();

        try {
            $service = Service::where("id", $data['service_id'])
            ->where("status", 'active')
            ->first();
            if (!$service) {
                throw new \Exception('service not found or not acive');
            }

            $order = Order::create([
                'client_id'    => $client_id,
                'provider_id'  => $service->provider_id,
                'service_id'   => $data['service_id'],
                'status'       => 'pending',
                'client_notes' => $data->$data['notes'] ?? null,

            ]);
            DB::commit();
            if ($service->provider) {
             if ($service->provider) {
            $service->provider->notify(new NewOrderNotifications($order));
        }
        }
            return $order->load(['service','provider']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(message: "failed to create order:" . $e->getMessage());
        }
    }

    public function  getOrders()
    {
        return Order::whith(['review', 'client', 'provider', 'service'])
        ->where("client_id", Auth::user()->id)
        ->latest()
        ->get();
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
        $rating = $data['rating'] ?? null;
        $comment = $data['comment'] ?? null;
        $client_id = Auth::user()->id;
        $order->load(["review", 'provider']);
        if ($order->client_id !==  $client_id) {
            throw new \Exception("error you can only rate your order");
        }
        $allowedStatus=[StatusOrderEnum::COMPLETED , StatusOrderEnum::FINISHED];
        if ( !in_array($order->status , $allowedStatus) ) {
            throw new \Exception("you can only rate completed order or finshed order");
        }
        if ($order->review) {
            throw new \Exception("you already rated this order");
        }
        $review = $order->review()
        ->create([
            'user_id' => $client_id,
            'order_id' => $order->id,
            'rating' => $rating,
            'comment' => $comment
        ]);
        // $providerEmail = $order->provider->email ?? null;

        // if ($providerEmail) {
        //     Mail::to($providerEmail)->send(new OrderRatingNotifcations());
        // }
   if ($order->provider) {
        $order->provider->notify(new OrderRatedNotifications($review));
    }
        return $review;
    }
  

}
