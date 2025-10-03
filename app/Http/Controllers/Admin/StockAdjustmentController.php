<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view stock adjustments.']);
        }

        // TODO: Fetch stock adjustments from the database and pass to the view
        // Example:
        // $adjustments = StockAdjustment::with(['product', 'user'])->latest()->paginate(20);
        // return view('admin.stockadjustments', compact('adjustments'));

        return view('admin.stockadjustments');
    }

    // Add other methods (store, update, etc.) as needed, with the same auth check
}
