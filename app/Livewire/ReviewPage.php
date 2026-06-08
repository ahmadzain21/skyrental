<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class ReviewPage extends Component
{
    public $rating = 5;

    public function render()
    {
        $reviews = Review::where('rating', 5)
            ->latest() // urutkan dari yang terbaru
            ->take(10) // ambil 10 data
            ->get();

        return view('livewire.review-page', [
            'reviews' => $reviews
        ]);
    }
}
