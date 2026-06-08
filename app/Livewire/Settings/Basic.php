<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSettings;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Basic extends Component
{
    public string $site_name;
    public string $logo_cms;
    public string $favicon;
    public string $description;
    public string $logo;
    public string $primary_color = '#000000';
    public string $wichImage;
    public string $tagline;
    public string $terms_conditions;

    public function mount(GeneralSettings $settings)
    {
        $this->site_name = $settings->site_name;
        $this->primary_color = $settings->primary_color;
        $this->logo_cms = $settings->logo_cms;
        $this->logo = $settings->logo;
        $this->favicon = $settings->favicon;
        $this->description = $settings->description;
        $this->tagline = $settings->tagline;
        $this->terms_conditions = $settings->terms_conditions;
        
    }

    public function update()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
            $this->validate([
                'logo_cms' => 'nullable|string',
                'logo' => 'nullable|string',
                'favicon' => 'nullable|string',
                'description' => 'nullable|string',
                'site_name' => 'nullable|string',
                'primary_color' => 'required|string',
                'tagline' => 'nullable|string',
                'terms_conditions' => 'nullable|string',
                
            ]);

            $settings = new GeneralSettings();

            $settings->site_name = $this->site_name;
            $settings->description = $this->description;
            $settings->logo_cms = $this->logo_cms;
            $settings->logo = $this->logo;
            $settings->favicon = $this->favicon;
            $settings->primary_color = $this->primary_color;
            $settings->tagline = $this->tagline;
            $settings->terms_conditions = $this->terms_conditions;

            $settings->save();

            LivewireAlert::title('Setelan berhasil diperbarui')
                ->text('Setelan website kamu telah berhasil diperbarui.')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Kamu tidak memiliki izin')
                ->text('Kamu tidak memiliki izin untuk mengubah setelan ini.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    #[On('select-poster')]
    public function setSelectedposted($id, $url)
    {
        if ($this->wichImage === 'logo_cms') {
            # code...
            $this->logo_cms = $url;
        } elseif ($this->wichImage === 'logo') {
            $this->logo = $url;
        } else {
            $this->favicon = $url;
        }
    }

    #[On('wich-image')]
    public function setWichImage($props)
    {
        $this->wichImage = $props;
    }

    #[On('remove-img')]
    public function removePoster()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
            if ($this->wichImage === 'logo_cms') {
                $this->logo_cms = '';
            } elseif ($this->wichImage === 'logo') {
                $this->logo = '';
            } else {
                $this->favicon = '';
            }
        } else {
            LivewireAlert::title('Booking Gagal')
                ->text('Anda tidak memiliki izin untuk menghapus gambar ini.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        return view('livewire.settings.basic');
    }
}
