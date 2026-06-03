<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi data produk alternatif (UMKM) yang dikurasi
class Alternatif extends Model
{
    protected $table = 'alternatif';
    protected $primaryKey = 'id_alternatif';
    
    // Sinkronisasi timestamps default Laravel dengan database
    public $timestamps = true;

    protected $fillable = [
        'nama_produk',
        'nama_brand_umkm',
        'deskripsi_produk',
        'is_aktif',
        'created_at',
        'updated_at'
    ];

    // Relasi satu-ke-satu ke dokumen data legalitas produk
    public function legalitas()
    {
        return $this->hasOne(AlternatifLegalitas::class, 'id_alternatif', 'id_alternatif');
    }
}
