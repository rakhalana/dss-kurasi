<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel bobot prioritas kriteria AHP
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel penyimpanan hasil bobot akhir kriteria
        Schema::create('ahp_bobot', function (Blueprint $table) {
            $table->increments('id_ahp_bobot');
            $table->unsignedInteger('id_ahp_sesi'); // Sesi AHP terkait
            $table->unsignedInteger('id_kriteria'); // Kriteria terkait
            $table->decimal('bobot_prioritas', 12, 6); // Nilai bobot prioritas akhir (angka pecahan desimal)

            $table->unique(['id_ahp_sesi', 'id_kriteria'], 'uk_ahp_bobot');

            // Pengaturan kunci asing untuk relasi integritas database
            $table->foreign('id_ahp_sesi', 'fk_ahp_bobot_sesi')
                ->references('id_ahp_sesi')->on('ahp_sesi')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_kriteria', 'fk_ahp_bobot_kriteria')
                ->references('id_kriteria')->on('kriteria')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Menghapus tabel ahp_bobot jika migrasi dibatalkan
        Schema::dropIfExists('ahp_bobot');
    }
};
