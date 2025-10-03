@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h1 class="display-4 mb-4">Welcome to Laravel</h1>
        <p class="lead mb-4">This is a simple Laravel application for learning purposes.</p>

        @auth
            <div class="alert alert-success">
                <h5>Hello, {{ auth()->user()->name }}!</h5>
                <p>You are logged in as {{ ucfirst(auth()->user()->role) }}.</p>
            </div>
        @else
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
            </div>
        @endauth

        <div class="mt-5">
            <h3>Learning Topics Covered:</h3>
            <ul class="list-unstyled mt-4">
                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Blade Templates</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Routes & Controllers</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Authentication</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Bootstrap Styling</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Database & Models</li>
            </ul>
        </div>
    </div>
</div>
@endsection