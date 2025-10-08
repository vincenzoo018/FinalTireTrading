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

    // Show single service (for view modal)
    public function show($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $service = Service::with('employee')->findOrFail($id);
        return response()->json($service);
    }

    // Update service
    public function update(Request $request, $id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to edit services.']);
        }

        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
            'description' => 'nullable|string',
            'employee_id' => 'required|exists:employees,employee_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
        }

        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully!');
    }

    // Delete service
    public function destroy($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $service = Service::findOrFail($id);

        // Delete image if exists
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully.']);
    }
}