@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- إحصائيات المستخدمين -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-primary text-white">
                <div class="card-body">
                    <i class="bi bi-people-fill mb-2" style="font-size: 2rem;"></i>
                    <h5>Total Users</h5>
                    <h2>{{ $stats['total_users'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <i class="bi bi-shield-check mb-2" style="font-size: 2rem;"></i>
                    <h5>Admins</h5>
                    <h2>{{ $stats['admin_users'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-info text-white">
                <div class="card-body">
                    <i class="bi bi-person-check mb-2" style="font-size: 2rem;"></i>
                    <h5>Clients</h5>
                    <h2>{{ $stats['client_users'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-warning text-white">
                <div class="card-body">
                    <i class="bi bi-tools mb-2" style="font-size: 2rem;"></i>
                    <h5>Providers</h5>
                    <h2>{{ $stats['provider_users'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Notifications</h5>
                <div>
                    <span class="badge bg-danger" id="unreadCount">
                        {{ auth()->user()->unreadNotifications()->count() }} Unread
                    </span>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="markAllAsRead()">
                        Mark All as Read
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if(auth()->user()->notifications->count() > 0)
                    <div class="list-group">
                        @foreach(auth()->user()->notifications->take(5) as $notification)
                            <div class="list-group-item list-group-item-action 
                                {{ is_null($notification->read_at) ? 'list-group-item-warning' : '' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message' }}</p>
                                @if(is_null($notification->read_at))
                                    <span class="badge bg-primary">New</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                       
                        <a href="{{ route('notifications.notifications.index') }}" class="btn btn-outline-secondary btn-sm">
                            View All Notifications
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-bell text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No notifications yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAllAsRead() {
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('unreadCount').textContent = '0 Unread';
            location.reload();
        }
    });
}

setInterval(() => {
    // استخدام route unread-count الموجود
    fetch('{{ route("notifications.notifications.unreadCount") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('unreadCount').textContent = data.count + ' Unread';
        });
}, 30000);
</script>
@endpush

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_users']) && $stats['recent_users']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_users'] as $user)
                                        <tr>
                                            <td>index
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    {{ $user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No users registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
<script>
// function markAllAsRead() {
//     // fetch('{{ route('') }}', {
//     //     method: 'POST',
//     //     headers: {
//     //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
//     //         'Content-Type': 'application/json'
//     //     }
//     // })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             document.getElementById('unreadCount').textContent = '0 Unread';
//             // إعادة تحميل الصفحة لتحديث حالة الإشعارات
//             location.reload();
//         }
//     });
// }

// تحديث عدد الإشعارات غير المقروءة كل 30 ثانية
setInterval(() => {
    fetch('{{ route("notifications.notifications.unreadCount") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('unreadCount').textContent = data.count + ' Unread';
        });
}, 30000);
</script>
@endpush --}}