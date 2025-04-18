<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'type',
        'flight_number',
        'departure_airport',
        'arrival_airport',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public const TYPES = [
        'DO' => 'Day Off',
        'SBY' => 'Standby',
        'FLT' => 'Flight',
        'CI' => 'Check-in',
        'CO' => 'Check-out',
        'UNK' => 'Unknown',
    ];
}
