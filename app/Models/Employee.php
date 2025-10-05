<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'employee_id';
    protected $fillable = ['employee_name', 'contact_number', 'position', 'role_id', 'user_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'employee_id');
    }

    public function stockAdjustmentsRequested()
    {
        return $this->hasMany(StockAdjustment::class, 'requested_by');
    }

    public function stockAdjustmentsReviewed()
    {
        return $this->hasMany(StockAdjustment::class, 'reviewed_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
