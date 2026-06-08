<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class TermsConditions extends Component
{
    public string $terms_conditions;
    
    public function save()
    {
        $this->validate([
            'terms_conditions' => 'nullable|string',
        ]);

        $settings = app(GeneralSettings::class);
        $settings->terms_conditions = $this->terms_conditions;
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
        $this->terms_conditions = $setting->terms_conditions;
    }
    
    public function render()
    {
        return view('livewire.settings.terms-conditions');
    }
}
