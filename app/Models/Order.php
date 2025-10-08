<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id', 'total_amount', 'discount', 'payment_method', 'order_date', 'status', 'payment_status',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'order_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    
    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'order_id')->latestOfMany('payment_id');
    }
    
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'order_id');
    }
    
    public function latestPayment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'order_id')->latest();
    }
}
