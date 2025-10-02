<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    // Display all categories
    public function index(Request $request)
    {
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
}
