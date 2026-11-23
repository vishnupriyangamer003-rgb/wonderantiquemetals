<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\ActivityLog;
use App\Support\ImageUploader;
use App\Support\SiteData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const TEXT = [
        'phone' => 60, 'whatsapp' => 60, 'email' => 300, 'address' => 400,
        'hours_weekday_label' => 60, 'hours_weekday' => 60, 'hours_sunday_label' => 60, 'hours_sunday' => 60,
        'meta_title' => 200,
        'google_map_embed' => 2000, 'google_map_label' => 120,
    ];

    /** Only Google Maps embed addresses are accepted (blocks other sites and javascript: links). */
    private const MAP_EMBED_PATTERN = '~^https://www\.google\.com/maps(/embed)?\?[^\s"\'<>]+$~';

    private const LINKS = ['facebook', 'instagram', 'x', 'linkedin', 'youtube'];

    public function edit(): View
    {
        return view('admin.settings', ['s' => Setting::pluck('value', 'key')->all()]);
    }

    public function update(Request $request): RedirectResponse
    {
        // The map field accepts the whole <iframe ...> code from Google Maps (Share > Embed a map) or just
        // the link. Only the src address is kept.
        $embed = trim((string) $request->input('google_map_embed', ''));
        if ($embed !== '' && preg_match('~<iframe[^>]*\ssrc\s*=\s*(["\'])(.*?)\1~is', $embed, $m)) {
            $request->merge(['google_map_embed' => trim(html_entity_decode($m[2]))]);
        }

        $rules = [
            'logo' => ImageUploader::rules(false),
            'favicon' => ImageUploader::rules(false),
            'email' => [
                'nullable',
                'string',
                'max:300',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $parts = array_filter(array_map('trim', preg_split('~[\r\n,]+~', (string) $value)));
                    foreach ($parts as $part) {
                        if (!filter_var($part, FILTER_VALIDATE_EMAIL)) {
                            $fail('The email address "'.$part.'" is not valid.');
                        }
                    }
                },
            ],
            'google_map_embed' => ['nullable', 'string', 'max:2000', 'regex:'.self::MAP_EMBED_PATTERN],
        ];
        foreach (self::TEXT as $key => $max) {
            $rules[$key] = $rules[$key] ?? ['nullable', 'string', 'max:'.$max];
        }
        foreach (self::LINKS as $key) {
            $rules[$key] = ['nullable', 'url:http,https', 'max:300'];
        }
        $data = $request->validate($rules, [
            'google_map_embed.regex' => 'Paste the embed code or link from Google Maps (Share, then Embed a map). It must start with https://www.google.com/maps.',
        ]);

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
        ActivityLog::record('settings', 'Updated company information');

        return back()->with('status', 'Company information saved.');
    }
}
