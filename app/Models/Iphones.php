<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Iphones extends Model
{
    /** @use HasFactory<\Database\Factories\IphonesFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'gallery_id',
        'user_id',
        'slug',
        'created',
        'booked',
        'serial_number'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'iphone_id');
    }

    // Indirect relation ke Revenue
    public function revenues()
    {
        return $this->hasManyThrough(
            Revenue::class,
            Booking::class,
            'iphone_id',     // Foreign key di Booking
            'booking_id',    // Foreign key di Revenue
            'id',            // Local key di Iphone
            'id'             // Local key di Booking
        );
    }

    // public function durations()
    // {
    //     return $this->belongsToMany(Duration::class)
    //         ->withPivot('price')
    //         ->withTimestamps();
    // }

    public function durations()
    {
        return $this->belongsToMany(
            Duration::class,
            'duration_iphones', // pivot table
            'iphones_id',       // foreign key iphone
            'duration_id'       // foreign key duration
        )
            ->withPivot('price')
            ->withTimestamps();
    }


    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }
}
