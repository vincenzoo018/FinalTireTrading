<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier; // Assuming you have a Supplier model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product', compact('products', 'categories', 'suppliers'));
    }

    // Store the product in the database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,id', // Assuming supplier id is 'id'
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:255',
            'width' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'serial_number' => 'nullable|string|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }
}
