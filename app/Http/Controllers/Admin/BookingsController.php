<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookingsController extends Controller
{
    // Show all bookings for admin (role_id == 1 or 2)
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view bookings.']);
        }

        // You can add filtering, searching, sorting here if needed
        $bookings = Booking::with(['user', 'service'])->latest()->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    // Add other methods (store, update, etc.) as needed, with similar auth checks
}
