<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** A website visitor with one fixed, unique 4-digit PIN (stored encrypted, looked up by keyed hash). */
class SiteUser extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'pin', 'pin_hash'];

    protected $hidden = ['pin', 'pin_hash'];

    protected $casts = [
        'pin' => 'encrypted',
    ];

    public static function hashPin(string $pin): string
    {
        return hash_hmac('sha256', $pin, (string) config('app.key'));
    }

    /** A random 4-digit PIN that no other user has. */
    public static function generatePin(): string
    {
        for ($i = 0; $i < 200; $i++) {
            $pin = Str::padLeft((string) random_int(0, 9999), 4, '0');

            if (! static::where('pin_hash', static::hashPin($pin))->exists()) {
                return $pin;
            }
        }

        // Crowded space: walk all 10,000 values once.
        foreach (range(0, 9999) as $n) {
            $pin = Str::padLeft((string) $n, 4, '0');

            if (! static::where('pin_hash', static::hashPin($pin))->exists()) {
                return $pin;
            }
        }

        throw new \RuntimeException('All 4-digit PINs are in use.');
    }

    /** Creates a user with a fresh unique PIN. */
    public static function register(string $name, string $phone, string $email): self
    {
        $pin = static::generatePin();

        return static::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'pin' => $pin,
            'pin_hash' => static::hashPin($pin),
        ]);
    }
}
