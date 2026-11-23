<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('email', 150)->unique();
            $table->text('pin'); // encrypted 4-digit PIN, one per user, never changes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_users');
    }
};
