@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Category Details</h3>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($category))
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-light" width="200">ID</th>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Name</th>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Description</th>
                                        <td>{{ $category->description ?? 'No description' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Parent Category</th>
                                        <td>{{ $category->parent?->name ?? 'None (Root Category)' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Services Count</th>
                                        <td>{{ $category->services_count }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Subcategories Count</th>
                                        <td>{{ $category->children_count ?? $category->children()->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Created At</th>
                                        <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Updated At</th>
                                        <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-block mb-2">
                                            <i class="fas fa-edit"></i> Edit Category
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-block"
                                                    onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i> Delete Category
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($category->children && $category->children->count() > 0)
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5>Subcategories</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                @foreach($category->children as $child)
                                                    <li class="list-group-item">
                                                        <a href="{{ route('categories.show', $child->id) }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="alert alert-warning">
                                <h4>Category Not Found</h4>
                                <p>The requested category could not be found.</p>
                                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back to Categories</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
