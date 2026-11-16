<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Appraisal;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\SiteData;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = require __DIR__.'/data/site.php';

        // First admin login comes from .env (ADMIN_USERNAME / ADMIN_PASSWORD); never overwrites an existing admin.
        $user = env('ADMIN_USERNAME');
        $pass = env('ADMIN_PASSWORD');
        if ($user && $pass && ! Admin::exists()) {
            Admin::create(['username' => $user, 'password' => $pass]);
        }

        foreach ($data['settings'] as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        $routes = ['services.index' => '/services', 'about' => '/about', 'contact' => '/contact', 'home' => '/'];
        if (! Banner::exists()) {
            foreach ($data['banners'] as $b) {
                $route = $b['button_route'] ?? null;
                unset($b['button_route']);
                $b['button_url'] = $route ? ($routes[$route] ?? '/') : null;
                Banner::create($b);
            }
        }
        if (! Service::exists()) {
            foreach ($data['services'] as $s) {
                Service::create($s);
            }
        }
        if (! Appraisal::exists()) {
            foreach ($data['appraisals'] as $a) {
                Appraisal::create($a);
            }
        }
        if (! Testimonial::exists()) {
            foreach ($data['testimonials'] as $t) {
                Testimonial::create($t);
            }
        }

        SiteData::flush();
    }
}
