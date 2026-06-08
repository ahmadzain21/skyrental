<?php

namespace App\Livewire;

use App\Models\Iphones;
use App\Models\Review;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Reviews extends Component
{
    public $iphone_id;
    public $comment;
    public $rating;
    public $name;
    #[Reactive]
    public $reviews;
    #[Modelable]
    public $avgRating;

    public function mount($iphone_id, $rating, $name , $reviews, $avgRating)
    {
        $this->iphone_id =  $iphone_id;
        $this->rating = $rating;
        $this->name = $name;
        $this->reviews = $reviews;
        $this->avgRating = $avgRating;
    }

    public function save()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'name' => $this->name,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'iphone_id' => $this->iphone_id
        ]);

        $this->reset([
            'comment',
            'rating',
        ]);

        LivewireAlert::title('Review ditambahkan')
            ->text('Berhasil menambahkan reviews')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
        $this->dispatch('get-reviews');
        // $this->getReviews();
    }

    function generateAnonymousName(): string
    {
        $prefix = 'anon';
        $code = strtoupper(Str::random(6)); // gunakan helper Laravel Str
        return "{$prefix}-{$code}";
    }


    public function render()
    {
        return view('livewire.reviews');
    }
}
