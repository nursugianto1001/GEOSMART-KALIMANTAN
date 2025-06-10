<?php
// database/migrations/2024_01_01_000009_create_public_facilities_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['sekolah', 'puskesmas', 'rumah_sakit', 'kantor_desa', 'pasar', 'masjid', 'gereja', 'lainnya']);
            $table->foreignId('village_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('alamat')->nullable();
            $table->enum('kondisi', ['baik', 'sedang', 'rusak']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_facilities');
    }
};
