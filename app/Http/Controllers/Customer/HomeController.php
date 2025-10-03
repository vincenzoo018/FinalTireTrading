<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to view the home page.']);
        }

        // Fetch featured products (e.g., latest 3 or add your own logic)
        $products = Product::orderBy('created_at', 'desc')->take(3)->get();

        // Fetch featured services (e.g., latest 3 or add your own logic)
        $services = Service::with('employee')->orderBy('created_at', 'desc')->take(3)->get();

        return view('customer.home', compact('products', 'services'));
    }
}
