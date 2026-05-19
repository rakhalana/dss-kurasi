<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrasi untuk membuat tabel sesi perhitungan bobot AHP
return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel sesi penilaian AHP
        Schema::create('ahp_sesi', function (Blueprint $table) {
            $table->increments('id_ahp_sesi');
            $table->string('nama_sesi', 100);
            $table->date('tanggal_sesi');
            $table->decimal('lambda_max', 10, 4)->nullable(); // Nilai eigen terbesar (Lambda Max)
            $table->decimal('ci', 10, 4)->nullable(); // Consistency Index (CI)
            $table->decimal('cr', 10, 4)->nullable(); // Consistency Ratio (CR), harus <= 0.1 agar konsisten
            $table->boolean('status_aktif')->default(false); // Sesi pembobotan AHP yang aktif/berlaku saat ini
            $table->unsignedBigInteger('dibuat_oleh'); // Administrator pembuat sesi
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index('dibuat_oleh', 'idx_ahp_sesi_dibuat_oleh');

            // Pengaturan kunci asing untuk relasi pengguna pembuat sesi
            $table->foreign('dibuat_oleh', 'fk_ahp_sesi_users')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Menghapus tabel ahp_sesi jika migrasi dibatalkan
        Schema::dropIfExists('ahp_sesi');
    }
};
