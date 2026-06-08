<?php

namespace App\Livewire\Iphones;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class SetSlug extends Component
{
    #[Modelable]
    public $value;
    
    public function render()
    {
        return view('livewire.iphones.set-slug');
    }
}
