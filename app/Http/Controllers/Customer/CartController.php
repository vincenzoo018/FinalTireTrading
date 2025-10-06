<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        // Only allow authenticated customers (role_id == 3)
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to view your cart.']);
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('customer.cart', compact('cartItems'));
    }
    public function add(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to add to cart.']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            // If item already exists, update quantity
            $cart->quantity += $request->quantity ?? 1;
            $cart->save();
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return redirect()->route('customer.cart')->with('success', 'Product added to cart!');
    }
    public function remove(Cart $cart)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to remove items from your cart.']);
        }

        // Ensure the cart item belongs to the logged-in user
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('customer.cart')->withErrors(['auth' => 'Unauthorized action.']);
        }

        $cart->delete();

        return redirect()->route('customer.cart')->with('success', 'Item removed from cart!');
    }
    public function clear()
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to clear your cart.']);
        }

        // Delete all cart items for the logged-in user
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.cart')->with('success', 'All items have been removed from your cart!');
    }

    public function updateQuantity(Request $request, Cart $cart)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login as a customer to update cart.']);
        }

        // Ensure the cart item belongs to the logged-in user
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('customer.cart')->withErrors(['auth' => 'Unauthorized action.']);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('customer.cart')->with('success', 'Cart updated successfully!');
    }
}
