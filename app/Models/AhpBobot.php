<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi data nilai bobot prioritas akhir hasil perhitungan AHP
class AhpBobot extends Model
{
    protected $table = 'ahp_bobot';
    protected $primaryKey = 'id_ahp_bobot';
    public $timestamps = false;

    protected $fillable = [
        'id_ahp_sesi',
        'id_kriteria',
        'bobot_prioritas'
    ];

    // Relasi balik ke model sesi penilaian AHP induk
    public function sesi()
    {
        return $this->belongsTo(AhpSesi::class, 'id_ahp_sesi', 'id_ahp_sesi');
    }

    // Relasi ke model data kriteria terkait
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
