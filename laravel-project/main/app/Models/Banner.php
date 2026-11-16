<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['eyebrow', 'title', 'text', 'button_label', 'button_url', 'image', 'alt', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}
