<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel penyimpanan cache aplikasi dan penguncian cache (cache lock)
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel penyimpanan data cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        // Membuat tabel penguncian cache untuk mencegah race condition
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });
    }

    public function down(): void
    {
        // Menghapus tabel cache jika migrasi dibatalkan
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
