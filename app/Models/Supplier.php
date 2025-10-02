<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_name','company_name','address','contact_person','contact_number','email','payment_terms'];

    public function transactions()
    {
        return $this->hasMany(SuppTransOrder::class, 'supplier_id');
    }

    public function stockProds()
    {
        return $this->hasMany(StockProd::class, 'supplier_id');
    }
}

