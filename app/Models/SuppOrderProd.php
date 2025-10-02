<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppOrderProd extends Model
{
    protected $primaryKey = 'supp_prod_id';
    protected $fillable = ['transaction_id','product_id','quantity','total'];

    public function transaction()
    {
        return $this->belongsTo(SuppTransOrder::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
