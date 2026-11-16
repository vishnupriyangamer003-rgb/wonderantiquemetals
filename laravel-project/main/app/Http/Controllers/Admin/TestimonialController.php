<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

class TestimonialController extends ResourceController
{
    protected function model(): string
    {
        return Testimonial::class;
    }

    protected function key(): string
    {
        return 'testimonials';
    }

    protected function label(): string
    {
        return 'Testimonial';
    }

    protected function rules(?Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'quote' => ['required', 'string', 'max:800'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
