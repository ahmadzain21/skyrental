<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class SocialMedia extends Component
{
    public string $youtube;
    public string $tiktok;
    public string $instagram;
    public string $facebook;
    public string $twitter;
    public string $whatsapp;
    public string $telegram;

    public function mount(GeneralSettings $settings)
    {
        $this->youtube = $settings->youtube;
        $this->tiktok = $settings->tiktok;
        $this->instagram = $settings->instagram;
        $this->facebook = $settings->facebook;
        $this->twitter = $settings->twitter;
        $this->whatsapp = $settings->whatsapp;
        $this->telegram = $settings->telegram;
    }

    public function save()
    {
        $this->validate([
            'youtube'   => 'nullable|url|starts_with:https://',
            'tiktok'    => 'nullable|url|starts_with:https://',
            'instagram' => 'nullable|url|starts_with:https://',
            'facebook'  => 'nullable|url|starts_with:https://',
            'twitter'   => 'nullable|url|starts_with:https://',
            'whatsapp'  => 'nullable|url|starts_with:https://',
            'telegram'  => 'nullable|url|starts_with:https://',
        ]);


        $settings = app(GeneralSettings::class);

        // social media links
        $settings->youtube = $this->youtube;
        $settings->tiktok = $this->tiktok;
        $settings->instagram = $this->instagram;
        $settings->facebook = $this->facebook;
        $settings->twitter = $this->twitter;
        $settings->whatsapp = $this->whatsapp;
        $settings->telegram = $this->telegram;
        $settings->save();

        LivewireAlert::title('Setelan berhasil diperbarui')
            ->text('Setelan website kamu telah berhasil diperbarui.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.settings.social-media');
    }
}
