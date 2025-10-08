@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="container-fluid">
    <h1>Details of Order#{{ $order->id }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>service:</strong> {{ optional($order->service)->name }}</p>
            <p><strong>Client:</strong> {{ optional($order->client)->name }}</p>
            <p><strong>Provider:</strong> {{ optional($order->provider)->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>client_notes:</strong> {{ $order->notes }}</p>
            <p><strong>Review:</strong> {{ optional($order->review)->rating ?? '_' }}</p>
            <p><strong>Created_at :</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Updated_at :</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary"> Back To Orders List </a>
</div>
@endsection
