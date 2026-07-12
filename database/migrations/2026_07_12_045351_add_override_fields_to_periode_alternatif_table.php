<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('periode_alternatif', function (Blueprint $table) {
            $table->string('status_override')->nullable()->after('catatan_kurator');
            $table->text('komentar_override')->nullable()->after('status_override');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periode_alternatif', function (Blueprint $table) {
            $table->dropColumn(['status_override', 'komentar_override']);
        });
    }
};
