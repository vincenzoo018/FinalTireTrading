<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookedServicesController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to view your bookings.']);
        }

        // Fetch bookings for the logged-in customer
        $bookings = Booking::with(['service', 'service.employee'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.booking', compact('bookings'));
    }
}
