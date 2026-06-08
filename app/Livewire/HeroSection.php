<?php

namespace App\Livewire;

use App\Models\Slider;
use Livewire\Component;

class HeroSection extends Component
{
    public function render()
    {
        $sliders = Slider::all();   
        return view('livewire.hero-section', [
            'sliders' => $sliders
        ]);
    }
}
