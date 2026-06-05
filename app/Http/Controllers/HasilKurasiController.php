<?php

namespace App\Http\Controllers;

use App\Models\PeriodeKurasi;
use App\Models\Kriteria;
use App\Models\AhpBobot;
use App\Services\KurasiScoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilKurasiController extends Controller
{
    protected $scoreService;

    public function __construct(KurasiScoreService $scoreService)
    {
        $this->scoreService = $scoreService;
    }

    // Menampilkan daftar periode kurasi yang sudah selesai
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

    // Menampilkan detail hasil kurasi (Leaderboard/peringkat) untuk periode tertentu
    public function detail($id)
    {
        $data = $this->prepareDetailData($id);

        if ($data instanceof \Illuminate\Http\RedirectResponse) {
            return $data;
        }

        return view('admin.hasil.detail', $data);
    }

    // Mencetak laporan hasil kurasi untuk periode tertentu
    public function cetak($id)
    {
        $data = $this->prepareDetailData($id);

        if ($data instanceof \Illuminate\Http\RedirectResponse) {
            return $data;
        }

        return view('admin.hasil.cetak', $data);
    }

    // Mempersiapkan data hasil kurasi menggunakan KurasiScoreService
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
}
