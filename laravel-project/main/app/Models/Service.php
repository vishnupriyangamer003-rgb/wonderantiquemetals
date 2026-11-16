<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['slug', 'number', 'eyebrow', 'title', 'summary', 'details', 'image', 'alt', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['details' => 'array', 'active' => 'boolean'];
    }
}
