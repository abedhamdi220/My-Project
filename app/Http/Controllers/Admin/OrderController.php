<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Servicses\Admin\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(OrderService $orderService){
        $this->order = $orderService;

    }
    public function index(Request $request){
        $data=$this->order->getOrder($request);
        return view("admin.orders.index",compact("data"));

    }
    public function show(Order $order){ 
        $order=$this->order->showOrders($order);

        return view("admin.orders.show",compact("order"));
    }
}
