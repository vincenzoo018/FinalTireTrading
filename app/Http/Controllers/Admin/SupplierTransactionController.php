<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuppTransOrder;
use App\Models\SuppOrderProd;
use App\Models\StockProd;
use App\Models\SupplierInvoice;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        
        // Load all products with their relationships for the modal
        $products = Product::with(['supplier', 'category'])
            ->select('products.*')
            ->get()
            ->map(function($product) {
                return [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'base_price' => $product->base_price ?? 0,
                    'supplier_id' => $product->supplier_id,
                    'category' => [
                        'category_id' => $product->category->category_id ?? null,
                        'category_name' => $product->category->category_name ?? 'N/A'
                    ]
                ];
            });
        
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

        // Use database transaction for data integrity
        DB::beginTransaction();
        try {
            // Server-side totals to ensure integrity
            $itemsTotal = collect($validated['items'])->sum(function($it){ return (float)$it['total']; });
            $deliveryFee = (float)($request->input('delivery_fee', 0));
            $tax = (float)$validated['tax'];
            $subTotal = $itemsTotal;
            $overallTotal = $subTotal + $tax + $deliveryFee;
            
            $deliveryReceived = (bool)$validated['delivery_received'];

            // Create the supplier transaction order
            $transaction = SuppTransOrder::create([
                'reference_num'    => $validated['reference_num'],
                'order_date'       => $validated['order_date'],
                'delivery_date'    => $validated['delivery_date'] ?? null,
                'delivery_fee'     => $deliveryFee,
                'delivery_received'=> $deliveryReceived,
                'estimated_date'   => $validated['estimated_date'] ?? null,
                'tax'              => $tax,
                'sub_total'        => $subTotal,
                'overall_total'    => $overallTotal,
                'supplier_id'      => $validated['supplier_id'],
            ]);

            // Create order products and optionally create StockProd records
            foreach ($validated['items'] as $item) {
                // Get product to calculate unit price
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $unitPrice = $quantity > 0 ? ((float)$item['total'] / $quantity) : 0;
                
                // Create SuppOrderProd record
                SuppOrderProd::create([
                    'transaction_id' => $transaction->transaction_id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $quantity,
                    'total'          => $item['total'],
                ]);

                // If delivery is received, create StockProd record
                // This represents the physical stock received from supplier
                if ($deliveryReceived) {
                    StockProd::create([
                        'supplier_id'  => $validated['supplier_id'],
                        'product_id'   => $item['product_id'],
                        'quantity'     => $quantity,
                        'unit_price'   => $unitPrice,
                        'total_cost'   => $item['total'],
                        'date'         => $validated['delivery_date'] ?? now(),
                        'status'       => 'In Stock',
                    ]);
                }
            }

            // Create Invoice
            $invoice = SupplierInvoice::create([
                'invoice_number' => SupplierInvoice::generateInvoiceNumber(),
                'transaction_id' => $transaction->transaction_id,
                'invoice_date' => now(),
                'due_date' => now()->addDays(30), // 30 days payment terms
                'subtotal' => $subTotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $overallTotal,
                'status' => 'issued',
            ]);

            DB::commit();
            
            $message = $deliveryReceived 
                ? 'Transaction created successfully. Invoice #' . $invoice->invoice_number . ' generated. Stock has been added to inventory.'
                : 'Transaction created successfully. Invoice #' . $invoice->invoice_number . ' generated. Awaiting delivery.';

            return redirect()->route('admin.transactions')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction creation failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to create transaction: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1,2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied.']);
        }

        $transaction = SuppTransOrder::with([
            'supplier', 
            'suppOrderProds.product.category',
            'invoice'
        ])->findOrFail($id);

        // If no invoice exists, create one (for old transactions)
        if (!$transaction->invoice) {
            $invoice = SupplierInvoice::create([
                'invoice_number' => SupplierInvoice::generateInvoiceNumber(),
                'transaction_id' => $transaction->transaction_id,
                'invoice_date' => $transaction->order_date,
                'due_date' => now()->addDays(30),
                'subtotal' => $transaction->sub_total,
                'tax' => $transaction->tax,
                'delivery_fee' => $transaction->delivery_fee,
                'total_amount' => $transaction->overall_total,
                'status' => 'issued',
            ]);
            $transaction->load('invoice');
        }

        return view('admin.transaction-invoice', compact('transaction'));
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


