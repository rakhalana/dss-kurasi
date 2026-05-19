<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel transaksi penilaian kurasi produk
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel penyimpanan nilai kriteria produk alternatif yang diinput kurator
        Schema::create('penilaian_kurasi', function (Blueprint $table) {
            $table->increments('id_penilaian');
            $table->unsignedInteger('id_periode_alternatif'); // Relasi ke tabel jembatan periode-alternatif
            $table->unsignedInteger('id_kriteria'); // Kriteria yang dinilai
            $table->unsignedTinyInteger('nilai_input'); // Nilai skala (1 sampai 5) hasil penilaian kurator
            $table->unsignedBigInteger('dinilai_oleh'); // Pengguna sistem (kurator) yang melakukan penilaian
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['id_periode_alternatif', 'id_kriteria'], 'uk_penilaian_kurasi');

            // Pengaturan kunci asing untuk integritas data transaksional
            $table->foreign('id_periode_alternatif', 'fk_penilaian_kurasi_periode_alternatif')
                ->references('id_periode_alternatif')->on('periode_alternatif')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_kriteria', 'fk_penilaian_kurasi_kriteria')
                ->references('id_kriteria')->on('kriteria')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('dinilai_oleh', 'fk_penilaian_kurasi_users')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Menghapus tabel penilaian_kurasi jika migrasi dibatalkan
        Schema::dropIfExists('penilaian_kurasi');
    }
};
