<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Sale;

class BookingController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }

        $bookings = Booking::with(['service'])->where('user_id', Auth::id())->latest()->get();
        return view('customer.booking', compact('bookings'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,service_id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'payment_method' => 'nullable|string|in:Cash,GCash,Credit Card,Debit Card',
            'notes' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'payment_method' => $validated['payment_method'] ?? 'Cash',
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.booking')->with('success', 'Booking submitted successfully!')->with('highlight_booking_id', $booking->booking_id);
    }

    public function cancel(Booking $booking, Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }
        if ($booking->user_id !== Auth::id()) {
            return back()->withErrors(['booking' => 'Unauthorized action.']);
        }
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Only pending bookings can be cancelled.']);
        }

        $booking->status = 'cancelled';
        // Optionally capture a cancel reason if you add such column later
        $booking->save();

        return back()->with('success', 'Booking cancelled.');
    }

    public function markCompleted(Booking $booking)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }
        if ($booking->user_id !== Auth::id()) {
            return back()->withErrors(['booking' => 'Unauthorized action.']);
        }
        if (!in_array($booking->status, ['confirmed'])) {
            return back()->withErrors(['booking' => 'Only confirmed bookings can be marked as completed.']);
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


