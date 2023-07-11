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
        'transaction_type', 
        'currency', 
        'total_amount', 
        'margin', 
        'amount', 
        'usd_rate', 
        'usd_amount', 
        'created_at'
    ];
}
