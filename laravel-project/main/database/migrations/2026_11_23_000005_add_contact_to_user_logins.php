<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('username');
            $table->string('email', 150)->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email']);
        });
    }
};
