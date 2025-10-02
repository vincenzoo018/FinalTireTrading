<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{
    protected $primaryKey = 'vehicle_id';
    protected $fillable = ['delivery_id','vehicle_name','vehicle_plate_number','date'];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
}
