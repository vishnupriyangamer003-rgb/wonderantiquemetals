<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->timestamp('login_at');
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('login_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logins');
    }
};
