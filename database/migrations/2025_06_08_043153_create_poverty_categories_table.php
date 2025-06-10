<?php
// database/migrations/2024_01_01_000010_create_poverty_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poverty_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poor_family_id')->constrained()->onDelete('cascade');
            $table->enum('kategori', ['ekonomi', 'kesehatan', 'sanitasi', 'pendidikan', 'infrastruktur']);
            $table->integer('skor'); // 1-5 scale
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['poor_family_id', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poverty_categories');
    }
};
