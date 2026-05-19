<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi nilai matriks perbandingan berpasangan kriteria dalam metode AHP
class AhpPerbandingan extends Model
{
    protected $table = 'ahp_perbandingan';
    protected $primaryKey = 'id_ahp_perbandingan';
    public $timestamps = false;

    protected $fillable = [
        'id_ahp_sesi',
        'kriteria_1_id',
        'kriteria_2_id',
        'nilai_perbandingan'
    ];

    // Relasi balik ke model sesi penilaian AHP induk
    public function sesi()
    {
        return $this->belongsTo(AhpSesi::class, 'id_ahp_sesi', 'id_ahp_sesi');
    }

    // Relasi ke kriteria pertama yang dibandingkan
    public function kriteria1()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_1_id', 'id_kriteria');
    }

    // Relasi ke kriteria kedua yang dibandingkan
    public function kriteria2()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_2_id', 'id_kriteria');
    }
}
