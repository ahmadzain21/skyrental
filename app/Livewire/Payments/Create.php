<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{

    use WithFileUploads;

    public $name;
    public $slug;
    public $icon;
    public $description;
    public $is_active = true;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);

        $iconPath = null;

        if ($this->icon) {
            $iconPath = $this->icon->store('payments/icons', 'public');
        }

        Payment::create([
            'name' => $this->name,
            'icon' => $iconPath,
            'description' => $this->description,
            'is_active' => true,
            'slug' => $this->setSlugAttribute()
        ]);
        $this->dispatch('close-modal');
        $this->reset(['name', 'icon', 'description']);
        $this->dispatch('refresh-payment');

        LivewireAlert::title('Payment method berhasil dibuat')
            ->text('Berhasil menambahkan payment')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function setSlugAttribute()
    {
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 2;

        while (Payment::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.payments.create');
    }
}
