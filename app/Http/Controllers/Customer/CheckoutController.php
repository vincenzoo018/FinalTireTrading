<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to proceed to checkout.']);
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        return view('customer.checkout', compact('cartItems'));
    }

    public function completePurchase(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as a customer to complete your purchase.']);
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')->withErrors(['cart' => 'Your cart is empty.']);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($cart) {
            return $cart->product->selling_price * ($cart->quantity ?? 1);
        });
        $tax = $subtotal * 0.12;
        $shipping = 200;
        $total = $subtotal + $tax + $shipping;

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'discount' => 0,
            'payment_method' => $request->payment_method,
            'order_date' => now(),
        ]);

        foreach ($cartItems as $cart) {
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $cart->product_id,
                'quantity'   => $cart->quantity ?? 1,
                'price'      => $cart->product->selling_price,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.orders')->with('success', 'Your order has been placed successfully!');
    }
}
