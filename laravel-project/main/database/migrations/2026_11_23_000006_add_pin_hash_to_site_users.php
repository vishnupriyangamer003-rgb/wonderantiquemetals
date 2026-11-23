<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_users', function (Blueprint $table) {
            // Keyed hash of the PIN: lets us find a user by PIN and keeps every PIN unique.
            $table->string('pin_hash', 64)->nullable()->unique()->after('pin');
        });

        // Existing users keep working: hash their current PIN. If two users share a PIN
        // (possible under the old per-email scheme) the later one gets a fresh unused PIN.
        $used = [];
        foreach (DB::table('site_users')->orderBy('id')->get() as $row) {
            $pin = Crypt::decryptString($row->pin);
            $hash = hash_hmac('sha256', $pin, config('app.key'));

            if (isset($used[$hash])) {
                do {
                    $pin = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                    $hash = hash_hmac('sha256', $pin, config('app.key'));
                } while (isset($used[$hash]));

                DB::table('site_users')->where('id', $row->id)->update(['pin' => Crypt::encryptString($pin)]);
            }

            $used[$hash] = true;
            DB::table('site_users')->where('id', $row->id)->update(['pin_hash' => $hash]);
        }
    }

    public function down(): void
    {
        Schema::table('site_users', function (Blueprint $table) {
            $table->dropColumn('pin_hash');
        });
    }
};
