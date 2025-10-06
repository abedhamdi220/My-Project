@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="container-fluid">
    <h1>تفاصيل الطلب #{{ $order->id }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>الخدمة:</strong> {{ optional($order->service)->name }}</p>
            <p><strong>العميل:</strong> {{ optional($order->client)->name }}</p>
            <p><strong>المزوّد:</strong> {{ optional($order->provider)->name }}</p>
            <p><strong>الحالة:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>ملاحظات:</strong> {{ $order->notes }}</p>
            <p><strong>تاريخ الإنشاء:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>آخر تعديل:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
</div>
@endsection
