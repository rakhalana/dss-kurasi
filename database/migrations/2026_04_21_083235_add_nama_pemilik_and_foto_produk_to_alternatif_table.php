<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk menambahkan kolom nama pemilik dan foto produk ke tabel alternatif
return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom nama_pemilik dan foto_produk ke dalam tabel alternatif
        Schema::table('alternatif', function (Blueprint $table) {
            $table->string('nama_pemilik', 150)->nullable()->after('nama_brand_umkm');
            $table->string('foto_produk', 255)->nullable()->after('deskripsi_produk');
        });
    }

    public function down(): void
    {
        // Menghapus kembali kolom yang ditambahkan jika migrasi dibatalkan
        Schema::table('alternatif', function (Blueprint $table) {
            $table->dropColumn(['nama_pemilik', 'foto_produk']);
        });
    }
};
