<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Support\ImageUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends ResourceController
{
    protected function model(): string
    {
        return Service::class;
    }

    protected function key(): string
    {
        return 'services';
    }

    protected function label(): string
    {
        return 'Service';
    }

    protected function imageField(): ?string
    {
        return 'image';
    }

    protected function rules(?Model $item): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'regex:~^[a-z0-9]+(?:-[a-z0-9]+)*$~', Rule::unique('services', 'slug')->ignore($item?->id)],
            'number' => ['nullable', 'string', 'max:8'],
            'eyebrow' => ['nullable', 'string', 'max:60'],
            'title' => ['required', 'string', 'max:150'],
            'summary' => ['required', 'string', 'max:600'],
            'details' => ['nullable', 'string', 'max:6000'],
            'image' => ImageUploader::rules(false),
            'alt' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    /** Paragraphs are separated by a blank line in the form. */
    protected function transform(array $data, Request $request, ?Model $item): array
    {
        $text = str_replace("\r\n", "\n", (string) ($data['details'] ?? ''));
        $data['details'] = array_values(array_filter(array_map('trim', preg_split("~\n{2,}~", $text))));

        return $data;
    }
}
