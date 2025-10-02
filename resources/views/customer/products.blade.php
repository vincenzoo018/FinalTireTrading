@extends('layouts.customer.app')

@section('content')
<!-- Products Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Our Products</h1>
        <p class="lead">Browse our wide selection of quality tires for all vehicle types</p>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <form method="GET" action="#" class="row mb-4 g-2">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search products...">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="">Category 1</option>
                    <option value="">Category 2</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="brand" class="form-select">
                    <option value="">All Brands</option>
                    <option value="">Brand A</option>
                    <option value="">Brand B</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="">Sort by: Featured</option>
                    <option value="">Price: Low to High</option>
                    <option value="">Price: High to Low</option>
                    <option value="">Name: A to Z</option>
                    <option value="">Name: Z to A</option>
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </form>

        <div class="row">
            <!-- Example Product Card -->
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <img src="/images/tire-1.jpg" class="card-img-top product-img" alt="Product Name">
                    <div class="card-body">
                        <h5 class="product-title">Sample Tire Product</h5>
                        <p class="card-text">This is a description of the tire product.</p>
                        <ul class="list-unstyled mb-2">
                            <li><strong>Brand:</strong> Sample Brand</li>
                            <li><strong>Size:</strong> 205/55R16</li>
                            <li><strong>Length:</strong> 50cm</li>
                            <li><strong>Width:</strong> 20cm</li>
                            <li><strong>Category:</strong> Passenger Tire</li>
                        </ul>
                        <div class="mb-2">
                            <span class="product-price">P3,500.00</span>
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-success">In Stock</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Duplicate more product cards if needed -->
            <div class="col-12">
                <div class="alert alert-info">No products found.</div>
            </div>
        </div>
    </div>
</section>
@endsection
