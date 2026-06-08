<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class HowToRent extends Component
{
    public string $how_to_rent;

    public function save()
    {
        $this->validate([
            'how_to_rent' => 'nullable|string',
        ]);

        $settings = app(GeneralSettings::class);
        $settings->how_to_rent = $this->how_to_rent;
        $settings->save();

        LivewireAlert::title('Setelan berhasil diperbarui')
            ->text('Setelan website kamu telah berhasil diperbarui.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function mount(GeneralSettings $setting)
    {
        $this->how_to_rent = $setting->how_to_rent;
    }

    public function render()
    {
        return view('livewire.settings.how-to-rent');
    }
}
