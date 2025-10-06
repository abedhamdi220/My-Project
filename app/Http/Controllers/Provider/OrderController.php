<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\UpdateStatusRequest;
use App\Http\Servicses\Provider\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $service)
    {
        $this->orderService = $service;
    }
public function index()
{
    $order=$this->orderService->getOrdersProvider();
    return $this->success(['message'=>'Success','data'=>$order], 'Orders retrieved successfully.',200);

   
}


public function getFilterDataForProviders(Request $request){
    $providers = $this->orderService->getForProvider();
    return $this->success(['data'=>$providers,'message'=> 'Orders for providers',],201);
}





public function changeStatus(Order $order,UpdateStatusRequest $request){
   $status= $request->validated();
    $this->orderService->changeStatusProvider($order, $status);
}
}
