<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'location', 'quote', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}
