<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One row per successful OTP sign-in to the public site. */
class UserLogin extends Model
{
    protected $fillable = ['username', 'phone', 'email', 'login_at'];

    protected $casts = [
        'login_at' => 'datetime',
    ];
}
