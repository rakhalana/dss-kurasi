<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi opsi sub-kriteria (skala nilai) untuk setiap kriteria
class KriteriaSkala extends Model
{
    protected $table = 'kriteria_skala';
    
    // Pencatatan waktu di-handle secara otomatis oleh skema database
    public $timestamps = false;

    protected $fillable = [
        'id_kriteria',
        'nilai_skala',
        'deskripsi_skala',
        'is_aktif'
    ];

    // Relasi balik ke model data kriteria induk
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
