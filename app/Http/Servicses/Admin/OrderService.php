<?php

namespace App\Http\Servicses\Admin;

use App\Models\Order;



class OrderService
{
    public function getOrder($request)
{
    $orders = Order::with(['service', 'client', 'provider']);

    // 🔹 البحث باسم الخدمة
    if ($request->filled('search_service')) {
        $search_service = $request->input('search_service');
        $orders->whereHas('service', function ($q) use ($search_service) {
            $q->where('name', 'LIKE', "%{$search_service}%");
        });
    }

    // 🔹 البحث باسم العميل
    if ($request->filled('search_client')) {
        $search_client = $request->input('search_client');
        $orders->whereHas('client', function ($q) use ($search_client) {
            $q->where('name', 'LIKE', "%{$search_client}%");
        });
    }

    // 🔹 البحث باسم المزوّد
    if ($request->filled('search_provider')) {
        $search_provider = $request->input('search_provider');
        $orders->whereHas('provider', function ($q) use ($search_provider) {
            $q->where('name', 'LIKE', "%{$search_provider}%");
        });
    }

    // 🔹 الفلترة بالحالة
    if ($request->filled("status")) {
        $orders->where("status", $request->input("status"));
    }

    // 🔹 الترتيب (الفرز)
    $sortField = $request->input("sort_by", 'id');
    $sortOrder = $request->input('sort_order', 'desc');
    $allowedSorts = ['id', 'price', 'created_at'];

    if (!in_array($sortField, $allowedSorts)) {
        $sortField = 'id';
    }

    $orders->orderBy($sortField, $sortOrder);

    // 🔹 الإرجاع مع تقسيم الصفحات
    return $orders->paginate(5);
}

    public function showOrders(Order $order) {
        return $order->load(['service','client','provider']);
    }
}
