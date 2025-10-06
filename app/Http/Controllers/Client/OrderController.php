<?php

namespace App\Http\Controllers\Client;

use App\Http\Resources\OrderCollectionResource;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use App\Http\Servicses\Client\OrderService;
use App\Http\Requests\Global\StoreOrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{

  /**
   * Store a new order.

   * @param Request $request
   * @return void
   */
  protected $orderService;
  public function __construct(OrderService $orderService)
  {
    $this->orderService = $orderService;
  }

  public function store(StoreOrderRequest $request)
  {

    $client_id = Auth::user()->id;
    $data = $request->validated();

    $order = $this->orderService->createOrder(array_merge($data), $client_id);
    return $this->success(new OrderResource($order->load(["review","client","provider","service"])), 'Order created successfully.', 201);

  }

  public function index(Request $request)
  {
    $order=Order::with(['review','client','provider','service'])->latest()->get();
    
    //$order = $this->orderService->getOrders();
    return $this->success(new OrderCollectionResource($order), 'Orders retrieved successefully.', 200);
  }
  public function show(Order $order)
  {
    $order=$order->load(['review','client','provider',"service"]);
    return $this->success(new OrderResource($order), "data recived succssefully", 200);
  }
  public function destroy(Order $order){
    $this->orderService->deleteOrder($order);
    return $this->success(null, "order deleted successefully",200);

  }
}
