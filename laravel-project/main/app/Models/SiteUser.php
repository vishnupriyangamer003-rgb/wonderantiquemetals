<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A website visitor with one fixed 4-digit PIN (stored encrypted). */
class SiteUser extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'pin'];

    protected $hidden = ['pin'];

    protected $casts = [
        'pin' => 'encrypted',
    ];
}
