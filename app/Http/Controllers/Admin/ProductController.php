<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier', 'inventory'])->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('product_name', 'like', "%" . $search . "%");
        }
        $products = $query->get();
        $categories = Category::all();
        $suppliers = Supplier::all();

        if ($request->ajax()) {
            return view('admin._productTable', compact('products'))->render();
        }

        return view('admin.product', compact('products', 'categories', 'suppliers'));
    }

    // Store the product in the database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:255',
            'width' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'serial_number' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $data['image'] = 'images/' . $imageName; // Save as 'images/filename.png'
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }
}
