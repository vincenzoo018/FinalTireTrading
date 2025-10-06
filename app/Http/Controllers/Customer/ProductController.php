<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    // Show products for authenticated customers
    public function index(Request $request)
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to view products.']);
        }

        // Optional: Add filtering, searching, sorting here
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('product_name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_asc':
                    $query->orderBy('selling_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('selling_price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('product_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('product_name', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        // Paginate results
        $products = $query->paginate(12);

        return view('customer.products', compact('products'));
    }
}
