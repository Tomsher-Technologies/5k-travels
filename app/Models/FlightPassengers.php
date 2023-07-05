<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightPassengers extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 
        'passenger_type', 
        'passenger_first_name', 
        'passenger_last_name', 
        'passenger_title', 
        'gender', 
        'date_of_birth', 
        'passport_number', 
        'passenger_nationality', 
        'eticket_number', 
        'itemRPH', 
        'created_at'
    ];
}
