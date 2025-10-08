<?php

namespace App\Http\Controllers\Provider;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $request->validate([
            'status' => 'required|string|in:completed,pending,approved,rejected,finiched'
        ]);
        $order = $this->orderService->changeStatusProvider($order, $request->status);
        return $this->success(['message' => 'Order status change successefully', 'data' => $order], 200);
    }
}
