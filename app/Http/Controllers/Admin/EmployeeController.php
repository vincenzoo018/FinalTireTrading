<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display the employee list and form modal.
     */
    public function index()
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view this page.']);
        }

        // Get all employees without loading the role
        $employees = Employee::latest()->get();

        return view('admin.employee', compact('employees'));
    }

    /**
     * Store a new employee in the database.
     */
    public function store(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to perform this action.']);
        }

        $validated = $request->validate([
            'employee_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'position'        => 'required|string|max:100',
        ]);

        // Insert employee (role_id excluded)
        Employee::create($validated);

        return redirect()->route('admin.employee.index')->with('success', 'Employee added successfully!');
    }
}
