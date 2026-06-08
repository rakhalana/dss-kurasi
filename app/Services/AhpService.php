<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\AhpSesi;
use App\Models\AhpPerbandingan;
use App\Models\AhpBobot;
use Illuminate\Support\Facades\DB;

/**
 * Class AhpService
 * Menangani logika perhitungan Analytical Hierarchy Process (AHP).
 */
class AhpService
{
    /**
     * Memformat nilai desimal menjadi string pecahan (misal: 0.333 menjadi '1/3').
     */
    public function formatFraction($val)
    {
        if (abs($val - 1) < 0.0001) return '1';
        elseif (abs($val - 3) < 0.0001) return '3';
        elseif (abs($val - 5) < 0.0001) return '5';
        elseif (abs($val - 7) < 0.0001) return '7';
        elseif (abs($val - 9) < 0.0001) return '9';
        elseif (abs($val - (1/3)) < 0.0001) return '1/3';
        elseif (abs($val - (1/5)) < 0.0001) return '1/5';
        elseif (abs($val - (1/7)) < 0.0001) return '1/7';
        elseif (abs($val - (1/9)) < 0.0001) return '1/9';
        return '1';
    }

    /**
     * Merekonstruksi matriks perbandingan dan bobot untuk ditampilkan.
     */
    public function calculateMatrixAndBobotPreview($kriterias, $activeSesi, $perbandinganData)
    {
        $hasilAhp = [
            'sesi' => $activeSesi,
            'matrix' => [],
            'normalized' => [],
            'bobot' => [],
            'colSum' => [],
        ];

        $n = count($kriterias);

        // Merekonstruksi matriks perbandingan kriteria berukuran NxN
        foreach ($kriterias as $k1) {
            $hasilAhp['matrix'][$k1->id_kriteria] = [];
            $colSum = 0;
            foreach ($kriterias as $k2) {
                if ($k1->id_kriteria == $k2->id_kriteria) {
                    $val = 1.0;
                } else {
                    if (isset($perbandinganData[$k1->id_kriteria][$k2->id_kriteria])) {
                        $val = $perbandinganData[$k1->id_kriteria][$k2->id_kriteria];
                    } elseif (isset($perbandinganData[$k2->id_kriteria][$k1->id_kriteria])) {
                        $val = 1.0 / $perbandinganData[$k2->id_kriteria][$k1->id_kriteria];
                    } else {
                        $val = 1.0;
                    }
                }
                $hasilAhp['matrix'][$k1->id_kriteria][$k2->id_kriteria] = $val;
            }
        }

        foreach ($kriterias as $k2) {
            $sum = 0;
            foreach ($kriterias as $k1) {
                $sum += $hasilAhp['matrix'][$k1->id_kriteria][$k2->id_kriteria];
            }
            $hasilAhp['colSum'][$k2->id_kriteria] = $sum;
        }

        // Menghitung nilai matriks normalisasi dan mengambil bobot prioritas kriteria
        if ($activeSesi->bobot->isNotEmpty()) {
            foreach ($kriterias as $k1) {
                foreach ($kriterias as $k2) {
                    $hasilAhp['normalized'][$k1->id_kriteria][$k2->id_kriteria] = 
                        $hasilAhp['matrix'][$k1->id_kriteria][$k2->id_kriteria] / $hasilAhp['colSum'][$k2->id_kriteria];
                }
                $b = $activeSesi->bobot->where('id_kriteria', $k1->id_kriteria)->first();
                $hasilAhp['bobot'][$k1->id_kriteria] = $b ? $b->bobot_prioritas : 0;
            }
        } else {
            // Jika bobot belum tersimpan (karena CR > 0.1), hitung secara manual hanya untuk ditampilkan sebagai preview
            foreach ($kriterias as $k1) {
                $rowSum = 0;
                foreach ($kriterias as $k2) {
                    $normVal = $hasilAhp['matrix'][$k1->id_kriteria][$k2->id_kriteria] / $hasilAhp['colSum'][$k2->id_kriteria];
                    $hasilAhp['normalized'][$k1->id_kriteria][$k2->id_kriteria] = $normVal;
                    $rowSum += $normVal;
                }
                $hasilAhp['bobot'][$k1->id_kriteria] = $rowSum / $n;
            }
        }

        return $hasilAhp;
    }

