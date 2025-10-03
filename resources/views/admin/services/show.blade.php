@extends('layouts.admin')

@section('title', 'Service Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Service Details</h3>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Services
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($service))
                        <table class="table table-bordered table-responsive">
                            <tbody>
                                <tr><th>ID</th><td>{{ $service->id }}</td></tr>
                                <tr><th>Name</th><td>{{ $service->name }}</td></tr>
                                <tr><th>Description</th><td>{{ $service->description }}</td></tr>
                                <tr><th>Provider</th><td>{{ optional($service->provider)->name }}</td></tr>
                                <tr><th>Category</th><td>{{ optional($service->category)->name }}</td></tr>
                                <tr><th>Price</th><td>{{ $service->price }}</td></tr>
                                <tr><th>Status</th><td>{{ $service->status }}</td></tr>
                                <tr><th>Created At</th><td>{{ $service->created_at }}</td></tr>
                                <tr><th>Updated At</th><td>{{ $service->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">Service not found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
