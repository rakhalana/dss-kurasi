<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel kriteria penilaian produk
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel master kriteria penilaian
        Schema::create('kriteria', function (Blueprint $table) {
            $table->increments('id_kriteria');
            $table->string('kode_kriteria', 20)->unique('uk_kriteria_kode'); // Kode unik kriteria (contoh: K01)
            $table->string('nama_kriteria', 100);
            $table->enum('aspek', ['kualitas_produk', 'kemasan']); // Pengelompokan aspek kriteria
            $table->text('deskripsi_kriteria')->nullable();
            $table->unsignedTinyInteger('target_nilai'); // Target nilai acuan Profile Matching
            $table->unsignedInteger('urutan_tampil')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Diperbarui otomatis oleh database
        });
    }

    public function down(): void
    {
        // Menghapus tabel kriteria jika migrasi dibatalkan
        Schema::dropIfExists('kriteria');
    }
};
