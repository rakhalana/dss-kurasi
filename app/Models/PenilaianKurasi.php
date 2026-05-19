<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Model representasi nilai aspek/kriteria dari produk alternatif yang diisi oleh Kurator
class PenilaianKurasi extends Model
{
    protected $table = 'penilaian_kurasi';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_periode_alternatif',
        'id_kriteria',
        'nilai_input',
        'dinilai_oleh',
    ];

    // Relasi balik ke jembatan periode alternatif terkait
    public function periodeAlternatif(): BelongsTo
    {
        return $this->belongsTo(PeriodeAlternatif::class, 'id_periode_alternatif', 'id_periode_alternatif');
    }

    // Relasi ke kriteria penilaian yang bersangkutan
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }

    // Relasi ke pengguna sistem yang bertindak sebagai kurator penilai
    public function kurator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dinilai_oleh', 'id');
    }
}
