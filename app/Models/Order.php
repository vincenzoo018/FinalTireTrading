<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $fillable = ['total_amount','discount','payment_method','order_date','customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'order_id');
    }
}
