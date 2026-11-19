<?php

namespace App\Providers;

use App\Support\SiteData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Shared, cached site content for the public layout and pages (flushed on every admin save).
        View::composer(['layout', 'pages.*', 'service-detail', 'errors.404'], function ($view) {
            $view->with([
                'site' => SiteData::settings(),
                'siteServices' => SiteData::services(),
                'siteAppraisals' => SiteData::appraisals(),
                'siteBanners' => SiteData::banners(),
                'siteTeam' => SiteData::team(),
            ]);
        });
    }
}
