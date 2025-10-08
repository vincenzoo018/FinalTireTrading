<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Booking;
use Carbon\Carbon;

class SalesController extends Controller
{
    // Show sales analytics page for admin only
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view sales analytics.']);
        }

        // Get filter parameters
        $filterType = $request->input('filter_type', 'month'); // Default to month
        $filterDate = $request->input('filter_date', Carbon::now()->format('Y-m-d'));
        
        // Parse the filter date
        $date = Carbon::parse($filterDate);
        
        // Fetch and store sales data from orders and bookings
        $this->fetchAndStoreSalesData();
        
        // Force generate sales for any completed bookings that might have been missed
        $this->generateBookingSales();
        
        // Get sales data based on filter
        $salesData = $this->getSalesData($filterType, $date);
        $chartData = $this->prepareChartData($salesData, $filterType, $date);
        
        // Get ALL sales data (both orders and bookings) with eager loading of relationships
        $sales = Sale::with(['order.user', 'booking.user', 'booking.service', 'order.items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Debug: Log sales count
        \Log::info('Total sales records: ' . Sale::count());
        \Log::info('Booking sales: ' . Sale::whereNotNull('booking_id')->count());
        \Log::info('Order sales: ' . Sale::whereNotNull('order_id')->count());

        // Calculate totals based on the filter
        $totalRevenue = $salesData->sum('total_amount');
        $totalOrders = $salesData->where('source', 'order')->count();
        $totalBookings = $salesData->where('source', 'booking')->count();
        $cancelledOrders = Order::where('status', 'cancelled')
            ->when($filterType == 'day', function($query) use ($date) {
                return $query->whereDate('created_at', $date);
            })
            ->when($filterType == 'month', function($query) use ($date) {
                return $query->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month);
            })
            ->when($filterType == 'year', function($query) use ($date) {
                return $query->whereYear('created_at', $date->year);
            })
            ->count();

        // Get top products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->select('products.product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->when($filterType == 'day', function($query) use ($date) {
                return $query->whereDate('orders.created_at', $date);
            })
            ->when($filterType == 'month', function($query) use ($date) {
                return $query->whereYear('orders.created_at', $date->year)
                            ->whereMonth('orders.created_at', $date->month);
            })
            ->when($filterType == 'year', function($query) use ($date) {
                return $query->whereYear('orders.created_at', $date->year);
            })
            ->groupBy('products.product_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        return view('admin.sales', compact(
            'sales', 
            'totalRevenue', 
            'totalOrders', 
            'cancelledOrders', 
            'filterType', 
            'filterDate', 
            'chartData',
            'topProducts',
            'totalBookings'
        ));
    }

    /**
     * Fetch sales data from orders and bookings and store in sales table
     */
    private function fetchAndStoreSalesData()
    {
        // Get orders that don't have corresponding sales records
        $orders = Order::whereNotIn('order_id', function($query) {
                $query->select('order_id')->from('sales')->whereNotNull('order_id');
            })
            ->where('status', 'completed')
            ->get();
            
        // Create sales records for orders
        foreach ($orders as $order) {
            try {
                Sale::create([
                    'order_id' => $order->order_id,
                    'booking_id' => null,
                    'user_id' => $order->user_id,
                    'subtotal' => $order->total_amount - ($order->total_amount * 0.12), // Approximate subtotal
                    'tax' => $order->total_amount * 0.12, // 12% tax
                    'shipping' => 0, // Assuming no shipping cost
                    'total_amount' => $order->total_amount,
                    'payment_method' => $order->payment_method,
                    'created_at' => $order->updated_at,
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating sale record for order: ' . $e->getMessage());
            }
        }
        
        // Get completed bookings that don't have corresponding sales records
        $bookings = Booking::whereNotIn('booking_id', function($query) {
                $query->select('booking_id')->from('sales')->whereNotNull('booking_id');
            })
            ->where('status', 'completed')
            ->with('service') // Eager load service to get price
            ->get();
            
        // Create sales records for bookings
        foreach ($bookings as $booking) {
            try {
                $totalAmount = $booking->service ? $booking->service->service_price : 0;
                
                Sale::create([
                    'order_id' => null,
                    'booking_id' => $booking->booking_id,
                    'user_id' => $booking->user_id,
                    'subtotal' => $totalAmount - ($totalAmount * 0.12), // Approximate subtotal
                    'tax' => $totalAmount * 0.12, // 12% tax
                    'shipping' => 0, // No shipping for services
                    'total_amount' => $totalAmount,
                    'payment_method' => $booking->payment_method ?? 'Cash',
                    'created_at' => $booking->served_date ?? $booking->updated_at,
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating sale record for booking: ' . $e->getMessage());
            }
        }
    }

    private function getSalesData($filterType, $date)
    {
        // Get all sales and mark their source
        $sales = Sale::select(
                'sales.*',
                DB::raw("CASE WHEN booking_id IS NOT NULL THEN 'booking' ELSE 'order' END as source"),
                DB::raw('DATE(created_at) as sale_date')
            )
            ->when($filterType == 'day', function($query) use ($date) {
                return $query->whereDate('created_at', $date);
            })
            ->when($filterType == 'month', function($query) use ($date) {
                return $query->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month);
            })
            ->when($filterType == 'year', function($query) use ($date) {
                return $query->whereYear('created_at', $date->year);
            })
            ->get();

        return $sales;
    }

    private function prepareChartData($salesData, $filterType, $date)
    {
        $labels = [];
        $data = [];
        $bookingData = [];

        if ($filterType == 'day') {
            // Group by hour for day view
            for ($hour = 0; $hour < 24; $hour++) {
                $labels[] = sprintf('%02d:00', $hour);
                
                $hourSales = $salesData->filter(function ($sale) use ($hour) {
                    return Carbon::parse($sale->created_at)->hour == $hour;
                });
                
                $orderAmount = $hourSales->where('source', 'order')->sum('total_amount');
                $bookingAmount = $hourSales->where('source', 'booking')->sum('total_amount');
                
                $data[] = $orderAmount;
                $bookingData[] = $bookingAmount;
            }
        } elseif ($filterType == 'month') {
            // Group by day for month view
            $daysInMonth = $date->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($date->year, $date->month, $day);
                $labels[] = $currentDate->format('M d');
                
                $daySales = $salesData->filter(function ($sale) use ($currentDate) {
                    return Carbon::parse($sale->created_at)->day == $currentDate->day;
                });
                
                $orderAmount = $daySales->where('source', 'order')->sum('total_amount');
                $bookingAmount = $daySales->where('source', 'booking')->sum('total_amount');
                
                $data[] = $orderAmount;
                $bookingData[] = $bookingAmount;
            }
        } else {
            // Group by month for year view
            for ($month = 1; $month <= 12; $month++) {
                $currentDate = Carbon::create($date->year, $month, 1);
                $labels[] = $currentDate->format('M');
                
                $monthSales = $salesData->filter(function ($sale) use ($currentDate) {
                    return Carbon::parse($sale->created_at)->month == $currentDate->month;
                });
                
                $orderAmount = $monthSales->where('source', 'order')->sum('total_amount');
                $bookingAmount = $monthSales->where('source', 'booking')->sum('total_amount');
                
                $data[] = $orderAmount;
                $bookingData[] = $bookingAmount;
            }
        }

        return [
            'labels' => $labels,
            'orderData' => $data,
            'bookingData' => $bookingData
        ];
    }

    private function generateBookingSales()
    {
        // Get all completed bookings that don't have sales records yet
        $completedBookings = Booking::with('service')
            ->where('status', 'completed')
            ->whereDoesntHave('sale')
            ->get();

        foreach ($completedBookings as $booking) {
            try {
                $totalAmount = $booking->service ? $booking->service->service_price : 0;
                
                if ($totalAmount > 0) {
                    Sale::create([
                        'order_id' => null,
                        'booking_id' => $booking->booking_id,
                        'user_id' => $booking->user_id,
                        'subtotal' => $totalAmount - ($totalAmount * 0.12),
                        'tax' => $totalAmount * 0.12,
                        'shipping' => 0,
                        'total_amount' => $totalAmount,
                        'payment_method' => $booking->payment_method ?? 'Cash',
                        'created_at' => $booking->served_date ?? $booking->updated_at,
                        'updated_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Error generating sale for booking ' . $booking->booking_id . ': ' . $e->getMessage());
            }
        }
    }

    public function generateSales(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin.']);
        }

        try {
            $this->fetchAndStoreSalesData();
            $this->generateBookingSales();
            
            return redirect()->route('admin.sales')->with('success', 'Sales data generated successfully for all completed orders and bookings!');
        } catch (\Exception $e) {
            return redirect()->route('admin.sales')->withErrors(['error' => 'Error generating sales data: ' . $e->getMessage()]);
        }
    }
}
