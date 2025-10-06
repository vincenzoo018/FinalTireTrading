<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'order_id',
        'user_id',
        'subtotal',
        'tax',
        'shipping',
        'total_amount',
        'payment_method',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


