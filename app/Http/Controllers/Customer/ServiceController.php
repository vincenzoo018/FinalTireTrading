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

        $services = Service::with('employee')->get();
        return view('customer.services', compact('services'));
    }
}
