<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuteKunjungan extends Model
{
    use HasFactory;

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
