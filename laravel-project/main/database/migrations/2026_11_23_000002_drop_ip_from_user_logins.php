<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('user_logins', 'ip')) {
            Schema::table('user_logins', function (Blueprint $table) {
                $table->dropColumn('ip');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('user_logins', 'ip')) {
            Schema::table('user_logins', function (Blueprint $table) {
                $table->string('ip', 45)->nullable()->after('login_at');
            });
        }
    }
};
