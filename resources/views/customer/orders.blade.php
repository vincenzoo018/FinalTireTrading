@extends('layouts.customer.app')

@section('content')
<!-- Orders Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">My Orders</h1>
        <p class="lead">Track and manage your orders</p>
    </div>
</section>

<!-- Orders Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#all" data-bs-toggle="tab">All Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pending" data-bs-toggle="tab">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#completed" data-bs-toggle="tab">Completed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cancelled" data-bs-toggle="tab">Cancelled</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">
            <!-- All Orders -->
            <div class="tab-pane fade show active" id="all">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-00123</td>
                                        <td>Dec 4, 2023</td>
                                        <td>2 items</td>
                                        <td>P5,800</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">View Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-00122</td>
                                        <td>Dec 3, 2023</td>
                                        <td>1 item</td>
                                        <td>P3,200</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Track Order</button></td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-00121</td>
                                        <td>Dec 2, 2023</td>
                                        <td>3 items</td>
                                        <td>P12,400</td>
                                        <td><span class="badge bg-info">Shipped</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Track Order</button></td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-00120</td>
                                        <td>Dec 1, 2023</td>
                                        <td>1 item</td>
                                        <td>P2,500</td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">View Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="tab-pane fade" id="pending">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-00122</td>
                                        <td>Dec 3, 2023</td>
                                        <td>1 item</td>
                                        <td>P3,200</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Track Order</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="tab-pane fade" id="completed">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-00123</td>
                                        <td>Dec 4, 2023</td>
                                        <td>2 items</td>
                                        <td>P5,800</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">View Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancelled Orders -->
            <div class="tab-pane fade" id="cancelled">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-00120</td>
                                        <td>Dec 1, 2023</td>
                                        <td>1 item</td>
                                        <td>P2,500</td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">View Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
