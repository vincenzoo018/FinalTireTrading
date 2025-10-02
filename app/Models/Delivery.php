<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $primaryKey = 'delivery_id';
    protected $fillable = ['delivery_date','receiving_no','shipping_fee','customer_id','order_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function vehicles()
    {
        return $this->hasMany(DeliveryVehicle::class, 'delivery_id');
    }
}

