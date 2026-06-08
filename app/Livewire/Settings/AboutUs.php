<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class AboutUs extends Component
{
    public string $about_us;

    public function save()
    {
        $this->validate([
            'about_us' => 'nullable|string',
        ]);

        $settings = app(GeneralSettings::class);
        $settings->about_us = $this->about_us;
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
        $this->about_us = $setting->about_us;
    }

    public function render()
    {
        return view('livewire.settings.about-us');
    }
}
