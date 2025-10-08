<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'user_id',
        'order_id',
        'booking_id',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_details',
        'payment_date',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'payment_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
