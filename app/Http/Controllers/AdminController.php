<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin Dashboard Methods
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function categories()
    {
        return view('admin.categories');
    }

    public function product()
    {
        return view('admin.product');
    }

    public function inventory()
    {
        return view('admin.inventory');
    }

    public function supplier()
    {
        return view('admin.supplier');
    }

    public function transactions()
    {
        return view('admin.transactions');
    }

    public function services()
    {
        return view('admin.services');
    }

    public function bookings()
    {
        return view('admin.bookings');
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function sales()
    {
        return view('admin.sales');
    }

    public function customers()
    {
        return view('admin.customer');
    }

    public function employee()
    {
        return view('admin.employee');
    }

    // Customer methods (if needed)
    // ...
}
?>