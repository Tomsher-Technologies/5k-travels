<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightMarginAmounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 
        'agent_id', 
        'margin', 
        'amount', 
        'created_at'
    ];
}
