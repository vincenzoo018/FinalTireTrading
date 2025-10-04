<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index($order_id)
    {
        $items = OrderItem::with('product')->where('order_id', $order_id)->get();
        return view('customer.order_items', compact('items'));
    }
}