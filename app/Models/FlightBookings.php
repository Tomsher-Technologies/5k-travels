<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBookings extends Model
{
    use HasFactory;
    protected $fillable = [
        'api_provider', 
        'user_id', 
        'unique_booking_id', 
        'direction',
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
        'cancel_request',
        'is_cancelled',
        'adult_amount', 
        'child_amount', 
        'infant_amount', 
        'total_amount', 
        'addon_amount', 
        'total_tax',
        'created_at',
        'currency',
        'total_amount_actual', 
        'total_tax_actual', 
        'admin_margin', 
        'admin_amount', 
        'agents_amount',
        'cancel_request',
        'is_reissued',
        'parent_id',
        'customer_name',
        'reschedule_fare_difference',
        'is_domestic',
        'payment_status',
        'payment_reference',
    ];
}
