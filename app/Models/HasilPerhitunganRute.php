<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPerhitunganRute extends Model
{
    use HasFactory;

    public function ruteKunjungan() {
        return $this->hasMany(RuteKunjungan::class);
    }
}
