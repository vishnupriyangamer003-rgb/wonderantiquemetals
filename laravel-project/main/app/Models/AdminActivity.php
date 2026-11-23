<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One row per action an admin takes in /ktgadmin. Short text only; no field values. */
class AdminActivity extends Model
{
    public $timestamps = false;

    protected $fillable = ['admin_id', 'admin_name', 'action', 'description', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
