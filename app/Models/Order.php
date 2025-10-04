<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id', 'cart_id', 'total_amount', 'discount', 'payment_method', 'order_date',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'order_id');
    }
}
