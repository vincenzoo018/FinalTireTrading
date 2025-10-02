<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProd extends Model
{
    protected $primaryKey = 'stock_prod_id';
    protected $fillable = ['supplier_id','product_id','quantity','unit_price','total_cost','date','status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function adjustments()
    {
        return $this->hasMany(StockAdjustment::class, 'stock_prod_id');
    }
}
