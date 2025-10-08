<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view services.']);
        }

        $services = Service::with('employee')->get();
        $employees = Employee::all();
        return view('admin.services', compact('services', 'employees'));
    }

    public function store(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to add services.']);
        }

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
            'description' => 'nullable|string',
            'employee_id' => 'required|exists:employees,employee_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
        }

        // Set service as available by default
        $validated['is_available'] = true;

        Service::create($validated);

        return redirect()->back()->with('success', 'Service added successfully!');
    }
}