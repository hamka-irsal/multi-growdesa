<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SuratResource extends JsonResource
{
    public $success;
    public $message;

    /**
     * Constructor Resource
     */
    public function __construct(
        $success,
        $message,
        $resource
    ) {
        parent::__construct($resource);

        $this->success = $success;
        $this->message = $message;
    }

    /**
     * Transform data surat
     */
    public function toArray(Request $request): array
    {
        /**
         * Ambil data jenis surat
         */
        $jenisSurat = $this->jenisSurat;

        /**
         * Ambil konfigurasi surat
         *
         * Contoh:
         * config('surat.Surat Pengantar')
         */
        $config = [];

        if ($jenisSurat) {
            $config = config(
                'surat.' . $jenisSurat->nama_jenis,
                []
            );
        }

        /**
         * Ambil model detail surat
         * dari SuratConfig
         */
        $model = $config['model'] ?? null;

        /**
         * Ambil detail surat
         */
        $detailSurat = null;

        if (
            !empty($model) &&
            class_exists($model)
        ) {
            $detailSurat = $model::where(
                'surat_id',
                $this->id
            )->first();
        }

        /**
         * Ambil data tambahan
         * berdasarkan field pada config
         */
        $dataTambahan = [];

        if ($detailSurat) {
            foreach (
                $config['fields'] ?? []
                as $field
            ) {
                $dataTambahan[$field] =
                    $detailSurat->{$field} ?? null;
            }
        }

        /**
         * Cek ketersediaan file PDF
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
            | Informasi Utama Surat
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'kode_unik' =>
                $this->kode_unik,

            'no_surat' =>
                $this->no_surat,

            'nama_lengkap' =>
                $this->nama_lengkap,

            /*
            |--------------------------------------------------------------------------
            | Jenis Surat
            |--------------------------------------------------------------------------
            */

            'jenis_surat' => [

                'id' =>
                    $jenisSurat?->id,

                'nama_jenis' =>
                    $config['nama_jenis']
                    ?? $jenisSurat?->nama_jenis,

                'slug' =>
                    $config['slug']
                    ?? null,

                'icon' =>
                    $config['icon']
                    ?? null,

                'color' =>
                    $config['color']
                    ?? null,

            ],

            /*
            |--------------------------------------------------------------------------
            | Status Surat
            |--------------------------------------------------------------------------
            */

            'status_surat' =>
                $this->status_surat,

            'status_label' =>
                $this->getStatusLabel(
                    $this->status_surat
                ),

            /*
            |--------------------------------------------------------------------------
            | Tanggal Surat
            |--------------------------------------------------------------------------
            */

            'tanggal_pengajuan' =>
                $this->tanggal_pengajuan,

            'tanggal_dibuat' =>
                $this->tanggal_dibuat,

            /*
            |--------------------------------------------------------------------------
            | Informasi Admin
            |--------------------------------------------------------------------------
            */

            'persetujuan' =>
                $this->persetujuan,

            'dibuat_oleh' =>
                $this->dibuat_oleh,

            'keterangan' =>
                $this->keterangan,

            /*
            |--------------------------------------------------------------------------
            | File Surat PDF
            |--------------------------------------------------------------------------
            */

            'file_surat' => [

                'tersedia' =>
                    $fileTersedia,

                'url' =>
                    $fileTersedia
                        ? asset(
                            'storage/' .
                            $this->file_surat
                        )
                        : null,

            ],

            /*
            |--------------------------------------------------------------------------
            | Data Tambahan Berdasarkan Jenis Surat
            |--------------------------------------------------------------------------
            */

            'data_tambahan' =>
                $dataTambahan,

            /*
            |--------------------------------------------------------------------------
            | Waktu Sistem
            |--------------------------------------------------------------------------
            */

            'created_at' =>
                $this->created_at,

            'updated_at' =>
                $this->updated_at,

        ];
    }

    /**
     * Tambahkan success dan message
     * ke response API
     */
    public function with(Request $request): array
    {
        return [

            'success' =>
                $this->success,

            'message' =>
                $this->message,

        ];
    }

    /**
     * Label status surat
     */
    private function getStatusLabel(
        ?string $status
    ): string {

        return match ($status) {

            'proses' =>
                'Sedang Diproses',

            'selesai' =>
                'Selesai',

            'tolak' =>
                'Ditolak',

            default =>
                ucfirst(
                    $status ?? '-'
                ),

        };
    }
}
