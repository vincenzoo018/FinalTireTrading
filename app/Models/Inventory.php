<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'inventory_id';
    protected $fillable = ['product_id','quantity_on_hand','last_updated'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
