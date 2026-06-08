<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    /** @use HasFactory<\Database\Factories\DurationFactory> */
    use HasFactory;

    protected $fillable = [
        'hours',
    ];
    
    public function iphones()
    {
        return $this->belongsToMany(Iphones::class)
            ->withPivot('price')
            ->withTimestamps();
    }
}
