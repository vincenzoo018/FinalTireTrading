<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Sale;

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
        $booking->served_date = now();
        $booking->save();

        // Create a sale record for the completed booking
        try {
            $totalAmount = $booking->service ? $booking->service->service_price : 0;
            
            // Check if sale record already exists to avoid duplicates
            $existingSale = Sale::where('booking_id', $booking->booking_id)->first();
            if (!$existingSale) {
                Sale::create([
                    'order_id' => null,
                    'booking_id' => $booking->booking_id,
                    'user_id' => $booking->user_id,
                    'subtotal' => $totalAmount - ($totalAmount * 0.12),
                    'tax' => $totalAmount * 0.12,
                    'shipping' => 0,
                    'total_amount' => $totalAmount,
                    'payment_method' => $booking->payment_method ?? 'Cash',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error creating sale record for completed booking: ' . $e->getMessage());
        }

        return back()->with('success', 'Booking marked as completed and sale recorded.');
    }
}
