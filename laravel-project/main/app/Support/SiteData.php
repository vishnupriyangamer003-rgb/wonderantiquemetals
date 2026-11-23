<?php

namespace App\Support;

use App\Models\Appraisal;
use App\Models\Banner;
use App\Models\FeeItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Cached read access to the editable site content. Every admin save calls
 * flush(), so public pages stay fast and still show changes immediately.
 */
class SiteData
{
    private const KEYS = ['site.settings', 'site.banners', 'site.services', 'site.appraisals', 'site.team', 'site.fees'];

    public static function settings(): array
    {
        return Cache::rememberForever('site.settings', fn () => Setting::pluck('value', 'key')->all());
    }

    public static function setting(string $key, ?string $default = null): ?string
    {
        $value = self::settings()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    public static function banners(): Collection
    {
        return Cache::rememberForever('site.banners', fn () => Banner::where('active', true)->orderBy('sort_order')->orderBy('id')->get());
    }

    public static function services(): Collection
    {
        return Cache::rememberForever('site.services', fn () => Service::where('active', true)->orderBy('sort_order')->orderBy('id')->get());
    }

    public static function appraisals(): Collection
    {
        return Cache::rememberForever('site.appraisals', fn () => Appraisal::where('active', true)->orderBy('sort_order')->orderBy('id')->get());
    }

    public static function feeItems(): Collection
    {
        return Cache::rememberForever('site.fees', fn () => FeeItem::where('active', true)->orderBy('sort_order')->orderBy('id')->get());
    }

    public static function team(): Collection
    {
        return Cache::rememberForever('site.team', fn () => TeamMember::where('active', true)->orderBy('sort_order')->orderBy('id')->get());
    }

    public static function flush(): void
    {
        foreach (self::KEYS as $key) {
            Cache::forget($key);
        }
    }
}
