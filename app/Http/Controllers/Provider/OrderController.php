<?php

namespace App\Http\Controllers\Provider;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Servicses\Provider\OrderService;

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
    public function changeStatus(Request $request, Order $order)
    {
        $provider=Auth::user();
        $request->validate([
            'status' => 'required|string|in:completed,pending,approved,rejected,finiched'
        ]);
        $order = $this->orderService->changeStatusProvider($order, $request->status,$provider);
        return $this->success(['message' => 'Order status change successefully', 'data' => $order], 200);
    }
    public function getNotifications(){
       $provider= Auth::user();
        $order = $this->orderService->getNotificationProvider($provider);
        return response()->json($order,200);

    }
    public function markAsRead($notificationId){
       $provider= Auth::user();
        $notification  = $this->orderService->markNotificationAsRead($provider, $notificationId);
        return response()->json(["message"=>'notification marked as read','Notification'=>$notification],200);
    }
}
