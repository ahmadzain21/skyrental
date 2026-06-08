<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class MobileNavigation extends Component
{
    public bool $showDrawer1 = false;
    
    public function render()
    {
        return view('livewire.layout.mobile-navigation');
    }
}
