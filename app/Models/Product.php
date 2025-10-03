<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
    'category_id', 'supplier_id', 'product_name', 'brand', 'size', 'length', 'width',
    'description', 'base_price', 'selling_price', 'serial_number', 'image'
];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

     public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function suppOrderProds()
    {
        return $this->hasMany(SuppOrderProd::class, 'product_id');
    }

    public function stockProds()
    {
        return $this->hasMany(StockProd::class, 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}