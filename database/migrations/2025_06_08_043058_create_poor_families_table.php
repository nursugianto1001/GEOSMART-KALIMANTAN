<?php
// database/migrations/2024_01_01_000007_create_poor_families_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poor_families', function (Blueprint $table) {
            $table->id();
            
            // 1. Data Identitas Keluarga
            $table->string('nama_kepala_keluarga');
            $table->string('nik', 16)->nullable();
            $table->integer('jumlah_anggota_keluarga');
            $table->enum('jenis_kelamin_kk', ['L', 'P']);
            $table->enum('status_keluarga', ['tetap', 'pendatang', 'korban_bencana', 'lainnya']);
            
            // 2. Lokasi & Alamat
            $table->foreignId('neighborhood_id')->constrained()->onDelete('cascade');
            $table->text('alamat_lengkap');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('tipe_tempat_tinggal', ['rumah_pribadi', 'sewa', 'menumpang']);
            
            // 3. Kondisi Ekonomi
            $table->enum('sumber_penghasilan', ['bertani', 'buruh', 'dagang', 'tidak_ada', 'lainnya']);
            $table->decimal('penghasilan_bulanan', 12, 2)->nullable();
            $table->enum('status_kepemilikan', ['milik_sendiri', 'sewa', 'tidak_punya']);
            $table->json('aset_utama')->nullable();
            
            // 4. Kondisi Tempat Tinggal
            $table->enum('jenis_bangunan', ['permanen', 'semi_permanen', 'tidak_layak']);
            $table->integer('luas_rumah')->nullable();
            $table->enum('lantai_rumah', ['tanah', 'semen', 'keramik']);
            $table->enum('dinding_rumah', ['kayu', 'tembok', 'anyaman_bambu', 'seng']);
            $table->enum('atap_rumah', ['genteng', 'seng', 'rumbia', 'plastik']);
            $table->enum('sumber_air', ['sumur', 'pdam', 'sungai']);
            $table->enum('sumber_listrik', ['pln', 'genset', 'tidak_ada']);
            
            // 5. Akses Layanan Dasar
            $table->enum('akses_sekolah', ['kurang_1km', '1_3km', 'lebih_3km']);
            $table->enum('akses_kesehatan', ['puskesmas', 'rs', 'tidak_ada']);
            $table->enum('akses_jalan', ['bisa_motor_mobil', 'tidak_bisa']);
            
            // 6. Kondisi Sosial & Kesehatan
            $table->boolean('anak_tidak_sekolah')->default(false);
            $table->boolean('ada_difabel_lansia')->default(false);
            $table->boolean('ada_sakit_menahun')->default(false);
            $table->json('bantuan_pemerintah')->nullable();
            
            // 7. Dokumentasi
            $table->string('foto_depan_rumah')->nullable();
            $table->string('foto_dalam_rumah')->nullable();
            $table->text('catatan_tambahan')->nullable();
            
            // Metadata
            $table->foreignId('surveyor_id')->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['draft', 'submitted', 'verified', 'rejected'])->default('draft');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            
            $table->index(['latitude', 'longitude']);
            $table->index('status_verifikasi');
            $table->index('surveyor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poor_families');
    }
};
