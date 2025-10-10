{{-- في admin/notifications/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'All Notifications')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Notifications</h1>
        <div>
            {{-- استخدام route markAsRead للكل - سنحتاج لتعديل الـ Controller --}}
            <form action="{{ route('notifications.notifications.markAsRead', 'all') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">
                    Mark All as Read
                </button>
            </form>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Notifications ({{ $notifications->total() }})</h5>
        </div>
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="list-group">
                    @foreach($notifications as $notification)
                        <div class="list-group-item list-group-item-action 
                            {{ is_null($notification->read_at) ? 'list-group-item-warning' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                <div>
                                    <small class="text-muted">{{ $notification->created_at->format('M d, Y H:i') }}</small>
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-primary ms-2">New</span>
                                    @endif
                                </div>
                            </div>
                            <p class="mb-1">{{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message' }}</p>
                            <div class="mt-2">
                                @if(is_null($notification->read_at))
                                    {{-- استخدام route markAsRead الموجود --}}
                                    <form action="{{ route('notifications.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">Mark as Read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-bell text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No notifications found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection