<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\AhpSesi;
use App\Models\AhpPerbandingan;
use App\Models\AhpBobot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BobotKriteriaController extends Controller
{
    protected $ahpService;

    /**
     * Constructor untuk injeksi AhpService.
     */
    public function __construct(\App\Services\AhpService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    /**
     * Menampilkan antarmuka perbandingan berpasangan kriteria beserta hasil perhitungannya.
     */
    public function index()
    {
        $kriterias = Kriteria::orderBy('id_kriteria')->get();
        $activeSesi = AhpSesi::with(['perbandingan', 'bobot'])->where('status_aktif', true)->first();
        
        $perbandinganData = [];
        if ($activeSesi && $activeSesi->perbandingan->isNotEmpty()) {
            foreach ($activeSesi->perbandingan as $p) {
                $perbandinganData[$p->kriteria_1_id][$p->kriteria_2_id] = $p->nilai_perbandingan;
            }
        }

        $pairs = [];
        $n = count($kriterias);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $k1 = $kriterias[$i];
                $k2 = $kriterias[$j];
                
                $val = 1;
                if (isset($perbandinganData[$k1->id_kriteria][$k2->id_kriteria])) {
                    $val = $perbandinganData[$k1->id_kriteria][$k2->id_kriteria];
                } elseif (isset($perbandinganData[$k2->id_kriteria][$k1->id_kriteria])) {
                    $val = 1 / $perbandinganData[$k2->id_kriteria][$k1->id_kriteria];
                }

                $pairs[] = [
                    'k1' => $k1,
                    'k2' => $k2,
                    'value' => $this->ahpService->formatFraction($val)
                ];
            }
        }

        $hasilAhp = null;
        if ($activeSesi) {
            $hasilAhp = $this->ahpService->calculateMatrixAndBobotPreview($kriterias, $activeSesi, $perbandinganData);
        }

        return view('admin.bobot', compact('kriterias', 'pairs', 'hasilAhp', 'activeSesi'));
    }

    /**
     * Melakukan perhitungan AHP berdasarkan input perbandingan dari formulir admin.
     */
    public function calculate(Request $request)
    {
        $inputPairs = $request->input('pair', []);

        try {
            $result = $this->ahpService->calculateAndSave($inputPairs, Auth::id());

            if ($result['is_consistent']) {
                $msg = 'Bobot AHP berhasil dihitung dan disimpan secara permanen. Nilai CR konsisten ('.number_format($result['cr'], 3).').';
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => $msg]);
                }
                return redirect()->route('admin.bobot.index')->with('success', $msg);
            } else {
                $msg = 'Peringatan: Nilai Consistency Ratio (CR) tidak konsisten ('.number_format($result['cr'], 3).'). Batas maksimal adalah 0.1. Bobot TIDAK TERSIMPAN, silakan sesuaikan ulang perbandingan kriteria.';
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $msg]);
                }
                return redirect()->route('admin.bobot.index')->with('error', $msg);
            }

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
