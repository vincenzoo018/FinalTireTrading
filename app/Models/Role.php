<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['position'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'role_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'role_id');
    }
}

