<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Support\ImageUploader;
use Illuminate\Database\Eloquent\Model;

class BannerController extends ResourceController
{
    protected function model(): string
    {
        return Banner::class;
    }

    protected function key(): string
    {
        return 'banners';
    }

    protected function label(): string
    {
        return 'Banner';
    }

    protected function imageField(): ?string
    {
        return 'image';
    }

    protected function rules(?Model $item): array
    {
        return [
            'eyebrow' => ['nullable', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:200'],
            'text' => ['nullable', 'string', 'max:500'],
            'button_label' => ['nullable', 'string', 'max:60'],
            // Relative path or http(s) only: blocks javascript: and data: links.
            'button_url' => ['nullable', 'string', 'max:300', 'regex:~^(/|https?://)~i'],
            'image' => ImageUploader::rules($item === null || ! $item->exists),
            'alt' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
