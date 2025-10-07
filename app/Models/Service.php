<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';
    protected $fillable = ['service_name','service_price','description','image','employee_id','is_available'];

    protected $casts = [
        'is_available' => 'boolean',
        'service_price' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    // Check if service is available for booking
    public function isAvailableForUser($userId)
    {
        // Check if user has any pending or confirmed bookings for this service
        $existingBooking = $this->bookings()
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
            
        return $this->is_available && !$existingBooking;
    }

    // Get pending/confirmed bookings count
    public function getActiveBookingsCount()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }
}