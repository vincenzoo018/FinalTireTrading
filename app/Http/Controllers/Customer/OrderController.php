<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to view feedback.']);
        }

        // You can fetch order data here if needed
        return view('customer.orders');
    }
}
