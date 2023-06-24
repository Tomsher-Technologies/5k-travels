<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBookings extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'unique_booking_id', 
        'client_ref', 
        'fare_type', 
        'origin', 
        'destination', 
        'customer_email', 
        'phone_code', 
        'customer_phone', 
        'adult_count', 
        'child_count', 
        'infant_count', 
        'booking_status', 
        'ticket_status', 
        'adult_amount', 
        'child_amount', 
        'infant_amount', 
        'total_amount', 
        'addon_amount', 
        'total_tax',
        'created_at'
    ];
}
