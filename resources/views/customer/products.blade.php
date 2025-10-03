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
                    <span class="text-muted me-2">Showing 12 products</span>
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
            @for($i = 1; $i <= 6; $i++)
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card product-card h-100">
                    <span class="featured-badge">FEATURED</span>
                    <img src="/images/tire-{{ ($i % 3) + 1 }}.jpg" class="card-img-top product-img" alt="Premium Tire {{ $i }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="product-title">Premium Tire Model {{ $i }}</h5>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>In Stock
                            </span>
                        </div>
                        <p class="card-text text-muted">High-performance tire designed for excellent traction and durability in all weather conditions.</p>

                        <div class="product-specs mb-3">
                            <div class="row text-center">
                                <div class="col-4">
                                    <small class="text-muted d-block">Size</small>
                                    <strong>205/55R16</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Warranty</small>
                                    <strong>60,000 km</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Season</small>
                                    <strong>All-Season</strong>
                                </div>
                            </div>
                        </div>

                        <div class="product-features mb-3">
                            <small class="text-muted">
                                <i class="fas fa-check text-success me-1"></i>Fuel Efficient<br>
                                <i class="fas fa-check text-success me-1"></i>Wet Traction<br>
                                <i class="fas fa-check text-success me-1"></i>Comfort Ride
                            </small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">P{{ number_format(2500 + ($i * 300), 2) }}</span>
                                <small class="text-muted d-block">per tire</small>
                            </div>
                            <button class="btn btn-primary"
                                    onclick="addToCart({{ $i }}, 'Premium Tire Model {{ $i }}', {{ 2500 + ($i * 300) }})">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Pagination -->
        <nav aria-label="Product pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                        <i class="fas fa-chevron-left me-2"></i>Previous
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        Next<i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </li>
            </ul>
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
@endsection
