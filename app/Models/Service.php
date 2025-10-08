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

    // Check if service is available for booking (always available now)
    public function isAvailableForUser($userId)
    {
        // Service is available as long as it's marked as available
        // Users can book the same service multiple times
        return $this->is_available;
    }

    // Get pending/confirmed bookings count
    public function getActiveBookingsCount()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }
    
    // Get user's active bookings for this service
    public function getUserActiveBookingsCount($userId)
    {
        return $this->bookings()
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }
    
    /**
     * Check if a specific date/time slot is available for booking
     * Returns true if the slot is available, false if already booked
     */
    public function isTimeSlotAvailable($date, $time)
    {
        // Check if there's an active booking for this service at the specified date/time
        $existingBooking = $this->bookings()
            ->where('booking_date', $date)
            ->where('booking_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();
        
        return $existingBooking === null;
    }
    
    /**
     * Get all booked time slots for a specific date
     * Returns array of booked times
     */
    public function getBookedTimeSlotsForDate($date)
    {
        return $this->bookings()
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_time')
            ->toArray();
    }
}