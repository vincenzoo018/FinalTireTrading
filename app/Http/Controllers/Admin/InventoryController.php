<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
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
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!\Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to access this page.']);
        }

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
        // Fetch all products for the stock modal with inventory and category data
        $products = Product::with(['supplier', 'category', 'inventory'])->get();
        // Fetch all categories and suppliers to use in the form dropdowns
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('admin.inventory', compact('inventories', 'products', 'categories', 'suppliers'));
    }

    // Store a new stock record and update inventory
    public function store(Request $request)
    {
        $stockData = json_decode($request->stock_data, true);

        if (!$stockData || !is_array($stockData)) {
            return back()->with('error', 'No stock data provided.');
        }

        $addedCount = 0;

        foreach ($stockData as $item) {
            // Validate each item
            $validated = \Validator::make($item, [
                'product_id'   => 'required|exists:products,product_id',
                'supplier_id'  => 'required|exists:suppliers,supplier_id',
                'base_price'   => 'required|numeric|min:0',
                'quantity'     => 'required|integer|min:1',
            ])->validate();

            $productId = $item['product_id'];
            $supplierId = $item['supplier_id'];
            $quantity = $item['quantity'];
            $basePrice = $item['base_price'];

            // Create StockProd record
            StockProd::create([
                'product_id'   => $productId,
                'supplier_id'  => $supplierId,
                'quantity'     => $quantity,
                'unit_price'   => $basePrice,
                'total_cost'   => $quantity * $basePrice,
                'date'         => now(),
                'status'       => 'In Stock',
            ]);

            // Update Inventory
            $inventory = Inventory::where('product_id', $productId)->first();
            if ($inventory) {
                $inventory->quantity_on_hand += $quantity;
                $inventory->last_updated = now();
                $inventory->save();
            } else {
                Inventory::create([
                    'product_id'      => $productId,
                    'quantity_on_hand'=> $quantity,
                    'last_updated'    => now(),
                ]);
            }

            $addedCount++;
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', "Successfully added stock for {$addedCount} product(s).");
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

    // Show single inventory record
    public function show($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1,2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $inventory = Inventory::with(['product.supplier', 'product.category'])->findOrFail($id);
        return response()->json($inventory);
    }

    // Update inventory quantity
    public function update(Request $request, $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1,2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied.']);
        }

        $validated = $request->validate([
            'quantity_on_hand' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'quantity_on_hand' => $validated['quantity_on_hand'],
            'last_updated' => now(),
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    // Delete inventory record
    public function destroy($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1,2])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json(['success' => true, 'message' => 'Inventory deleted successfully.']);
    }
}