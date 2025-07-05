@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5">
    <!-- Welcome & Description Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-6 text-center p-4">
                        <h1 class="fw-bold text-primary">Welcome to the Admin Dashboard</h1>
                        <p class="text-secondary fs-5 mt-3">
                            You have full control of the website’s content and functionality. Manage categories, products, and more to keep your site running smoothly.
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img src="https://img.freepik.com/free-vector/admin-dashboard-concept-illustration_114360-9102.jpg" alt="Dashboard Illustration" class="img-fluid rounded-end" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Prompt Card -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 text-center p-4">
                <h4 class="text-info fw-semibold">What would you like to manage today?</h4>
                <p class="text-muted mb-0">
                    Select a section below to get started. You can easily add new items, edit existing ones, or review your system’s performance.
                </p>
            </div>
        </div>
    </div>

     <div class="row justify-content-center g-4">
        <!-- Category Card -->
        <div class="col-md-5">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="fas fa-tags fa-3x text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Manage Categories</h5>
                    <p class="card-text text-muted">
                        Organize and update your product categories for easier navigation and better user experience.
                    </p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mt-2">Go to Categories</a>
                </div>
            </div>
        </div>

        <!-- Product Card -->
        <div class="col-md-5">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-3x text-success mb-3"></i>
                    <h5 class="card-title fw-bold">Manage Products</h5>
                    <p class="card-text text-muted">
                        Add, edit, and maintain your product listings to ensure accurate and appealing product info.
                    </p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-success mt-2">Go to Products</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="text-success fs-6">
            <strong>Tip:</strong> Keeping your products and categories up-to-date improves customer satisfaction and increases trust.
        </p>
    </div>
</div>
@endsection
