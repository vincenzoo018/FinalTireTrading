<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view orders.']);
        }

        $query = Order::with(['user', 'items.product']);

        // Filter by user name or email
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->user . '%')
                  ->orWhere('lname', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        // Filter by product name
        if ($request->filled('product')) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->product . '%');
            });
        }

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('fname', 'like', "%$search%")
                       ->orWhere('lname', 'like', "%$search%")
                       ->orWhere('email', 'like', "%$search%");
                })
                ->orWhereHas('items.product', function ($pq) use ($search) {
                    $pq->where('product_name', 'like', "%$search%");
                })
                ->orWhere('status', 'like', "%$search%");
            });
        }

        $orders = $query->latest()->paginate(15);

        // AJAX response for live search
        if ($request->ajax()) {
            return view('admin.partials.orders_table', compact('orders'))->render();
        }

        return view('admin.orders', compact('orders'));
    }
}
