<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightItineraryDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 
        'airline_pnr', 
        'arrival_airport', 
        'arrival_date_time', 
        'arrival_terminal', 
        'baggage', 
        'cabin_class', 
        'departure_airport', 
        'departure_date_time', 
        'departure_terminal', 
        'flight_number', 
        'item_rph', 
        'journey_duration', 
        'marketing_airline_code', 
        'number_in_party', 
        'operating_airline_code', 
        'res_book_desig_code', 
        'stop_quantity', 
        'created_at'
    ];
}


