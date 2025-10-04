<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])->where('user_id', Auth::id())->get();
        return view('customer.orders', compact('orders'));
    }
}
