<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to view your orders.']);
        }

        $orders = \App\Models\Order::with(['cart.product'])->where('user_id', Auth::id())->get();

        return view('customer.orders', compact('orders'));
    }
}
