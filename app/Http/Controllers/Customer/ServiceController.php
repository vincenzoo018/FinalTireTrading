<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to view services.']);
        }

        $services = Service::with(['employee', 'bookings' => function($query) {
            $query->whereIn('status', ['pending', 'confirmed']);
        }])->get();

        // Add availability information for each service
        $services->each(function($service) {
            $service->available_for_user = $service->isAvailableForUser(Auth::id());
            $service->active_bookings_count = $service->getActiveBookingsCount();
        });

        return view('customer.services', compact('services'));
    }

    /**
     * Check time slot availability for a service on a specific date
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,service_id',
            'date' => 'required|date',
        ]);

        $service = Service::findOrFail($request->service_id);
        $bookedTimes = $service->getBookedTimeSlotsForDate($request->date);

        return response()->json([
            'success' => true,
            'booked_times' => $bookedTimes,
            'available_count' => 8 - count($bookedTimes), // Assuming 8 total time slots
        ]);
    }
}
