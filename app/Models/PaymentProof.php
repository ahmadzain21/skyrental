<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentProofFactory> */
    use HasFactory;

    protected $fillable = ['booking_id', 'file_path', 'is_confirm'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
