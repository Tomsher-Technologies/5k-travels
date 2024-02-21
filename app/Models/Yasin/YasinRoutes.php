<?php

namespace App\Models\Yasin;

use App\Models\Airports;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YasinRoutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'route',
        'from',
        'to',
        'status',
    ];

    public function fromAirport()
    {
        return $this->hasOne(Airports::class, 'AirportCode', 'from');
    }
    public function toAirport()
    {
        return $this->hasOne(Airports::class, 'AirportCode', 'to');
    }
}
