<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Models\StockProd;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    // Show all adjustments
    public function index()
{
    $adjustments = StockAdjustment::with('stockProd.product')->orderBy('created_at', 'desc')->paginate(10);
    $inventories = StockProd::with('product')->get();
    return view('admin.stockadjustments', compact('adjustments', 'inventories'));
}

    // Store a new adjustment and update inventory
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_prod_id'    => 'required|exists:stock_prods,stock_prod_id',
            'reason'           => 'required|string|max:255',
            'adjustment_type'  => 'required|in:add,subtract,damage,missing,return,correction',
            'physical_count'   => 'required|integer|min:0',
            'system_count'     => 'required|integer|min:0',
            'adjust_count'     => 'required|integer',
            'status'           => 'required|in:active,inactive',
        ]);

        // Create adjustment
        $adjustment = StockAdjustment::create([
            'stock_prod_id'    => $validated['stock_prod_id'],
            'reason'           => $validated['reason'],
            'adjustment_type'  => $validated['adjustment_type'],
            'physical_count'   => $validated['physical_count'],
            'system_count'     => $validated['system_count'],
            'adjust_count'     => $validated['adjust_count'],
            'status'           => $validated['status'],
            // 'reviewed_by'    => Auth::id(), // Uncomment if you add approval
            // 'reviewed_date'  => now(),      // Uncomment if you add approval
        ]);

        // Update inventory immediately
        $stockProd = StockProd::find($validated['stock_prod_id']);
        $inventory = Inventory::where('product_id', $stockProd->product_id)->first();

        if ($inventory) {
            switch ($validated['adjustment_type']) {
                case 'add':
                case 'return':
                    $inventory->quantity += $validated['adjust_count'];
                    break;
                case 'subtract':
                case 'damage':
                case 'missing':
                    $inventory->quantity -= $validated['adjust_count'];
                    break;
                case 'correction':
                    $inventory->quantity = $validated['physical_count'];
                    break;
            }
            $inventory->save();
        }

        return redirect()->route('admin.stockadjustments.index')->with('success', 'Stock adjustment applied.');
    }
}
