<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppTransOrder extends Model
{
    protected $primaryKey = 'transaction_id';
    protected $fillable = ['reference_num','order_date','delivery_date','delivery_fee','delivery_received','estimated_date','tax','sub_total','overall_total','supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function suppOrderProds()
    {
        return $this->hasMany(SuppOrderProd::class, 'transaction_id');
    }
}

