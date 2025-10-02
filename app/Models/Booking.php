<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = ['booking_date','booking_time','status','payment_method','service_id'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
