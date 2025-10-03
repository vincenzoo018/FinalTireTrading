@extends('layouts.customer.app')

@section('content')
<!-- Products Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">Our Products</h1>
                <p class="lead mb-0">Browse our wide selection of quality tires for all vehicle types and driving conditions</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end">
                    <span class="text-muted me-2">Showing {{ $products->count() }} of {{ $products->total() }} products</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <!-- Enhanced Filter Form -->
        <div class="card mb-5">
            <div class="card-body">
                <form method="GET" action="#" class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search products...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="passenger">Passenger Tires</option>
                            <option value="suv">SUV Tires</option>
                            <option value="truck">Truck Tires</option>
                            <option value="performance">Performance Tires</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <select name="brand" class="form-select">
                            <option value="">All Brands</option>
                            <option value="michelin">Michelin</option>
                            <option value="bridgestone">Bridgestone</option>
                            <option value="goodyear">Goodyear</option>
                            <option value="continental">Continental</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <select name="sort" class="form-select">
                            <option value="">Sort by: Featured</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                            <button class="btn btn-outline-secondary" type="reset">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Product Cards -->
            @forelse($products as $product)
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card product-card h-100">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->product_name }}">
                    @else
                        <img src="{{ asset('images/default-product.png') }}" class="card-img-top product-img" alt="Default Product">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="product-title">{{ $product->product_name }}</h5>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>In Stock
                            </span>
                        </div>
                        <p class="card-text text-muted">{{ $product->description ?? 'No description.' }}</p>
                        <div class="product-specs mb-3">
                            <div class="row text-center">
                                <div class="col-4">
                                    <small class="text-muted d-block">Size</small>
                                    <strong>{{ $product->size ?? '-' }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Brand</small>
                                    <strong>{{ $product->brand ?? '-' }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Category</small>
                                    <strong>{{ $product->category->category_name ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">₱{{ number_format($product->selling_price, 2) }}</span>
                                <small class="text-muted d-block">per tire</small>
                            </div>
                            <button class="btn btn-primary"
                                    onclick="addToCart({{ $product->product_id }}, '{{ $product->product_name }}', {{ $product->selling_price }})">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">No products found.</div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <nav aria-label="Product pagination" class="mt-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</section>

<!-- Product Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Shop by Category</h2>
        <div class="row">
            @foreach([
                ['icon' => 'fa-car', 'title' => 'Passenger Tires', 'count' => '45 Products'],
                ['icon' => 'fa-truck', 'title' => 'SUV & Truck Tires', 'count' => '32 Products'],
                ['icon' => 'fa-tachometer-alt', 'title' => 'Performance Tires', 'count' => '28 Products'],
                ['icon' => 'fa-snowflake', 'title' => 'Winter Tires', 'count' => '18 Products']
            ] as $category)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            <i class="fas {{ $category['icon'] }}"></i>
                        </div>
                        <h5 class="card-title">{{ $category['title'] }}</h5>
                        <p class="text-muted">{{ $category['count'] }}</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Browse</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Debug --}}
@if(!isset($products))
    <div style="color:red">ERROR: $products is not set!</div>
@endif
@endsection
