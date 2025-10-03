<?php
// Example for Admin CustomerController
// filepath: c:\Users\PC\Tire_Trading\app\Http\Controllers\Admin\CustomerController.php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view customers.']);
        }

        // Your logic here, e.g. fetch customers and return view
        // $customers = User::whereIn('role_id', [3])->get();
        // return view('admin.customer', compact('customers'));
        return view('admin.customer');
    }
}