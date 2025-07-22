<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'status',
        'canceled_at',
        'total_amount',
        'cancellation_reason',
        'payment_proof',
        'payment_proof_uploaded_at',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'canceled_at' => 'datetime',
        'payment_proof_uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function canBeCanceled()
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        // Get the first ticket's schedule
        $firstTicket = $this->tickets()->first();
        if (!$firstTicket || !$firstTicket->schedule) {
            return false;
        }

        return $firstTicket->schedule->departure_time->subHours(2)->isFuture();
    }
}
