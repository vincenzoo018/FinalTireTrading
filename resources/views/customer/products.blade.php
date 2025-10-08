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
                <div class="card product-card h-100 {{ !$product->isInStock() ? 'product-out-of-stock' : '' }}">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->product_name }}">
                    @else
                        <img src="{{ asset('images/default-product.png') }}" class="card-img-top product-img" alt="Default Product">
                    @endif
                    
                    @if(!$product->isInStock())
                        <div class="out-of-stock-overlay">
                            <span class="badge bg-danger">OUT OF STOCK</span>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="product-title">{{ $product->product_name }}</h5>
                            @if($product->isInStock())
                                @if($product->isLowStock())
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Low Stock
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>In Stock
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>Out of Stock
                                </span>
                            @endif
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
                                    <small class="text-muted d-block">Stock</small>
                                    <strong class="{{ $product->isInStock() ? 'text-success' : 'text-danger' }}">
                                        {{ $product->getStockQuantity() }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">₱{{ number_format($product->selling_price, 2) }}</span>
                                <small class="text-muted d-block">per tire</small>
                            </div>
                            @if($product->isInStock())
                                <form action="{{ route('customer.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary" type="button" disabled>
                                    <i class="fas fa-ban me-2"></i>Out of Stock
                                </button>
                            @endif
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

@section('styles')
<style>
.product-card {
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card:nth-child(1) { animation-delay: 0.1s; }
.product-card:nth-child(2) { animation-delay: 0.2s; }
.product-card:nth-child(3) { animation-delay: 0.3s; }

.product-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 40px rgba(52, 152, 219, 0.2);
}

.product-out-of-stock {
    opacity: 0.7;
}

.product-out-of-stock .product-img {
    filter: grayscale(80%);
}

.out-of-stock-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
    pointer-events: none;
}

.out-of-stock-overlay .badge {
    font-size: 1.3rem;
    padding: 0.85rem 1.75rem;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
    border-radius: 50px;
    font-weight: 800;
    letter-spacing: 1px;
}

.product-img {
    height: 280px;
    width: 100%;
    object-fit: cover;
    object-position: center;
    transition: all 0.4s ease;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.product-card:hover .product-img {
    transform: scale(1.08);
}

.product-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-size: 1.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, #3498db, #2980b9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-specs {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.product-specs strong {
    color: #2c3e50;
    font-weight: 700;
}

.service-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
}

.service-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 35px rgba(52, 152, 219, 0.2);
}

.service-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: rotate(15deg) scale(1.1);
}
</style>
@endsection