    /**
     * Melakukan perhitungan AHP dan menyimpannya ke database.
     */
    public function calculateAndSave(array $inputPairs, $userId)
    {
        $kriterias = Kriteria::orderBy('id_kriteria')->get();
        $n = count($kriterias);

        if ($n < 2) {
            throw new \Exception('Kriteria minimal harus ada 2.');
        }

        DB::beginTransaction();
        try {
            $activeSesi = AhpSesi::where('status_aktif', true)->first();
            if (!$activeSesi) {
                $activeSesi = AhpSesi::create([
                    'nama_sesi' => 'Penilaian Bobot ' . date('Y-m-d H:i'),
                    'tanggal_sesi' => date('Y-m-d'),
                    'status_aktif' => true,
                    'dibuat_oleh' => $userId ?? 1
                ]);
            } else {
                $activeSesi->update([
                    'nama_sesi' => 'Penilaian Bobot ' . date('Y-m-d H:i'),
                    'tanggal_sesi' => date('Y-m-d'),
                    'dibuat_oleh' => $userId ?? 1
                ]);
                AhpPerbandingan::where('id_ahp_sesi', $activeSesi->id_ahp_sesi)->delete();
                AhpBobot::where('id_ahp_sesi', $activeSesi->id_ahp_sesi)->delete();
            }

            $matrix = [];
            
            foreach ($kriterias as $k) {
                $matrix[$k->id_kriteria] = [];
            }
            
            foreach ($kriterias as $i => $k1) {
                foreach ($kriterias as $j => $k2) {
                    if ($i == $j) {
                        $matrix[$k1->id_kriteria][$k2->id_kriteria] = 1.0;
                    } elseif ($i < $j) {
                        $valStr = isset($inputPairs[$k1->id_kriteria][$k2->id_kriteria]) ? $inputPairs[$k1->id_kriteria][$k2->id_kriteria] : '1';
                        if (strpos($valStr, '/') !== false) {
                            $parts = explode('/', $valStr);
                            $val = (float)$parts[0] / (float)$parts[1];
                        } else {
                            $val = (float)$valStr;
                        }
                        $matrix[$k1->id_kriteria][$k2->id_kriteria] = $val;
                        $matrix[$k2->id_kriteria][$k1->id_kriteria] = 1.0 / $val;

                        AhpPerbandingan::create([
                            'id_ahp_sesi' => $activeSesi->id_ahp_sesi,
                            'kriteria_1_id' => $k1->id_kriteria,
                            'kriteria_2_id' => $k2->id_kriteria,
                            'nilai_perbandingan' => $val
                        ]);
                    }
                }
            }

            $colSum = [];
            foreach ($kriterias as $k2) {
                $sum = 0;
                foreach ($kriterias as $k1) {
                    $sum += $matrix[$k1->id_kriteria][$k2->id_kriteria];
                }
                $colSum[$k2->id_kriteria] = $sum;
            }

            $bobot = [];
            foreach ($kriterias as $k1) {
                $rowSum = 0;
                foreach ($kriterias as $k2) {
                    $norm = $matrix[$k1->id_kriteria][$k2->id_kriteria] / $colSum[$k2->id_kriteria];
                    $rowSum += $norm;
                }
                $bobot[$k1->id_kriteria] = $rowSum / $n;
            }

            // Melakukan uji konsistensi (Menghitung Lambda Max)
            $lambdaMax = 0;
            foreach ($kriterias as $k1) {
                $lambdaMax += $colSum[$k1->id_kriteria] * $bobot[$k1->id_kriteria];
            }

            // Menghitung Consistency Index (CI)
            $ci = ($lambdaMax - $n) / ($n - 1);
            
            // Daftar nilai Random Index (RI) standar untuk matriks berukuran 1 sampai 15
            $riArray = [0, 0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57];
            $ri = $riArray[$n] ?? 1.45;
            
            // Menghitung Consistency Ratio (CR)
            $cr = $ri == 0 ? 0 : $ci / $ri;

            $activeSesi->update([
                'lambda_max' => $lambdaMax,
                'ci' => $ci,
                'cr' => $cr
            ]);

            // Menyimpan bobot kriteria secara permanen HANYA JIKA matriks perbandingan dinilai konsisten (CR <= 0.1)
            $isConsistent = $cr <= 0.1;
            if ($isConsistent) {
                foreach ($kriterias as $k1) {
                    AhpBobot::create([
                        'id_ahp_sesi' => $activeSesi->id_ahp_sesi,
                        'id_kriteria' => $k1->id_kriteria,
                        'bobot_prioritas' => $bobot[$k1->id_kriteria]
                    ]);
                }
            }
            
            DB::commit();

            return [
                'success' => true,
                'is_consistent' => $isConsistent,
                'cr' => $cr
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
