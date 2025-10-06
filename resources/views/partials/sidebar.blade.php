<!-- Sidebar -->
<div class="bg-light p-3 rounded">
    <!-- Menu Header -->
    <div class="mb-3">
        <h5 class="text-primary mb-3">
            <i class="bi bi-grid-3x3-gap me-2"></i>Admin Panel
        </h5>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav flex-column">
        <a class="nav-link mb-1 {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }}"
           href="{{ route('home') }}">
            <i class="bi bi-house-door me-2"></i>Dashboard
        </a>
        <a class="nav-link mb-1 text-dark" href="#" onclick="alert('Users management coming soon!')">
            <i class="bi bi-people me-2"></i>Users
        </a>
        <a class="nav-link mb-1 {{ request()->routeIs('categories.*') ? 'active bg-primary text-white' : 'text-dark' }}"
           href="{{ route('categories.index') }}">
            <i class="bi bi-tags me-2"></i>Categories
        </a>
        <a class="nav-link mb-1 text-dark  {{ request()->routeIs('services.*') ? 'active bg-primary text-white' : 'text-dark' }}"
        href="{{ route('admin.services.index') }}" >
            <i class="bi bi-file-text me-2"></i>Services
        </a>
        <a class="nav-link mb-1 text-dark {{ request()->routeIs('Orders.*') ? 'active bg-primary text-white' : 'text-dark' }}"
        href="{{ route("orders.index") }}" >
            <i class="bi bi-gear me-2"></i>Orders List
        </a>
    </nav>

    <hr class="my-3">

    <!-- User Info Section -->
    <div class="text-center">
        <div class="mb-2">
            <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center"
                 style="width: 50px; height: 50px; font-size: 20px; font-weight: bold;">
                {{-- {{ strtoupper(substr(auth()->user()->name, 0, 1)) }} --}}
            </div>
        </div>
        {{-- <h6 class="mb-1">{{ auth()->user()->name }}</h6> --}}
        {{-- <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
        <div class="mt-2"> --}}
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>
