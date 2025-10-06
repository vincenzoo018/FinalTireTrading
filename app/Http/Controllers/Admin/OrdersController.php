<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Sale;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view orders.']);
        }

        $query = Order::with(['user', 'items.product']);

        // Filter by user name or email
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->user . '%')
                  ->orWhere('lname', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        // Filter by product name
        if ($request->filled('product')) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->product . '%');
            });
        }

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('fname', 'like', "%$search%")
                       ->orWhere('lname', 'like', "%$search%")
                       ->orWhere('email', 'like', "%$search%");
                })
                ->orWhereHas('items.product', function ($pq) use ($search) {
                    $pq->where('product_name', 'like', "%$search%");
                })
                ->orWhere('status', 'like', "%$search%");
            });
        }

        $orders = $query->latest()->paginate(15);

        // AJAX response for live search
        if ($request->ajax()) {
            return view('admin.partials.orders_table', compact('orders'))->render();
        }

        return view('admin.orders', compact('orders'));
    }

    // Approve order: deduct inventory, record sale, set status approved
    public function approve(Request $request, Order $order)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to approve orders.']);
        }
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be approved.']);
        }

        $request->validate([
            'approved_note' => 'nullable|string|max:255',
        ]);

        $order->load('items');
        foreach ($order->items as $item) {
            $inventory = Inventory::where('product_id', $item->product_id)->first();
            if ($inventory) {
                $inventory->quantity_on_hand = max(0, ($inventory->quantity_on_hand ?? 0) - ($item->quantity ?? 1));
                $inventory->last_updated = now();
                $inventory->save();
            }
        }

        $subtotal = $order->items->sum(function ($i) { return $i->price * $i->quantity; });
        $tax = $subtotal * 0.12;
        $shipping = max(0, $order->total_amount - ($subtotal + $tax));
        Sale::updateOrCreate(
            ['order_id' => $order->order_id],
            [
                'user_id'        => $order->user_id,
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'shipping'       => $shipping,
                'total_amount'   => $order->total_amount,
                'payment_method' => $order->payment_method,
            ]
        );

        $order->status = 'approved';
        $order->approved_date = now();
        $order->approved_note = $request->approved_note;
        $order->rejected_reason = null;
        $order->save();

        return back()->with('success', 'Order approved successfully.');
    }

    // Reject order: require reason
    public function reject(Request $request, Order $order)
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to reject orders.']);
        }
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be rejected.']);
        }

        $validated = $request->validate([
            'rejected_reason' => 'required|string|max:255',
        ]);

        $order->status = 'rejected';
        $order->rejected_reason = $validated['rejected_reason'];
        $order->approved_date = null;
        $order->approved_note = null;
        $order->save();

        return back()->with('success', 'Order rejected.');
    }
}
