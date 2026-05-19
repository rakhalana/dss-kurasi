<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel matriks perbandingan berpasangan kriteria AHP
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel penyimpanan nilai perbandingan berpasangan
        Schema::create('ahp_perbandingan', function (Blueprint $table) {
            $table->increments('id_ahp_perbandingan');
            $table->unsignedInteger('id_ahp_sesi'); // Sesi AHP terkait
            $table->unsignedInteger('kriteria_1_id'); // Kriteria pertama yang dibandingkan
            $table->unsignedInteger('kriteria_2_id'); // Kriteria kedua yang dibandingkan
            $table->decimal('nilai_perbandingan', 10, 4); // Nilai derajat kepentingan (1 sampai 9 atau kebalikannya)
 
            $table->unique(['id_ahp_sesi', 'kriteria_1_id', 'kriteria_2_id'], 'uk_ahp_perbandingan');

            // Pengaturan kunci asing untuk menjaga integritas data relasional
            $table->foreign('id_ahp_sesi', 'fk_ahp_perbandingan_sesi')
                ->references('id_ahp_sesi')->on('ahp_sesi')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('kriteria_1_id', 'fk_ahp_perbandingan_kriteria_1')
                ->references('id_kriteria')->on('kriteria')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('kriteria_2_id', 'fk_ahp_perbandingan_kriteria_2')
                ->references('id_kriteria')->on('kriteria')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Menghapus tabel ahp_perbandingan jika migrasi dibatalkan
        Schema::dropIfExists('ahp_perbandingan');
    }
};
