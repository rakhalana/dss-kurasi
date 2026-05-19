<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi sesi penilaian pembobotan kriteria menggunakan metode AHP
class AhpSesi extends Model
{
    protected $table = 'ahp_sesi';
    protected $primaryKey = 'id_ahp_sesi';

    protected $fillable = [
        'nama_sesi',
        'tanggal_sesi',
        'lambda_max',
        'ci',
        'cr',
        'status_aktif',
        'dibuat_oleh'
    ];

    // Relasi balik ke pengguna pembuat sesi penilaian AHP
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'id');
    }

    // Relasi satu-ke-banyak ke data nilai matriks perbandingan berpasangan AHP
    public function perbandingan()
    {
        return $this->hasMany(AhpPerbandingan::class, 'id_ahp_sesi', 'id_ahp_sesi');
    }

    // Relasi satu-ke-banyak ke data bobot akhir prioritas kriteria AHP
    public function bobot()
    {
        return $this->hasMany(AhpBobot::class, 'id_ahp_sesi', 'id_ahp_sesi');
    }
}
