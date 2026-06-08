<?php

namespace App\Livewire;

use App\Models\Iphones;
use Livewire\Component;

class Prices extends Component
{
    public $iphones;

    public function mount()
    {
        // load iPhone beserta durasinya + harga (pivot)
        $this->iphones = Iphones::with('durations')->get();
    }
    
    public function render()
    {
        return view('livewire.prices');
    }
}
