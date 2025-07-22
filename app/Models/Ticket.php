<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'schedule_id',
        'seat_number',
        'price',
        'status',
        'canceled_at',
    ];

    protected $casts = [
        'canceled_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
