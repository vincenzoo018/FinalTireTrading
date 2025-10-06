<?php
// Example for Admin CustomerController
// filepath: c:\Users\PC\Tire_Trading\app\Http\Controllers\Admin\CustomerController.php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view customers.']);
        }

        $query = User::where('role_id', 3);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('fname', 'like', "%$s%")
                  ->orWhere('lname', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('username', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        $customers = $query->latest()->paginate(15);
        return view('admin.customer', compact('customers'));
    }

    public function toggleActive(User $user, Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Admin privileges required.']);
        }
        if ($user->role_id != 3) {
            return back()->withErrors(['user' => 'Only customer accounts can be toggled.']);
        }
        $user->is_active = !$user->is_active;
        if (!$user->is_active) {
            $user->ban_reason = $request->input('ban_reason');
        } else {
            $user->ban_reason = null;
        }
        $user->save();
        return back()->with('success', $user->is_active ? 'Customer enabled.' : 'Customer disabled.');
    }

    public function resetPassword(User $user)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Admin privileges required.']);
        }
        if ($user->role_id != 3) {
            return back()->withErrors(['user' => 'Only customer accounts can be reset.']);
        }
        // Generate a temporary password and set it (notify user separately if needed)
        $temp = str()->random(10);
        $user->password = bcrypt($temp);
        $user->save();
        return back()->with('success', 'Password reset. Temporary password: ' . $temp);
    }
}