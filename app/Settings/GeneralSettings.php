<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    public ?string $site_name;
    public ?string $description;
    public ?string $logo_cms;
    public ?string $logo;
    public ?string $favicon;
    public ?string $about_us;
    // Tagline
    public ?string $tagline;
    public ?string $how_to_rent;
    public ?string $terms_conditions;
    public ?string $privacy_policy;
    // Social Media Links
    public ?string $youtube;
    public ?string $tiktok;
    public ?string $instagram;
    public ?string $facebook;
    public ?string $twitter;
    public ?string $whatsapp;
    public ?string $telegram;
    
    public string $primary_color;

    public static function group(): string
    {
        return 'general';
    }
}
