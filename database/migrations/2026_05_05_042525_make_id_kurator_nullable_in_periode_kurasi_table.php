<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk mengubah kolom id_kurator di tabel periode_kurasi menjadi nullable
return new class extends Migration
{
    public function up(): void
    {
        // Mengubah constraint kolom id_kurator menjadi boleh kosong (nullable) pada inisialisasi awal periode
        Schema::table('periode_kurasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kurator')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Mengembalikan kolom id_kurator menjadi wajib diisi (not null) jika migrasi dibatalkan
        Schema::table('periode_kurasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kurator')->nullable(false)->change();
        });
    }
};
