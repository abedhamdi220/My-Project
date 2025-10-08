@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="container">
    <h1>إدارة الطلبات</h1>

    {{-- نموذج الفلترة / البحث --}}
    <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search_service" value="{{ request('search_service') }}" class="form-control" placeholder="بحث بالخدمة">
            </div>
            <div class="col-md-3">
                <input type="text" name="search_client" value="{{ request('search_client') }}" class="form-control" placeholder="بحث بالعميل">
            </div>
            <div class="col-md-3">
                <input type="text" name="search_provider" value="{{ request('search_provider') }}" class="form-control" placeholder="بحث بالمزوّد">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">كل الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغّى</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort_by" class="form-control">
                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>ID</option>
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>المبلغ</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>التاريخ</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort_order" class="form-control">
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">تصفية</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">إعادة ضبط</a>
        </div>
    </form>

    {{-- عرض إحصائيات بسيطة --}}
    <div class="mb-4">
        <strong>إجمالي الطلبات:</strong> {{ $data->total() }} <br>
        <strong>الصفحة الحالية:</strong> {{ $data->currentPage() }} من {{ $data->lastPage() }}
    </div>

    @if ($data->isEmpty())
        <p>لا توجد طلبات مطابقة للبحث.</p>
    @else
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Service</th>
                    <th>Client</th>
                    <th>Provider</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Rating</th> {{-- ✅ عمود التقييم --}}
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $order)
                    <tr>
                        <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ optional($order->service)->name ?? '-' }}</td>
                        <td>{{ optional($order->client)->name ?? '-' }}</td>
                        <td>{{ optional($order->provider)->name ?? '-' }}</td>
                        <td>{{ number_format($order->price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            @if ($order->review)
                                ⭐ {{ $order->review->rating }}/5
                            @else
                                <span class="text-muted">No Reviews</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">عرض</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- روابط الصفحات --}}
        {{ $data->withQueryString()->links('pagination::bootstrap-4') }}
    @endif
</div>
@endsection

