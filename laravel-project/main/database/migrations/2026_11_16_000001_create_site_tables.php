<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password'); // plain text by the owner's explicit choice
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('number', 8)->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('summary');
            $table->json('details')->nullable();
            $table->string('image')->nullable();
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nav_label');
            $table->string('meta_title');
            $table->text('meta_description')->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('heading');
            $table->string('heading_em')->nullable();
            $table->text('lead')->nullable();
            $table->json('sections')->nullable(); // [{heading, text}]
            $table->string('button_label')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('quote');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['testimonials', 'appraisals', 'services', 'banners', 'settings', 'admins'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
