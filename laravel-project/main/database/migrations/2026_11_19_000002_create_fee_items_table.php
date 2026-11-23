<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_items', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('qty', 20)->default('1');
            $table->string('amount', 40);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Move the previously hard-coded fee table and notes into the database (existing installs only).
        $defaults = require database_path('seeders/data/fees.php');
        $now = now();
        DB::table('fee_items')->insert(array_map(
            fn ($r) => $r + ['active' => true, 'created_at' => $now, 'updated_at' => $now],
            $defaults['items']
        ));

        $fees = DB::table('appraisals')->where('slug', 'fees')->first();
        if ($fees && in_array($fees->sections, [null, '', '[]'], true)) {
            DB::table('appraisals')->where('id', $fees->id)->update(['sections' => json_encode($defaults['sections']), 'updated_at' => $now]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_items');
    }
};
