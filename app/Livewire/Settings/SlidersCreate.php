<?php

namespace App\Livewire\Settings;

use App\Models\Slider;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class SlidersCreate extends Component
{

    public $iphone_id;
    public $main;
    public $background = '#000000';

    #[On('setSelectedIphone')]
    public function setIphone($value)
    {
        $this->iphone_id = $value;
    }

    #[On('select-poster')]
    public function setImage($id, $url)
    {
        $this->main = $url;
        $this->dispatch('image-selected');
    }

    #[On('remove-img')]
    public function removeImg()
    {
        $this->main = '';
    }

    public function setImg()
    {
        $this->dispatch('open-modal', 'add-image');
    }

    public function save()
    {
        $this->validate([
            'iphone_id' => 'required',
            'main' => 'nullable',
            'background' => 'nullable|string',
        ]);

        Slider::create([
            'iphone_id' => $this->iphone_id,
            'main' => $this->main,
            'background' => $this->background,
        ]);

        $this->dispatch('close-modal');
        LivewireAlert::title('Slider created successfully')
            ->position('top-end')
            ->text('Berhasil membuat slider baru')
            ->timer(5000)
            ->success()
            ->toast()
            ->show();
        $this->dispatch('re-render');
        $this->reset(['iphone_id', 'main', 'background']);
    }

    public function render()
    {
        return view('livewire.settings.sliders-create');
    }
}
