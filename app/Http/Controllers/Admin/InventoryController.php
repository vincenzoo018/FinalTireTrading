<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockProd;
use App\Models\Category;
use App\Models\Supplier;
use Carbon\Carbon;

class InventoryController extends Controller
{
    // Display paginated, searchable inventory
    public function index(Request $request)
    {
        $query = Inventory::with(['product.supplier', 'product.category'])
            ->orderBy('last_updated', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Search by product name
            $query->whereHas('product', function($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            });
        }

        $inventories = $query->paginate(10);
        // Fetch all products for the stock modal
        $products = Product::with('supplier')->get();
        // Fetch all categories and suppliers to use in the form dropdowns
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('admin.inventory', compact('inventories', 'products', 'categories', 'suppliers'));
    }

    // Store a new stock record and update inventory
    public function store(Request $request)
    {
        $previewRows = json_decode($request->preview_rows, true);

        if (!$previewRows || !is_array($previewRows)) {
            return back()->with('error', 'No stock data provided.');
        }

        foreach ($previewRows as $row) {
            // Validate each row
            $validated = \Validator::make($row, [
                'productId'   => 'required|exists:products,product_id',
                'supplierText'=> 'required|string',
                'categoryText'=> 'required|string',
                'basePrice'   => 'required|numeric|min:0',
                'sellingPrice'=> 'required|numeric|min:0',
                'quantity'    => 'required|integer|min:1',
            ])->validate();

            // Find product, supplier, category by name (or use IDs if you pass them)
            $product = \App\Models\Product::find($row['productId']);
            $supplier = $product->supplier;
            $category = $product->category;

            // Create StockProd record
            StockProd::create([
                'product_id'   => $product->product_id,
                'supplier_id'  => $supplier ? $supplier->supplier_id : null,
                'quantity'     => $row['quantity'],
                'unit_price'   => $row['basePrice'],
                'total_cost'   => $row['quantity'] * $row['basePrice'],
                'date'         => $request->date ?? now(),
                'status'       => $request->status ?? 'In Stock',
            ]);

            // Update Inventory
            $inventory = Inventory::where('product_id', $product->product_id)->first();
            if ($inventory) {
                $inventory->quantity_on_hand += $row['quantity'];
                $inventory->last_updated = now();
                $inventory->save();
            } else {
                Inventory::create([
                    'product_id'      => $product->product_id,
                    'quantity_on_hand'=> $row['quantity'],
                    'last_updated'    => now(),
                ]);
            }
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Stock added successfully.');
    }

    public function getProductBySerial(Request $request)
    {
        $serial = $request->serial;
        $product = Product::with(['supplier','category','inventory'])
            ->where('serial_number', $serial)
            ->first();

        if ($product) {
            return response()->json(['success' => true, 'product' => $product]);
        }
        return response()->json(['success' => false, 'message' => 'No matching product found']);
    }
}
