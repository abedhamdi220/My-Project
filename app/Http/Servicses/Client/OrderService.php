<?php

namespace App\Http\Servicses\Client;

use App\Enums\StatusOrderEnum;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService {
    public function createOrder($data,$client_id){
        DB::beginTransaction();
        try{
       $service= Service::where("id",$data['service_id'])->where("status",'active')->first();
       if(!$service){
        throw new \Exception('service not found or not acyive');
       }
     
       $order= Order::create([
               'client_id'    => $client_id,
                'provider_id'  => $service->provider_id,
                'service_id'   => $data['service_id'],
                'status'       => 'pending',
                'client_notes' => $data->note ??null,

        ]);
        DB::commit();
      return $order;
    }catch(\Exception $e){
        DB::rollBack();
        throw new \Exception("failed to create order:".$e->getMessage());

    }

    }
    

 
    

   public function  getOrders(){
       return Order::where("client_id",Auth::user()->id)->get();    

    }
}




