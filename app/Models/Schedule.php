<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'departure_time',
        'arrival_time',
        'price',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function availableSeats()
    {
        $bookedSeats = $this->tickets()->where('status', 'active')->pluck('seat_number')->toArray();
        $totalSeats = range(1, $this->bus()->first()->capacity ?? 0);
        return array_diff($totalSeats, $bookedSeats);
    }
}
