<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    // Display all suppliers
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view this page.']);
        }

        $query = Supplier::orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('supplier_name', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('contact_number', 'LIKE', "%{$search}%");
            });
        }

        $suppliers = $query->get();

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json($suppliers);
        }

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

    // Show single supplier (for view modal)
    public function show($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    // Update supplier
    public function update(Request $request, $id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to edit suppliers.']);
        }

        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $id . ',supplier_id',
            'payment_terms' => 'required|string|max:255',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    // Delete supplier
    public function destroy($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }
}
