<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view orders.']);
        }

        // TODO: Fetch orders from the database and pass to the view
        // Example:
        // $orders = Order::with(['user'])->latest()->paginate(15);
        // return view('admin.orders', compact('orders'));

        return view('admin.orders');
    }
}