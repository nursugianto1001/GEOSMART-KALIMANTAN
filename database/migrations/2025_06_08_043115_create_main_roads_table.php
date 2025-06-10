<?php
// database/migrations/2024_01_01_000008_create_main_roads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_roads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('village_id')->constrained()->onDelete('cascade');
            $table->enum('kondisi_jalan', ['baik', 'sedang', 'rusak']);
            $table->enum('jenis_jalan', ['aspal', 'beton', 'tanah', 'kerikil']);
            $table->decimal('lebar_jalan', 5, 2)->nullable();
            $table->json('coordinates')->nullable(); // Array of lat,lng points
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_roads');
    }
};
