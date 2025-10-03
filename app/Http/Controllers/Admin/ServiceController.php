<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('employee')->get();
        $employees = Employee::all();
        return view('admin.services', compact('services', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
            'description' => 'nullable|string',
            'employee_id' => 'required|exists:employees,employee_id',
        ]);

        Service::create($validated);

        return redirect()->back()->with('success', 'Service added successfully!');
    }
}