<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $primaryKey = 'stock_adjustment_id';
    protected $fillable = ['stock_prod_id','reviewed_date','reason','adjustment_type','physical_count','system_count','adjust_count','status'];

    public function stockProd()
    {
        return $this->belongsTo(StockProd::class, 'stock_prod_id');
    }


}
