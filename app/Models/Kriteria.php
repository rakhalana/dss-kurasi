<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi kriteria penilaian dalam penentuan produk terbaik
class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    
    // Pencatatan waktu dikelola langsung secara otomatis oleh database
    public $timestamps = false;

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'aspek',
        'deskripsi_kriteria',
        'target_nilai',
        'urutan_tampil'
    ];

    // Relasi satu-ke-banyak ke tabel opsi skala penilaian kriteria
    public function scales()
    {
        return $this->hasMany(KriteriaSkala::class, 'id_kriteria', 'id_kriteria');
    }
}
