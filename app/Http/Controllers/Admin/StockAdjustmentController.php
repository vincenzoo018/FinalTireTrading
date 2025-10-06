<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Models\StockProd;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    // Show all adjustments
    public function index()
    {
        // Allow both employees (role_id == 2) and admins (role_id == 1) to access this page
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('login')->withErrors(['auth' => 'Access denied. Employee or Admin privileges required.']);
        }
        $adjustments = StockAdjustment::with([
            'stockProd.product.inventory',
            'requestedBy',
            'reviewedBy'
        ])->orderBy('created_at', 'desc')->paginate(10);

        // Get products with their current inventory for the dropdown
        $inventories = StockProd::with(['product.inventory'])->get();

        // Get all employees for the dropdown
        $employees = \App\Models\Employee::with('role')->get();

        return view('admin.stockadjustments', compact('adjustments', 'inventories', 'employees'));
    }

    // Store a new adjustment and update inventory
    public function store(Request $request)
    {
        // Allow both employees (role_id == 2) and admins (role_id == 1) to create requests
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('login')->withErrors(['auth' => 'Access denied. Employee or Admin privileges required.']);
        }
        $validated = $request->validate([
            'stock_prod_id'    => 'required|exists:stock_prods,stock_prod_id',
            'reason'           => 'required|string|max:255',
            'adjustment_type'  => 'required|in:increase,decrease',
            'physical_count'   => 'required|integer|min:0',
            'system_count'     => 'required|integer|min:0',
            'adjust_count'     => 'required|integer',
            // Status will be set to 'pending' automatically
        ]);

        // Get current user and find associated employee
        $currentUser = Auth::user();
        $currentEmployee = null;

        // Try to find employee by user_id first, then by role_id as fallback
        if ($currentUser) {
            $currentEmployee = \App\Models\Employee::where('user_id', $currentUser->user_id)->first();

            // Fallback: if no direct user_id match, try by role_id for admin/manager roles
            if (!$currentEmployee && in_array($currentUser->role_id, [1, 2])) {
                $currentEmployee = \App\Models\Employee::where('role_id', $currentUser->role_id)->first();
            }
        }

        // Create adjustment
        $adjustment = StockAdjustment::create([
            'stock_prod_id'    => $validated['stock_prod_id'],
            'reason'           => $validated['reason'],
            'adjustment_type'  => $validated['adjustment_type'],
            'physical_count'   => $validated['physical_count'],
            'system_count'     => $validated['system_count'],
            'adjust_count'     => $validated['adjust_count'],
            'status'           => 'pending', // Always set as pending for admin approval
            'requested_by'     => $currentEmployee ? $currentEmployee->employee_id : null,
            'reviewed_by'      => null, // Will be set by admin when reviewing
            'reviewed_date'    => now(),
        ]);

        // Don't update inventory immediately - wait for admin approval
        // Inventory will be updated when admin approves the adjustment

        return redirect()->route('admin.stockadjustments.index')->with('success', 'Stock adjustment submitted for approval.');
    }
}
