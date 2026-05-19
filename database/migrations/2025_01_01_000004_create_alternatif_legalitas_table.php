<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel dokumen legalitas alternatif produk
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel status kelayakan dokumen hukum (NIB, BPOM, PIRT, Halal)
        Schema::create('alternatif_legalitas', function (Blueprint $table) {
            $table->increments('id_legalitas');
            $table->unsignedInteger('id_alternatif')->unique('uk_alternatif_legalitas_id_alternatif'); // Menghubungkan satu legalitas per alternatif
            $table->boolean('is_nib')->default(false);
            $table->string('no_nib', 100)->nullable();
            $table->boolean('is_bpom')->default(false);
            $table->string('no_bpom', 100)->nullable();
            $table->boolean('is_sp_pirt')->default(false);
            $table->string('no_sp_pirt', 100)->nullable();
            $table->boolean('is_sertifikat_halal')->default(false);
            $table->string('no_sertifikat_halal', 100)->nullable();
            $table->boolean('lolos_filter')->default(false); // Penentu kelayakan legalitas (syarat mutlak kelolosan)
            $table->text('keterangan')->nullable(); // Rekomendasi/catatan perbaikan dokumen legalitas
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Aturan integritas kunci asing ke tabel alternatif produk
            $table->foreign('id_alternatif', 'fk_alternatif_legalitas_alternatif')
                ->references('id_alternatif')->on('alternatif')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Menghapus tabel alternatif_legalitas jika migrasi dibatalkan
        Schema::dropIfExists('alternatif_legalitas');
    }
};
