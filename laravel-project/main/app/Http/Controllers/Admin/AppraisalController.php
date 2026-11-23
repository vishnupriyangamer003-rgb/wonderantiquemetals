<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appraisal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppraisalController extends ResourceController
{
    protected function model(): string
    {
        return Appraisal::class;
    }

    protected function key(): string
    {
        return 'appraisals';
    }

    protected function label(): string
    {
        return 'Appraisal page';
    }

    protected function rules(?Model $item): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'regex:~^[a-z0-9]+(?:-[a-z0-9]+)*$~', Rule::unique('appraisals', 'slug')->ignore($item?->id)],
            'nav_label' => ['required', 'string', 'max:80'],
            'meta_title' => ['required', 'string', 'max:200'],
            'eyebrow' => ['nullable', 'string', 'max:150'],
            'heading' => ['required', 'string', 'max:120'],
            'heading_em' => ['nullable', 'string', 'max:120'],
            'lead' => ['nullable', 'string', 'max:600'],
            'section_heading' => ['nullable', 'array', 'max:20'],
            'section_heading.*' => ['nullable', 'string', 'max:150'],
            'section_text' => ['nullable', 'array', 'max:20'],
            'section_text.*' => ['nullable', 'string', 'max:3000'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    protected function transform(array $data, Request $request, ?Model $item): array
    {
        $sections = [];
        foreach (($data['section_heading'] ?? []) as $i => $heading) {
            $text = trim((string) ($data['section_text'][$i] ?? ''));
            if (trim((string) $heading) !== '' || $text !== '') {
                $sections[] = ['heading' => trim((string) $heading), 'text' => $text];
            }
        }
        unset($data['section_heading'], $data['section_text']);
        $data['sections'] = $sections;

        return $data;
    }
}
