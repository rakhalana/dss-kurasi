<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model representasi data status dokumen legalitas produk alternatif (NIB, BPOM, PIRT, Halal)
class AlternatifLegalitas extends Model
{
    protected $table = 'alternatif_legalitas';
    protected $primaryKey = 'id_legalitas';
    
    // Penanganan updated_at secara otomatis dikelola langsung oleh sistem database
    public $timestamps = false;

    protected $fillable = [
        'id_alternatif',
        'is_nib',
        'no_nib',
        'is_bpom',
        'no_bpom',
        'is_sp_pirt',
        'no_sp_pirt',
        'is_sertifikat_halal',
        'no_sertifikat_halal',
        'lolos_filter',
        'keterangan',
        'updated_at'
    ];

    // Relasi balik ke produk alternatif pemilik berkas legalitas
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'id_alternatif', 'id_alternatif');
    }
}
