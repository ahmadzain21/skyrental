<?php

namespace App\Livewire\Iphones;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class SetDate extends Component
{
    #[Modelable]
    public $value;
    public $isEdit = false;
    
    public function render()
    {
        return view('livewire.iphones.set-date');
    }
}
