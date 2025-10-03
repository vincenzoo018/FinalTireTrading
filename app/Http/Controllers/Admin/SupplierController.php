<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    // Display all suppliers
    public function index()
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view this page.']);
        }

        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('admin.supplier', compact('suppliers'));
    }

    // Store new supplier
    public function store(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to add suppliers.']);
        }

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'payment_terms' => 'required|string|max:255',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully.');
    }
}
