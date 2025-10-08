<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])->where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('customer.orders', compact('orders'));
    }

    // Customer cancels pending order
    public function cancel(Order $order)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }
        if ($order->user_id !== Auth::id()) {
            return back()->withErrors(['order' => 'Unauthorized action.']);
        }
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be cancelled.']);
        }

        $order->status = 'cancelled';
        $order->cancelled_reason = request('cancelled_reason');
        $order->save();

        return back()->with('success', 'Order cancelled.');
    }

    // Customer marks order as received (complete)
    public function receive(Order $order)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }
        if ($order->user_id !== Auth::id()) {
            return back()->withErrors(['order' => 'Unauthorized action.']);
        }
        if (!in_array($order->status, ['approved','shipped'])) {
            return back()->withErrors(['order' => 'Only approved/shipped orders can be marked as received.']);
        }

        $order->status = 'completed';
        $order->received_date = now();
        $order->save();

        return back()->with('success', 'Thanks! Order marked as received.');
    }

    public function receipt(Order $order)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer.']);
        }
        if ($order->user_id !== Auth::id()) {
            return back()->withErrors(['order' => 'Unauthorized action.']);
        }

        $order->load(['items.product.category', 'user', 'payment']);

        return view('customer.order-receipt', compact('order'));
    }
}
