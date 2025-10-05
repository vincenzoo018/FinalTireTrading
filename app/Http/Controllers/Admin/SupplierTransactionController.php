<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuppTransOrder;
use App\Models\SuppOrderProd;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SupplierTransactionController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1,2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied.']);
        }

        $query = SuppTransOrder::with(['supplier','suppOrderProds.product'])->orderBy('created_at','desc');
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('reference_num','like',"%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search){
                      $sq->where('supplier_name','like',"%{$search}%");
                  });
            });
        }
        $transactions = $query->paginate(10)->appends($request->only('supplier_id','search'));
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.transactions', compact('transactions','suppliers','products'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        $validated = $request->validate([
            'reference_num'   => 'required|string|max:255',
            'order_date'      => 'required|date',
            'delivery_date'   => 'nullable|date',
            'delivery_fee'    => 'nullable|numeric|min:0',
            'delivery_received'=> 'required|in:0,1',
            'estimated_date'  => 'nullable|date',
            'tax'             => 'required|numeric|min:0',
            'supplier_id'     => 'required|exists:suppliers,supplier_id',
            'items'           => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.total'      => 'required|numeric|min:0',
        ]);
        // Server-side totals to ensure integrity
        $itemsTotal = collect($validated['items'])->sum(function($it){ return (float)$it['total']; });
        $deliveryFee = (float)($request->input('delivery_fee', 0));
        $tax = (float)$validated['tax'];
        $subTotal = $itemsTotal;
        $overallTotal = $subTotal + $tax + $deliveryFee;

        $transaction = SuppTransOrder::create([
            'reference_num'    => $validated['reference_num'],
            'order_date'       => $validated['order_date'],
            'delivery_date'    => $validated['delivery_date'] ?? null,
            'delivery_fee'     => $deliveryFee,
            'delivery_received'=> (bool)$validated['delivery_received'],
            'estimated_date'   => $validated['estimated_date'] ?? null,
            'tax'              => $tax,
            'sub_total'        => $subTotal,
            'overall_total'    => $overallTotal,
            'supplier_id'      => $validated['supplier_id'],
        ]);

        foreach ($validated['items'] as $item) {
            SuppOrderProd::create([
                'transaction_id' => $transaction->transaction_id,
                'product_id'     => $item['product_id'],
                'quantity'       => $item['quantity'],
                'total'          => $item['total'],
            ]);
        }

        return redirect()->route('admin.transactions', ['supplier_id' => $validated['supplier_id']])
            ->with('success', 'Transaction created successfully.');
    }

    public function supplierHistory(Request $request, $supplierId)
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return response()->json(['success'=>false], 403);
        }
        $history = SuppTransOrder::where('supplier_id', $supplierId)
            ->orderBy('created_at','desc')
            ->limit(10)
            ->get(['transaction_id','reference_num','order_date','delivery_date','overall_total','tax']);
        return response()->json(['success'=>true,'data'=>$history]);
    }
}


