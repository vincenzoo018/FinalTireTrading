<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Process payment for an order
     */
    public function processOrderPayment(Request $request, Order $order)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this order'], 403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|in:Credit Card,Debit Card,PayPal,Bank Transfer,GCash',
            'card_number' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_name' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_expiry' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_cvv' => 'required_if:payment_method,Credit Card,Debit Card',
        ]);

        // Create payment record
        $paymentDetails = [];
        
        if (in_array($validated['payment_method'], ['Credit Card', 'Debit Card'])) {
            // Mask card number for security
            $cardNumber = $validated['card_number'];
            $maskedCard = '****-****-****-' . substr($cardNumber, -4);
            
            $paymentDetails = [
                'card_number' => $maskedCard,
                'card_name' => $validated['card_name'],
                'card_expiry' => $validated['card_expiry'],
            ];
        }

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'order_id' => $order->order_id,
            'booking_id' => null,
            'amount' => $order->total_amount,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'completed', // In real app, this would be 'processing' initially
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'payment_details' => $paymentDetails,
            'payment_date' => now(),
        ]);

        // Update order payment status
        $order->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'transaction_id' => $payment->transaction_id,
            'payment_id' => $payment->payment_id,
        ]);
    }

    /**
     * Process payment for a booking
     */
    public function processBookingPayment(Request $request, Booking $booking)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($booking->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this booking'], 403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|in:Credit Card,Debit Card,PayPal,Bank Transfer,GCash,Cash',
            'card_number' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_name' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_expiry' => 'required_if:payment_method,Credit Card,Debit Card',
            'card_cvv' => 'required_if:payment_method,Credit Card,Debit Card',
        ]);

        // Get service price
        $amount = $booking->service ? $booking->service->service_price : 0;

        // Create payment record
        $paymentDetails = [];
        
        if (in_array($validated['payment_method'], ['Credit Card', 'Debit Card'])) {
            // Mask card number for security
            $cardNumber = $validated['card_number'];
            $maskedCard = '****-****-****-' . substr($cardNumber, -4);
            
            $paymentDetails = [
                'card_number' => $maskedCard,
                'card_name' => $validated['card_name'],
                'card_expiry' => $validated['card_expiry'],
            ];
        }

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'order_id' => null,
            'booking_id' => $booking->booking_id,
            'amount' => $amount,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'completed', // In real app, this would be 'processing' initially
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'payment_details' => $paymentDetails,
            'payment_date' => now(),
        ]);

        // Update booking payment method
        $booking->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'transaction_id' => $payment->transaction_id,
            'payment_id' => $payment->payment_id,
        ]);
    }

    /**
     * Get payment details
     */
    public function show(Payment $payment)
    {
        if (!Auth::check() || Auth::user()->role_id != 3) {
            return redirect()->route('login');
        }

        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('customer.payment-details', compact('payment'));
    }
}
