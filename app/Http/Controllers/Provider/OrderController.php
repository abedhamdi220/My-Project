<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Servicses\Provider\OrderService;
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
}
