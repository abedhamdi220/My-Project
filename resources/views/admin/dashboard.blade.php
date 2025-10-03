@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
        <h1 class="mb-4">Admin Dashboard</h1>

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
                                        <td>
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
@endsection



