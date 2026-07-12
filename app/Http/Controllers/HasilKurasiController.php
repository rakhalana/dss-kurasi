<?php

namespace App\Http\Controllers;

use App\Models\PeriodeKurasi;
use App\Models\Kriteria;
use App\Models\AhpBobot;
use App\Models\PeriodeAlternatif;
use App\Services\KurasiScoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HasilKurasiController
 * Menangani tampilan dan cetak hasil kurasi (leaderboard) yang sudah selesai.
 */
class HasilKurasiController extends Controller
{
    /*
     */
    protected $scoreService;

    /**
     * Constructor dengan injeksi KurasiScoreService.
     */
    public function __construct(KurasiScoreService $scoreService)
    {
        $this->scoreService = $scoreService;
    }

    /**
     * Menampilkan daftar periode kurasi yang sudah selesai.
     */
    public function index()
    {
        $user = Auth::user();

        $query = PeriodeKurasi::withCount('periodeAlternatif')
            ->where('status_kurasi', 'selesai')
            ->orderBy('tanggal_kurasi', 'desc');

        // Kurator hanya diperbolehkan melihat hasil kurasi yang ditugaskan kepadanya
        if ($user->role === 'kurator') {
            $query->where('id_kurator', $user->id);
        }

        $periodes = $query->get();

        return view('admin.hasil.index', compact('periodes'));
    }

    /**
     * Menampilkan detail hasil kurasi (Leaderboard/peringkat) untuk periode tertentu.
     */
    public function detail($id)
    {
        $data = $this->prepareDetailData($id);

        if ($data instanceof \Illuminate\Http\RedirectResponse) {
            return $data;
        }

        return view('admin.hasil.detail', $data);
    }

    /**
     * Mencetak laporan hasil kurasi untuk periode tertentu.
     */
    public function cetak($id)
    {
        $data = $this->prepareDetailData($id);

        if ($data instanceof \Illuminate\Http\RedirectResponse) {
            return $data;
        }

        return view('admin.hasil.cetak', $data);
    }

    /**
     * Mempersiapkan data hasil kurasi menggunakan KurasiScoreService.
     */
    private function prepareDetailData($id)
    {
        $user = Auth::user();
        
        $periode = PeriodeKurasi::with(['kurator', 'ahpSesi.bobot.kriteria', 'periodeAlternatif.alternatif.legalitas'])
            ->findOrFail($id);

        // Validasi keamanan: Pastikan kurator hanya mengakses periode miliknya sendiri
        if ($user->role === 'kurator' && $periode->id_kurator !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke hasil kurasi ini.');
        }

        if ($periode->status_kurasi !== 'selesai') {
            return redirect()->route('hasil.index')->with('error', 'Hasil kurasi hanya dapat dilihat untuk periode yang sudah selesai.');
        }

        $bobots = AhpBobot::where('id_ahp_sesi', $periode->id_ahp_sesi)
            ->pluck('bobot_prioritas', 'id_kriteria');

        $kriterias = Kriteria::with('scales')->orderBy('urutan_tampil')->get();

        // Menggunakan service untuk menghitung skor dan status kelayakan retail
        $results = $this->scoreService->calculateResults($periode);

        return compact('periode', 'kriterias', 'results', 'bobots');
    }

    /**
     * Melakukan validasi manual atas produk "Layak Retail Bersyarat" menjadi "Layak Retail"
     */
    public function validateOverride(Request $request, $id_periode, $id_alternatif)
    {
        $user = Auth::user();
        $periode = PeriodeKurasi::findOrFail($id_periode);

        // Keamanan: Hanya kurator periode ini atau admin yang bisa memvalidasi
        if ($user->role === 'kurator' && $periode->id_kurator !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk memvalidasi hasil ini.');
        }

        $request->validate([
            'status_override' => 'required|in:layak_retail,layak_retail_bersyarat',
            'komentar_override' => 'required_if:status_override,layak_retail|nullable|string|max:1000',
        ], [
            'status_override.required' => 'Keputusan validasi wajib dipilih.',
            'status_override.in' => 'Keputusan validasi tidak sah.',
            'komentar_override.required_if' => 'Catatan komentar validasi wajib diisi untuk status Layak Retail.',
        ]);

        $pa = PeriodeAlternatif::where('id_periode_kurasi', $id_periode)
            ->where('id_alternatif', $id_alternatif)
            ->firstOrFail();

        // Hitung hasil saat ini untuk memastikan statusnya layak_retail_bersyarat
        $results = $this->scoreService->calculateResults($periode);
        $productRes = collect($results)->firstWhere('alternatif.id_alternatif', $id_alternatif);

        if (!$productRes || $productRes->status_rekomendasi !== 'layak_retail_bersyarat') {
            return redirect()->back()->with('error', 'Hanya produk dengan rekomendasi Layak Retail Bersyarat yang dapat divalidasi.');
        }

        $pa->update([
            'status_override' => $request->status_override,
            'komentar_override' => $request->status_override === 'layak_retail' ? $request->komentar_override : null,
        ]);

        return redirect()->back()->with('success', 'Status produk berhasil divalidasi.');
    }

    /**
     * Membatalkan validasi manual
     */
    public function cancelOverride($id_periode, $id_alternatif)
    {
        $user = Auth::user();
        $periode = PeriodeKurasi::findOrFail($id_periode);

        if ($user->role === 'kurator' && $periode->id_kurator !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan validasi ini.');
        }

        $pa = PeriodeAlternatif::where('id_periode_kurasi', $id_periode)
            ->where('id_alternatif', $id_alternatif)
            ->firstOrFail();

        $pa->update([
            'status_override' => null,
            'komentar_override' => null,
        ]);

        return redirect()->back()->with('success', 'Validasi berhasil dibatalkan. Status kembali ke rekomendasi SPK.');
    }
}
