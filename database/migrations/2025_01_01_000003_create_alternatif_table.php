<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel alternatif produk (UMKM)
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel produk alternatif peserta kurasi
        Schema::create('alternatif', function (Blueprint $table) {
            $table->increments('id_alternatif');
            $table->string('nama_produk', 150);
            $table->string('nama_brand_umkm', 150);
            $table->text('deskripsi_produk')->nullable();
            $table->boolean('is_aktif')->default(true); // Status keaktifan produk dalam sistem
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Sinkronisasi otomatis timestamp
            
        });
    }

    public function down(): void
    {
        // Menghapus tabel alternatif jika migrasi dibatalkan
        Schema::dropIfExists('alternatif');
    }
};
