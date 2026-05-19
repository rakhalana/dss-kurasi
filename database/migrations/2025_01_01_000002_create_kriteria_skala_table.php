<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel opsi skala nilai/sub-kriteria
return new class extends Migration {
    public function up(): void
    {
        // Membuat tabel sub-kriteria beserta batas nilainya
        Schema::create('kriteria_skala', function (Blueprint $table) {
            $table->increments('id_skala');
            $table->unsignedInteger('id_kriteria'); // Relasi ke tabel kriteria
            $table->unsignedTinyInteger('nilai_skala'); // Angka bobot nilai opsi (1 sampai 5)
            $table->text('deskripsi_skala'); // Penjelasan kualitatif skala nilai
            $table->boolean('is_aktif')->default(true); 

            $table->unique(['id_kriteria', 'nilai_skala'], 'uk_kriteria_skala');

            // Pengaturan kunci asing untuk menjaga integritas data kriteria induk
            $table->foreign('id_kriteria', 'fk_kriteria_skala_kriteria')
                ->references('id_kriteria')->on('kriteria')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Menghapus tabel kriteria_skala jika migrasi dibatalkan
        Schema::dropIfExists('kriteria_skala');
    }
};
