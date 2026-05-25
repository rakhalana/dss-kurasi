<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Migrasi untuk menyisipkan data default awal (seeding) sub-kriteria/skala kriteria
return new class extends Migration {
    public function up(): void
    {
        // Menyusun daftar opsi skala nilai default (skala 1 sampai 5) untuk C1 sampai C9
        $skala = [
            // Kriteria 1: Rasa
            ['id_kriteria' => 1, 'nilai_skala' => 1, 'deskripsi_skala' => 'Sangat tidak layak; rasa/aroma menyimpang seperti tengik, asam tidak wajar, pahit, atau tidak sesuai karakter produk.', 'is_aktif' => true],
            ['id_kriteria' => 1, 'nilai_skala' => 2, 'deskripsi_skala' => 'Kurang layak; karakter rasa belum jelas, terdapat aftertaste/aroma mengganggu, atau tekstur kurang sesuai.', 'is_aktif' => true],
            ['id_kriteria' => 1, 'nilai_skala' => 3, 'deskripsi_skala' => 'Cukup layak; rasa utama sesuai jenis produk, namun kurang seimbang, kurang konsisten, atau daya tarik masih lemah.', 'is_aktif' => true],
            ['id_kriteria' => 1, 'nilai_skala' => 4, 'deskripsi_skala' => 'Layak; rasa sesuai karakter produk, seimbang, aroma/tekstur mendukung, dan diterima target konsumen.', 'is_aktif' => true],
            ['id_kriteria' => 1, 'nilai_skala' => 5, 'deskripsi_skala' => 'Sangat layak; rasa enak, khas, seimbang, konsisten antar sampel, dan berdaya saing di pasar modern.', 'is_aktif' => true],

            // Kriteria 2: Harga
            ['id_kriteria' => 2, 'nilai_skala' => 1, 'deskripsi_skala' => 'Sangat tidak sesuai dengan permintaan retail tujuan; struktur harga sulit diterima pasar modern.', 'is_aktif' => true],
            ['id_kriteria' => 2, 'nilai_skala' => 2, 'deskripsi_skala' => 'Kurang sesuai dengan permintaan retail tujuan dan masih perlu penyesuaian harga signifikan.', 'is_aktif' => true],
            ['id_kriteria' => 2, 'nilai_skala' => 3, 'deskripsi_skala' => 'Cukup sesuai; harga mendekati kisaran retail tujuan, tetapi masih perlu disesuaikan agar kompetitif.', 'is_aktif' => true],
            ['id_kriteria' => 2, 'nilai_skala' => 4, 'deskripsi_skala' => 'Sesuai; harga mengikuti kisaran permintaan retail tujuan dan cukup layak untuk pasar modern.', 'is_aktif' => true],
            ['id_kriteria' => 2, 'nilai_skala' => 5, 'deskripsi_skala' => 'Sangat sesuai; harga memenuhi permintaan retail tujuan, kompetitif, dan siap diterapkan.', 'is_aktif' => true],

            // Kriteria 3: Kapasitas produksi
            ['id_kriteria' => 3, 'nilai_skala' => 1, 'deskripsi_skala' => 'Kurang dari 40 unit per bulan.', 'is_aktif' => true],
            ['id_kriteria' => 3, 'nilai_skala' => 2, 'deskripsi_skala' => '41-100 unit per bulan.', 'is_aktif' => true],
            ['id_kriteria' => 3, 'nilai_skala' => 3, 'deskripsi_skala' => '101-240 unit per bulan.', 'is_aktif' => true],
            ['id_kriteria' => 3, 'nilai_skala' => 4, 'deskripsi_skala' => '241-500 unit per bulan.', 'is_aktif' => true],
            ['id_kriteria' => 3, 'nilai_skala' => 5, 'deskripsi_skala' => 'Lebih dari 500 unit per bulan.', 'is_aktif' => true],

            // Kriteria 4: Masa kadaluwarsa
            ['id_kriteria' => 4, 'nilai_skala' => 1, 'deskripsi_skala' => 'Masa kadaluwarsa kurang dari 1 bulan.', 'is_aktif' => true],
            ['id_kriteria' => 4, 'nilai_skala' => 2, 'deskripsi_skala' => 'Masa kadaluwarsa 1-3 bulan.', 'is_aktif' => true],
            ['id_kriteria' => 4, 'nilai_skala' => 3, 'deskripsi_skala' => 'Masa kadaluwarsa 3-6 bulan.', 'is_aktif' => true],
            ['id_kriteria' => 4, 'nilai_skala' => 4, 'deskripsi_skala' => 'Masa kadaluwarsa 6-12 bulan.', 'is_aktif' => true],
            ['id_kriteria' => 4, 'nilai_skala' => 5, 'deskripsi_skala' => 'Masa kadaluwarsa lebih dari 12 bulan.', 'is_aktif' => true],

            // Kriteria 5: Kode produksi
            ['id_kriteria' => 5, 'nilai_skala' => 1, 'deskripsi_skala' => 'Tidak mencantumkan kode produksi sama sekali.', 'is_aktif' => true],
            ['id_kriteria' => 5, 'nilai_skala' => 2, 'deskripsi_skala' => 'Kode produksi ada, tetapi tidak jelas, sulit terbaca, atau tidak permanen pada kemasan.', 'is_aktif' => true],
            ['id_kriteria' => 5, 'nilai_skala' => 3, 'deskripsi_skala' => 'Kode produksi tercantum, namun penempatan, format, atau konsistensinya masih perlu diperbaiki.', 'is_aktif' => true],
            ['id_kriteria' => 5, 'nilai_skala' => 4, 'deskripsi_skala' => 'Kode produksi jelas, terbaca, dan dapat digunakan untuk identifikasi batch produksi.', 'is_aktif' => true],
            ['id_kriteria' => 5, 'nilai_skala' => 5, 'deskripsi_skala' => 'Kode produksi jelas, mudah dilihat, konsisten, dan sesuai ketentuan label pangan olahan.', 'is_aktif' => true],

            // Kriteria 6: Uji nutrisi
            ['id_kriteria' => 6, 'nilai_skala' => 1, 'deskripsi_skala' => 'Tidak ada tabel Informasi Nilai Gizi (ING) sama sekali.', 'is_aktif' => true],
            ['id_kriteria' => 6, 'nilai_skala' => 2, 'deskripsi_skala' => 'ING sangat terbatas dan/atau format tabel belum sesuai ketentuan PerBPOM 26/2021.', 'is_aktif' => true],
            ['id_kriteria' => 6, 'nilai_skala' => 3, 'deskripsi_skala' => 'ING tersedia tetapi masih ada 1-2 kekeliruan, seperti AKG, catatan kaki, atau satuan tidak konsisten.', 'is_aktif' => true],
            ['id_kriteria' => 6, 'nilai_skala' => 4, 'deskripsi_skala' => 'ING lengkap dan benar, mencakup takaran saji, zat gizi wajib, AKG, catatan kaki, dan format tabel sesuai.', 'is_aktif' => true],
            ['id_kriteria' => 6, 'nilai_skala' => 5, 'deskripsi_skala' => 'Memenuhi skala 4 serta didukung hasil uji laboratorium terakreditasi dengan dokumen tersedia.', 'is_aktif' => true],

            // Kriteria 7: Material
            ['id_kriteria' => 7, 'nilai_skala' => 1, 'deskripsi_skala' => 'Tidak ada tanda food grade/tara pangan dan memakai kemasan tidak layak untuk kontak langsung pangan.', 'is_aktif' => true],
            ['id_kriteria' => 7, 'nilai_skala' => 2, 'deskripsi_skala' => 'Tidak ada tanda food grade; kemasan umum terlihat bersih tetapi peruntukan pangan dan materialnya tidak jelas.', 'is_aktif' => true],
            ['id_kriteria' => 7, 'nilai_skala' => 3, 'deskripsi_skala' => 'Tidak ada tanda food grade, namun jenis kemasan sudah cukup sesuai dengan karakter produk.', 'is_aktif' => true],
            ['id_kriteria' => 7, 'nilai_skala' => 4, 'deskripsi_skala' => 'Kemasan berlabel food grade/tara pangan, memiliki kode material, dan jenisnya sesuai karakter produk.', 'is_aktif' => true],
            ['id_kriteria' => 7, 'nilai_skala' => 5, 'deskripsi_skala' => 'Memenuhi skala 4 serta memiliki dokumen pemasok/spesifikasi yang menyatakan kemasan aman untuk pangan.', 'is_aktif' => true],

            // Kriteria 8: Desain
            ['id_kriteria' => 8, 'nilai_skala' => 1, 'deskripsi_skala' => 'Sangat tidak layak; tampilan tidak rapi, identitas produk tidak jelas, atau visual mengganggu keterbacaan.', 'is_aktif' => true],
            ['id_kriteria' => 8, 'nilai_skala' => 2, 'deskripsi_skala' => 'Kurang layak; layout, warna/font, identitas merek, dan daya jual retail masih lemah.', 'is_aktif' => true],
            ['id_kriteria' => 8, 'nilai_skala' => 3, 'deskripsi_skala' => 'Cukup layak; identitas terlihat, namun komposisi visual, tipografi, warna, atau daya tarik rak perlu diperbaiki.', 'is_aktif' => true],
            ['id_kriteria' => 8, 'nilai_skala' => 4, 'deskripsi_skala' => 'Layak; rapi, menarik, sesuai karakter produk/target pasar, dan informasi utama mudah dikenali.', 'is_aktif' => true],
            ['id_kriteria' => 8, 'nilai_skala' => 5, 'deskripsi_skala' => 'Sangat layak; profesional, identitas merek kuat, visual bersih, hierarki informasi baik, dan siap bersaing di pasar modern.', 'is_aktif' => true],

            // Kriteria 9: Informasi label
            ['id_kriteria' => 9, 'nilai_skala' => 1, 'deskripsi_skala' => 'Hanya mencantumkan nama produk saja atau nama produk dan berat bersih.', 'is_aktif' => true],
            ['id_kriteria' => 9, 'nilai_skala' => 2, 'deskripsi_skala' => 'Kurang dari 5 elemen informasi label terpenuhi dengan benar.', 'is_aktif' => true],
            ['id_kriteria' => 9, 'nilai_skala' => 3, 'deskripsi_skala' => 'Memenuhi 5-8 elemen label, atau masih ada 1-2 elemen yang tidak konsisten/lengkap.', 'is_aktif' => true],
            ['id_kriteria' => 9, 'nilai_skala' => 4, 'deskripsi_skala' => 'Memenuhi 9 elemen label wajib, termasuk nama produk, komposisi, netto, produsen, halal, kode/tanggal produksi, kadaluwarsa, izin edar, dan info bahan tertentu.', 'is_aktif' => true],
            ['id_kriteria' => 9, 'nilai_skala' => 5, 'deskripsi_skala' => 'Memenuhi skala 4 serta label fisik tidak mudah lepas/luntur/rusak dan mudah dilihat serta dibaca.', 'is_aktif' => true],
        ];

        // Menyisipkan data skala ke dalam tabel
        DB::table('kriteria_skala')->insert($skala);
    }

    public function down(): void
    {
        // Mengosongkan isi tabel kriteria_skala dengan mengabaikan foreign key constraints sementara
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('kriteria_skala')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
};
