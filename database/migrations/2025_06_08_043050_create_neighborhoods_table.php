<?php
// database/migrations/2024_01_01_000005_create_neighborhoods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->id();
            $table->string('rt', 10); // ✅ Langsung gunakan string(10) untuk fleksibilitas
            $table->string('rw', 10); // ✅ Langsung gunakan string(10) untuk fleksibilitas
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['rt', 'rw', 'village_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neighborhoods');
    }
};
