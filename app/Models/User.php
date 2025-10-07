<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Must extend this
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'username',
        'password',
        'email',
        'phone',
        'address',
        'is_active',
        'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id', 'user_id');
    }

    // Helper method for full name
    public function getFullNameAttribute()
    {
        return trim("{$this->fname} {$this->mname} {$this->lname}");
    }

    // Helper method to check if user is admin
    public function isAdmin()
    {
        return in_array($this->role_id, [1, 2]);
    }

    // Helper method to check if user is customer
    public function isCustomer()
    {
        return $this->role_id == 3;
    }
}
