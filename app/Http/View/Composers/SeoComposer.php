<?php

namespace App\Http\View\Composers;

use App\Settings\GeneralSettings;
use Illuminate\View\View;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SeoComposer
{
    /**
     * Create a new class instance.
     */
    protected $setting;

    public function __construct(GeneralSettings $generalSetting)
    {
        $this->setting = $generalSetting;
    }

    public function compose(View $view)
    {
        $view->with('seo', new SEOData(
            site_name: $this->setting->site_name,
            title: $this->setting->site_name,
            description: $this->setting->description,
            robots: 'nofollow, noindex',
        ));

        $view->with('setting', $this->setting);
    }
}
