<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class PrivacyPolicy extends Component
{
    public string $privacy_policy;

     public function save()
    {
        $this->validate([
            'privacy_policy' => 'nullable|string',
        ]);

        $settings = app(GeneralSettings::class);
        $settings->privacy_policy = $this->privacy_policy;
        $settings->save();

        LivewireAlert::title('Setelan berhasil diperbarui')
            ->text('Setelan website kamu telah berhasil diperbarui.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
    
    public function mount(GeneralSettings $settings)
    {
        $this->privacy_policy = $settings->privacy_policy;
    }
    
    
    public function render()
    {
        return view('livewire.settings.privacy-policy');
    }
}
