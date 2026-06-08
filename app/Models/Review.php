<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [

        'iphone_id',
        'name',
        'rating',
        'comment'
        
    ];
    
    public function iphone()
    {
        return $this->belongsTo(Iphones::class);
    }
}
