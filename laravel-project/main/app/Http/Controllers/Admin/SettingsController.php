<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\ImageUploader;
use App\Support\SiteData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const TEXT = [
        'phone' => 60, 'whatsapp' => 60, 'email' => 150, 'address' => 400,
        'hours_weekday_label' => 60, 'hours_weekday' => 60, 'hours_sunday_label' => 60, 'hours_sunday' => 60,
        'meta_title' => 200, 'meta_description' => 400, 'meta_keywords' => 300,
        'google_map_query' => 200, 'google_map_label' => 120, 'google_analytics_id' => 30, 'google_site_verification' => 100,
    ];

    private const LINKS = ['facebook', 'instagram', 'x', 'linkedin', 'youtube'];

    public function edit(): View
    {
        return view('admin.settings', ['s' => Setting::pluck('value', 'key')->all()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'logo' => ImageUploader::rules(false),
            'favicon' => ImageUploader::rules(false),
            'email' => ['nullable', 'email', 'max:150'],
            // Google Analytics / Ads measurement ID, e.g. G-ABC123XYZ9. Strict pattern: it is printed inside a script.
            'google_analytics_id' => ['nullable', 'regex:~^(G|GT|AW|UA)-[A-Z0-9-]{4,20}$~i', 'max:30'],
            // Search Console token from the meta tag, e.g. 4kF9...; letters, numbers, dash, underscore.
            'google_site_verification' => ['nullable', 'regex:~^[A-Za-z0-9_-]{20,100}$~'],
        ];
        foreach (self::TEXT as $key => $max) {
            $rules[$key] = $rules[$key] ?? ['nullable', 'string', 'max:'.$max];
        }
        foreach (self::LINKS as $key) {
            $rules[$key] = ['nullable', 'url:http,https', 'max:300'];
        }
        $data = $request->validate($rules);

        foreach (array_merge(array_keys(self::TEXT), self::LINKS) as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $data[$key] ?? '']);
        }
        foreach (['logo', 'favicon'] as $field) {
            if ($request->hasFile($field)) {
                $old = Setting::where('key', $field)->value('value');
                Setting::updateOrCreate(['key' => $field], ['value' => ImageUploader::store($request->file($field), $field)]);
                ImageUploader::delete($old);
            }
        }
        SiteData::flush();

        return back()->with('status', 'Company information saved.');
    }
}
