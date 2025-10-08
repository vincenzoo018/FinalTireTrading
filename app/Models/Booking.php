<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = ['user_id','booking_date','booking_time','status','payment_method','service_id','notes','payment_status'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sale()
    {
        return $this->hasOne(Sale::class, 'booking_id', 'booking_id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }
    
    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'booking_id')->latest();
    }
}
