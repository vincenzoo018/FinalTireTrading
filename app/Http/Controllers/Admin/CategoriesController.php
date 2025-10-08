<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    // Display all categories
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view this page.']);
        }

        $query = Category::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('category_name', 'like', "%{$search}%");
        }
        $categories = $query->orderBy('created_at', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    // Show single category (for view modal)
    public function show($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Update category
    public function update(Request $request, $id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to edit categories.']);
        }

        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy($id)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!auth()->check() || !in_array(auth()->user()->role_id, [1, 2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
