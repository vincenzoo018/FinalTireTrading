<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Customer Dashboard (Home)
    public function home()
    {
        return view('customer.home');
    }

    // Products page
    public function products()
    {
        return view('customer.products');
    }

    // Services page
    public function services()
    {
        return view('customer.services');
    }

    // Bookings page
    public function booking()
    {
        return view('customer.booking');
    }

    // Cart page
    public function cart()
    {
        return view('customer.cart');
    }

    // Checkout page
    public function checkout()
    {
        return view('customer.checkout');
    }

    // Orders page
    public function orders()
    {
        return view('customer.orders');
    }

    // Profile page
    public function profile()
    {
        return view('customer.profile');
    }

    // Feedback page
    public function feedback()
    {
        return view('customer.feedback');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
