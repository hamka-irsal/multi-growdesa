<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SuratRiwayatResource extends JsonResource
{
    /**
     * Transform data riwayat surat.
     */
    public function toArray(Request $request): array
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data jenis surat dari relasi
        |--------------------------------------------------------------------------
        */

        $jenisSurat = $this->jenisSurat;

        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi tambahan surat
        |--------------------------------------------------------------------------
        */

        $config = [];

        if ($jenisSurat) {
            $config = config(
                'surat.' . $jenisSurat->nama,
                []
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek apakah file PDF tersedia
        |--------------------------------------------------------------------------
        */

        $fileTersedia = (
            $this->status_surat === 'selesai'
            && !empty($this->file_surat)
            && Storage::disk('public')->exists(
                $this->file_surat
            )
        );

        return [

            /*
            |--------------------------------------------------------------------------
            | Informasi Surat
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'kode_unik' => $this->kode_unik,

            'no_surat' => $this->no_surat,

            'nama_lengkap' => $this->nama_lengkap,

            /*
            |--------------------------------------------------------------------------
            | Jenis Surat
            |--------------------------------------------------------------------------
            */

            'jenis_surat' => [

                'id' => $jenisSurat?->id,

                /*
                 * Nama jenis surat langsung dari database.
                 */
                'nama' => $jenisSurat?->nama_jenis ?? '-',

                /*
                 * Data tambahan dari config/surat.php.
                 */
                'slug' => $config['slug'] ?? null,

                'icon' => $config['icon'] ?? null,

                'color' => $config['color'] ?? null,

            ],

            /*
            |--------------------------------------------------------------------------
            | Status Surat
            |--------------------------------------------------------------------------
            */

            'status_surat' => $this->status_surat,

            'status_label' => $this->getStatusLabel(
                $this->status_surat
            ),

            /*
            |--------------------------------------------------------------------------
            | Tanggal Pengajuan
            |--------------------------------------------------------------------------
            */

            'tanggal_pengajuan' => $this->tanggal_pengajuan,

            /*
            |--------------------------------------------------------------------------
            | File Surat PDF
            |--------------------------------------------------------------------------
            */

            'file_surat' => [

                'tersedia' => $fileTersedia,

                'url' => $fileTersedia
                    ? asset(
                        'storage/' .
                        $this->file_surat
                    )
                    : null,

            ],

        ];
    }

    /**
     * Mendapatkan label status surat.
     */
    private function getStatusLabel(
        ?string $status
    ): string {
        return match ($status) {

            'proses' => 'Sedang Diproses',

            'selesai' => 'Selesai',

            'tolak' => 'Ditolak',

            default => ucfirst(
                $status ?? '-'
            ),

        };
    }
}
