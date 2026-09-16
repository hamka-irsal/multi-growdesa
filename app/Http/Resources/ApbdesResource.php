<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApbdesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /*
        |--------------------------------------------------------------------------
        | Nilai Dasar
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = (float) ($this->total_pendapatan ?? 0);
        $realisasiPendapatan = (float) ($this->realisasi_pendapatan ?? 0);

        $totalBelanja = (float) ($this->total_belanja ?? 0);
        $realisasiBelanja = (float) ($this->realisasi_belanja ?? 0);

        $totalPembiayaan = (float) ($this->total_pembiayaan ?? 0);
        $realisasiPembiayaan = (float) ($this->realisasi_pembiayaan ?? 0);

        $silpaTahunLalu = (float) ($this->silpa_tahun_lalu ?? 0);

        $pemerintahan = (float) ($this->pemerintahan ?? 0);
        $pembangunan = (float) ($this->pembangunan ?? 0);
        $pemberdayaan = (float) ($this->pemberdayaan ?? 0);
        $lainnya = (float) ($this->lainnya ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Persentase Realisasi
        |--------------------------------------------------------------------------
        */

        $persentaseRealisasiPendapatan = $totalPendapatan > 0
            ? round(($realisasiPendapatan / $totalPendapatan) * 100, 1)
            : 0;

        $persentaseRealisasiBelanja = $totalBelanja > 0
            ? round(($realisasiBelanja / $totalBelanja) * 100, 1)
            : 0;

        $persentaseRealisasiPembiayaan = $totalPembiayaan > 0
            ? round(($realisasiPembiayaan / $totalPembiayaan) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Total Alokasi Belanja
        |--------------------------------------------------------------------------
        */

        $totalAlokasiBelanja =
            $pemerintahan +
            $pembangunan +
            $pemberdayaan +
            $lainnya;

        /*
        |--------------------------------------------------------------------------
        | Persentase Alokasi Belanja
        |--------------------------------------------------------------------------
        */

        $persentasePemerintahan = $totalAlokasiBelanja > 0
            ? round(($pemerintahan / $totalAlokasiBelanja) * 100, 1)
            : 0;

        $persentasePembangunan = $totalAlokasiBelanja > 0
            ? round(($pembangunan / $totalAlokasiBelanja) * 100, 1)
            : 0;

        $persentasePemberdayaan = $totalAlokasiBelanja > 0
            ? round(($pemberdayaan / $totalAlokasiBelanja) * 100, 1)
            : 0;

        $persentaseLainnya = $totalAlokasiBelanja > 0
            ? round(($lainnya / $totalAlokasiBelanja) * 100, 1)
            : 0;

        return [
            /*
            |--------------------------------------------------------------------------
            | Identitas
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'tahun' => $this->tahun,

            'judul' => 'Anggaran Tahun ' . $this->tahun,

            /*
            |--------------------------------------------------------------------------
            | Pendapatan
            |--------------------------------------------------------------------------
            */

            'pendapatan' => [
                'total' => $this->total_pendapatan,
                'total_format' => 'Rp ' . number_format(
                    $totalPendapatan,
                    0,
                    ',',
                    '.'
                ),

                'realisasi' => $this->realisasi_pendapatan,
                'realisasi_format' => 'Rp ' . number_format(
                    $realisasiPendapatan,
                    0,
                    ',',
                    '.'
                ),

                'persentase_realisasi' => $persentaseRealisasiPendapatan,
                'persentase_realisasi_format' =>
                    $persentaseRealisasiPendapatan . '%',
            ],

            /*
            |--------------------------------------------------------------------------
            | Belanja
            |--------------------------------------------------------------------------
            */

            'belanja' => [
                'total' => $this->total_belanja,
                'total_format' => 'Rp ' . number_format(
                    $totalBelanja,
                    0,
                    ',',
                    '.'
                ),

                'realisasi' => $this->realisasi_belanja,
                'realisasi_format' => 'Rp ' . number_format(
                    $realisasiBelanja,
                    0,
                    ',',
                    '.'
                ),

                'persentase_realisasi' => $persentaseRealisasiBelanja,
                'persentase_realisasi_format' =>
                    $persentaseRealisasiBelanja . '%',
            ],

            /*
            |--------------------------------------------------------------------------
            | Pembiayaan
            |--------------------------------------------------------------------------
            */

            'pembiayaan' => [
                'total' => $this->total_pembiayaan,
                'total_format' => 'Rp ' . number_format(
                    $totalPembiayaan,
                    0,
                    ',',
                    '.'
                ),

                'realisasi' => $this->realisasi_pembiayaan,
                'realisasi_format' => 'Rp ' . number_format(
                    $realisasiPembiayaan,
                    0,
                    ',',
                    '.'
                ),

                'persentase_realisasi' => $persentaseRealisasiPembiayaan,
                'persentase_realisasi_format' =>
                    $persentaseRealisasiPembiayaan . '%',
            ],

            /*
            |--------------------------------------------------------------------------
            | SILPA
            |--------------------------------------------------------------------------
            */

            'silpa_tahun_lalu' => $this->silpa_tahun_lalu,

            'silpa_tahun_lalu_format' => 'Rp ' . number_format(
                $silpaTahunLalu,
                0,
                ',',
                '.'
            ),

            /*
            |--------------------------------------------------------------------------
            | Proporsi Alokasi Belanja
            |--------------------------------------------------------------------------
            */

            'alokasi_belanja' => [
                'total' => $totalAlokasiBelanja,

                'total_format' => 'Rp ' . number_format(
                    $totalAlokasiBelanja,
                    0,
                    ',',
                    '.'
                ),

                'pemerintahan' => [
                    'nominal' => $this->pemerintahan,
                    'nominal_format' => 'Rp ' . number_format(
                        $pemerintahan,
                        0,
                        ',',
                        '.'
                    ),
                    'persentase' => $persentasePemerintahan,
                    'persentase_format' =>
                        $persentasePemerintahan . '%',
                ],

                'pembangunan' => [
                    'nominal' => $this->pembangunan,
                    'nominal_format' => 'Rp ' . number_format(
                        $pembangunan,
                        0,
                        ',',
                        '.'
                    ),
                    'persentase' => $persentasePembangunan,
                    'persentase_format' =>
                        $persentasePembangunan . '%',
                ],

                'pemberdayaan' => [
                    'nominal' => $this->pemberdayaan,
                    'nominal_format' => 'Rp ' . number_format(
                        $pemberdayaan,
                        0,
                        ',',
                        '.'
                    ),
                    'persentase' => $persentasePemberdayaan,
                    'persentase_format' =>
                        $persentasePemberdayaan . '%',
                ],

                'lainnya' => [
                    'nominal' => $this->lainnya,
                    'nominal_format' => 'Rp ' . number_format(
                        $lainnya,
                        0,
                        ',',
                        '.'
                    ),
                    'persentase' => $persentaseLainnya,
                    'persentase_format' =>
                        $persentaseLainnya . '%',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => $this->status,

            /*
            |--------------------------------------------------------------------------
            | Timestamp
            |--------------------------------------------------------------------------
            */

            'created_at' => $this->created_at?->toDateTimeString(),

            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}