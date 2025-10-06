<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Order;

class SalesController extends Controller
{
    // Show sales analytics page for admin only
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view sales analytics.']);
        }

        $sales = Sale::with(['order.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalRevenue = Sale::sum('total_amount');
        $totalOrders = Order::count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        return view('admin.sales', compact('sales', 'totalRevenue', 'totalOrders', 'cancelledOrders'));
    }
}
