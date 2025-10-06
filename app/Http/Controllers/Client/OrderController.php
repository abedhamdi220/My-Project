<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Global\StoreOrderRequest;
use App\Http\Servicses\Client\OrderService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return $this->success($order, 'Order created successfully.', 201);

  }

  public function index(Request $request)
  {
    $order = $this->orderService->getOrders();
    return $this->success(['message' => 'Success', 'data' => $order], 'Orders retrieved successfully.', 200);
  }
}
