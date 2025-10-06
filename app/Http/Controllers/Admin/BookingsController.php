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

    public function approve(Request $request, Booking $booking)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to manage bookings.']);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Only pending bookings can be approved.']);
        }

        $booking->status = 'confirmed';
        $booking->save();

        return back()->with('success', 'Booking approved.');
    }

    public function reject(Request $request, Booking $booking)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to manage bookings.']);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Only pending bookings can be rejected.']);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking rejected.');
    }

    public function complete(Request $request, Booking $booking)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to manage bookings.']);
        }

        if (!in_array($booking->status, ['confirmed'])) {
            return back()->withErrors(['booking' => 'Only confirmed bookings can be completed.']);
        }

        $booking->status = 'completed';
        $booking->save();

        return back()->with('success', 'Booking marked as completed.');
    }
}
