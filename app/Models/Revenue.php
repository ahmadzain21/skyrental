<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'booking_id',
        'amount',
        'type',
        'created'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
