<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Admin Dashboard Methods
    public function dashboard(Request $request)
    {
        // Check authentication
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin.']);
        }

        // Get filter period (default to 'month')
        $filterPeriod = $request->input('filter', 'month');
        
        // Calculate date range based on filter
        $dateRange = $this->getDateRange($filterPeriod);
        
        // Get statistics
        $stats = $this->getDashboardStats($dateRange);
        
        // Get recent data for tables
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $lowStockProducts = Inventory::with(['product.category'])
            ->where('quantity_on_hand', '<', 10)
            ->where('quantity_on_hand', '>', 0)
            ->orderBy('quantity_on_hand', 'asc')
            ->limit(10)
            ->get();
            
        $outOfStockProducts = Inventory::with(['product.category'])
            ->where('quantity_on_hand', '=', 0)
            ->orderBy('last_updated', 'desc')
            ->limit(10)
            ->get();
            
        $recentBookings = Booking::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Get top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->select(
                'products.product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->whereBetween('orders.created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('products.product_id', 'products.product_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'outOfStockProducts',
            'recentBookings',
            'topProducts',
            'filterPeriod'
        ));
    }
    
    private function getDateRange($period)
    {
        $now = Carbon::now();
        
        switch ($period) {
            case 'today':
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay(),
                ];
            case 'week':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek(),
                ];
            case 'month':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                ];
            case 'year':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear(),
                ];
            default:
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                ];
        }
    }
    
    private function getDashboardStats($dateRange)
    {
        // Orders statistics
        $totalOrders = Order::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])->count();
        $pendingOrders = Order::where('status', 'pending')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
        $completedOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
        $cancelledOrders = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
            
        // Bookings statistics
        $totalBookings = Booking::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])->count();
        $pendingBookings = Booking::where('status', 'pending')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
        $confirmedBookings = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
        $completedBookings = Booking::where('status', 'completed')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
            
        // Inventory statistics
        $lowStockCount = Inventory::where('quantity_on_hand', '<', 10)
            ->where('quantity_on_hand', '>', 0)
            ->count();
        $outOfStockCount = Inventory::where('quantity_on_hand', '=', 0)->count();
        $inStockCount = Inventory::where('quantity_on_hand', '>=', 10)->count();
        $totalProducts = Product::count();
        
        // Revenue statistics (only for role_id = 1)
        $orderRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->sum('total_amount');
            
        $bookingRevenue = Sale::whereNotNull('booking_id')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->sum('total_amount');
            
        $totalRevenue = $orderRevenue + $bookingRevenue;
        
        return [
            // Orders
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
            
            // Bookings
            'total_bookings' => $totalBookings,
            'pending_bookings' => $pendingBookings,
            'confirmed_bookings' => $confirmedBookings,
            'completed_bookings' => $completedBookings,
            
            // Inventory
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'in_stock_count' => $inStockCount,
            'total_products' => $totalProducts,
            
            // Revenue (only for admin role_id = 1)
            'total_revenue' => $totalRevenue,
            'order_revenue' => $orderRevenue,
            'booking_revenue' => $bookingRevenue,
        ];
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
    public function stockadjustments()
    {
        return view('admin.stockadjustments');
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