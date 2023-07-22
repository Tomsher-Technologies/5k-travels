<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSearches extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'origin', 'destination', 'from_date', 'to_date', 'cabin_class','direction'
    ];
}
