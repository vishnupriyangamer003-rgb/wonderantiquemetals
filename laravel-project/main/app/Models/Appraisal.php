<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    protected $fillable = ['slug', 'nav_label', 'meta_title', 'meta_description', 'eyebrow', 'heading', 'heading_em', 'lead', 'sections', 'button_label', 'sort_order', 'active'];

    public function getUrlAttribute(): string
    {
        return $this->slug === 'appraisals' ? route('appraisals.index') : route('appraisals.show', $this->slug);
    }

    protected function casts(): array
    {
        return ['sections' => 'array', 'active' => 'boolean'];
    }
}
