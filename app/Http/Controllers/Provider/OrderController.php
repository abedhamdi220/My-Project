<?php

namespace App\Http\Controllers\Provider;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Http\Servicses\Provider\OrderService;
use App\Http\Requests\Provider\UpdateStatusRequest;
use App\Notifications\StatusChangeNotifications;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $service)
    {
        $this->orderService = $service;
    }
    public function index()
    {
        $order = $this->orderService->getOrdersProvider();
        return $this->success(['message' => 'Success', 'data' => $order], 'Orders retrieved successfully.', 200);
    }
    public function getFilterDataForProviders(Request $request)
    {
        $providers = $this->orderService->getForProvider();
        return $this->success(['data' => $providers, 'message' => 'Orders for providers',], 201);
    }
    public function changeStatus(Order $order, UpdateStatusRequest $request)
    {
        try{
        $status = $request->validated()['status'];
        $order=$this->orderService->changeStatusProvider($order, $status);
        $client= $order->client;
         Notification::send($client, new StatusChangeNotifications($order, $status));
         return $this->success(['message'=> 'Order status change successefully','data'=> $order],200);
        }
        catch(\Exception $e){
            return response()->json(["status"=>false,'message'=> $e->getMessage()],500);

        }
    }
}
